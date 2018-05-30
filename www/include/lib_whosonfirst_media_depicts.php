<?php

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
		return db_write("whosonfirst_media_depicts", $sql);
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

	# the end