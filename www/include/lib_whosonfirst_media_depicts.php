<?php

	########################################################################

	function whosonfirst_media_depicts_add_depictions_for_place_with_inferences(&$media, &$place, &$user, $props=array()){

		$to_depict = array(
			$place["wof:id"]
		);

		return whosonfirst_media_depicts_add_depictions_with_inferences($media, $to_depict, $user, $props);
	}

	########################################################################

	function whosonfirst_media_depicts_add_depictions_with_inferences(&$media, &$place_ids, &$user, $props=array()){

		$to_depict = array();

		foreach ($place_ids as $id){

			if (isset($to_depict[$id])){
				continue;
			}

			if ($pl = whosonfirst_places_get_by_id($id)){
				$to_depict[$id] = $pl;
			}
		}

		if (features_is_enabled("whosonfirst_media_depicts_infer_depictions")){

			foreach ($to_depict as $ignore => $place){

				$infers = whosonfirst_media_depicts_get_inferences($place);

				foreach ($infers as $id){

						if (isset($to_depict[$id])){
						continue;
					}

					$pl = whosonfirst_places_get_by_id($id);
					$to_depict[$id] = $pl;
				}
			}
		}

		foreach ($to_depict as $id => $pl){

			$rsp = whosonfirst_media_depicts_add_depiction($media, $pl, $user, $props);

			if (! $rsp["ok"]){
				return $rsp;
			}
		}

		return array("ok" => 1, "depicts" => array_keys($to_depict));
	}

	########################################################################

	function whosonfirst_media_depicts_add_depiction(&$media, &$place, &$user, $props=array()){

		$now = time();

		whosonfirst_media_inflate_media($media);

		$media_props = $media["properties"];

		$props["medium"] = $media_props["medium"];

		$str_props = json_encode($props);

		$depicts = array(
			"media_id" => $media["id"],
			"whosonfirst_id" => $place["wof:id"],
			"user_id" => $user["id"],
			"status_id" => $media["status_id"],
			"properties" => $str_props,
			"created" => $now,
			"lastmodified" => $now,
		);

		$insert = array();

		foreach ($depicts as $k => $v){
			$insert[$k] = AddSlashes($v);
		}

		$on_dupe = array(
			"lastmodified" => $insert["lastmodified"],
		);

		$rsp = db_insert_dupe("whosonfirst_media_depicts", $insert, $on_dupe);

		if ($rsp["ok"]){
			$rsp["depicts"] = $depicts;
		}

		return $rsp;
	}

	########################################################################

	function whosonfirst_media_depicts_update_depiction(&$depicts, $update){

		$now = time();

		$update["lastmodified"] = $now;

		$insert = array();

		foreach ($update as $k => $v){
			$insert[$k] = AddSlashes($v);
		}

		$enc_media = AddSlashes($depicts["media_id"]);
		$enc_wof = AddSlashes($depicts["whosonfirst_id"]);

		$where = "media_id='{$enc_media}' AND whosonfirst_id='{$enc_wof}'";

		$rsp = db_update("whosonfirst_media_depicts", $insert, $where);

		if ($rsp["ok"]){
			$depicts = array_merge($depicts, $update);
			$rsp["depiction"] = $depicts;
		}

		return $rsp;
	}

	########################################################################

	function whosonfirst_media_depicts_delete_depiction(&$depicts){

		$enc_media = AddSlashes($depicts["media_id"]);
		$enc_wof = AddSlashes($depicts["whosonfirst_id"]);

		$sql = "DELETE FROM whosonfirst_media_depicts WHERE media_id='{$enc_media}' AND whosonfirst_id='{$enc_wof}'";
		return db_write($sql);
	}

	########################################################################

	function whosonfirst_media_depicts_get_for_media_and_place(&$media, &$place){

		$enc_media = AddSlashes($media["id"]);
		$enc_wof = AddSlashes($place["wof:id"]);

		$sql = "SELECT * FROM whosonfirst_media_depicts WHERE media_id='{$enc_media}' AND whosonfirst_id='{$enc_wof}'";
		$rsp = db_fetch($sql);

		$row = db_single($rsp);
		return $row;
	}

	########################################################################

	function whosonfirst_media_depicts_set_status_for_media(&$media){

		$enc_media = AddSlashes($media["id"]);
		$enc_status = AddSlashes($media["status_id"]);

		$enc_now = AddSlashes(time());

		$update = array(
			"status_id" => $enc_status,
			"lastmodified" => $enc_now,
		);

		$where = "media_id='{$enc_media}'";

		return db_update("whosonfirst_media_depicts", $update, $where);
	}

	########################################################################

	function whosonfirst_media_depicts_delete_for_media(&$media){

		$enc_media = AddSlashes($media["id"]);

		$sql = "DELETE FROM whosonfirst_media_depicts WHERE media_id='{$enc_media}'";

		return db_write($sql);
	}

	########################################################################

	function whosonfirst_media_depicts_get_depictions_for_media(&$media, $viewer_id=0, $more=array()){

		$enc_id = AddSlashes($media["id"]);

		$where = array(
			"media_id='{$enc_id}'",
		);

		if ($extra = whosonfirst_media_permissions_get_media_where($viewer_id)){
			$where[] = $extra;
		}  

		$where = implode(" AND ", $where);

		$sql = "SELECT DISTINCT(whosonfirst_id) FROM whosonfirst_media_depicts WHERE {$where}";
		return db_fetch_paginated($sql, $more);
	}

	########################################################################

	function whosonfirst_media_depicts_get_depictions_for_place(&$place, $viewer_id=0, $more=array()){

		$defaults = array(
			"medium" => "",
			"random" => 0
		);

		$more = array_merge($defaults, $more);

		$enc_id = AddSlashes($place["wof:id"]);

		$where = array(
			"whosonfirst_id='{$enc_id}'",
		);

		if ($extra = whosonfirst_media_permissions_get_media_where($viewer_id)){
			$where[] = $extra;
		}  

		if ($medium = $more["medium"]){
			$enc_medium = AddSlashes($medium);
			$where[] = "medium='{$enc_medium}'";
		}

		$where = implode(" AND ", $where);

		$sql = "SELECT DISTINCT(media_id) FROM whosonfirst_media_depicts WHERE {$where}";

		if ($more["random"]){
			$sql .= " ORDER BY RAND()";
		}

		else {
			$sql .= " ORDER BY media_id DESC";
		}

		return db_fetch_paginated($sql, $more);
	}

	########################################################################

	# WIP... (20180530/thisisaaronland)

	function whosonfirst_media_depicts_get_other_depictions_for_place(&$place, $viewer_id, $more=array()){

		$enc_id = AddSlashes($place["wof:id"]);

		# FIX ME... PERMISSIONS... MAYBE?

		$sql = "SELECT DISTINCT(w2.whosonfirst_id) FROM whosonfirst_media_depicts w1, whosonfirst_media_depicts w2 WHERE w1.media_id=w2.media_id AND w1.whosonfirst_id='{$enc_id}' AND w2.whosonfirst_id!='{$enc_id}'";

		$rsp = db_fetch($sql);
		return $rsp;
	}

	########################################################################

	# should this function really be in this library... (20180530/thisisaaronland)

	function whosonfirst_media_depicts_get_other_places_for_depicted_place(&$place, $viewer_id, $more=array()){

		$rsp = whosonfirst_media_depicts_get_other_depictions_for_place($place, $viewer_id, $more=array());

		if (! $rsp["ok"]){
			return $rsp;
		}

		$ids = array();

		foreach ($rsp["rows"] as $row){
			$ids[] = $row["whosonfirst_id"];
		}

		return whosonfirst_places_get_by_id_multi($ids);
	}

	########################################################################

	function whosonfirst_media_depicts_get_inferences(&$place, $key=null){

		$map = $GLOBALS['cfg']['whosonfirst_media_depicts_inference_map'];

		if (! $key){
			$key = $GLOBALS['cfg']['whosonfirst_media_depicts_inference_key'];
		}

		if (! isset($place[$key])){
			return array();
		}

		$key = $place[$key];

		if (! isset($map[$key])){
			return array();
		}

		$infers = array();

		# please do not let this nest any more than it already does...
		# (20180531/thisisaaronland)

		foreach ($map[$key] as $k => $details){

			if ($k == "wof:brand_id"){

				$v = $place[$k];

				if (($v) && (! in_array($v, $infers))){
					$infers[] = $v;
				}					
			}

			else if ($k == "wof:coterminous"){

				$v = $place[$k];

				if (($v) && (! in_array($v, $infers))){
					$infers[] = $v;
				}
			}

			else if ($k == "wof:hierarchy"){

				foreach ($place["wof:hierarchy"] as $hier){

					foreach ($details as $k){

						if (! isset($hier[$k])){
							continue;
						}

						$v = $hier[$k];

						if (($v) && (! in_array($v, $infers))){
							$infers[] = $v;
						}
					}
				}
			}

			else {}
		}

		return $infers;
	}

	########################################################################

	# the end