<?php

	########################################################################

	function whosonfirst_media_depicts_add_depiction(&$media, &$place, &$user){

		$now = time();

		$props = array();
		$str_props = json_encode($str_props);

		$depicts = array(
			"media_id" => $media["id"],
			"whosonfirst_id" => $place["wof:id"],
			"user_id" => $user["id"],
			"status_id" => $media["status_id"],
			"properties" => $str_props,
			"created" => $now,
			"lastmodified" => $now,
		);

		# return array("ok" => 1, "depicts" => $depicts);

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

	function whosonfirst_media_depicts_for_media(&$media, $viewer_id=0, $more=array()){

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

	function whosonfirst_media_depicts_for_place(&$place, $viewer_id=0, $more=array()){

		$enc_id = AddSlashes($place["wof:id"]);

		$where = array(
			"whosonfirst_id='{$enc_id}'",
		);

		if ($extra = whosonfirst_media_permissions_get_media_where($viewer_id)){
			$where[] = $extra;
		}  

		$where = implode(" AND ", $where);

		$sql = "SELECT DISTINCT(media_id) FROM whosonfirst_media_depicts WHERE {$where}";
		return db_fetch_paginated($sql, $more);
	}

	########################################################################

	# the end