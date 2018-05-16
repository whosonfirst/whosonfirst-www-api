<?php

	loadlib("whosonfirst_places");

	########################################################################

	function uploads_status_map($string_keys="") {

		$map = array(
			0 => "failed",
			1 => "pending",
			2 => "processing",
			3 => "completed",
		);

		if ($string_keys){
			$map = array_flip($map);
		}

		return $map;
	}

	########################################################################

	function uploads_status_id_to_label($id){

		$map = uploads_status_map();
		return (isset($map[$id])) ? $map[$id] : "unknown";
	}

	########################################################################

	function uploads_get_uploads($more=array()){

		$sql = "SELECT * FROM Uploads ORDER BY created DESC";
		$rsp = db_fetch($sql, $more);

		return $rsp;
	}

	########################################################################

	function uploads_create($user, $file, $props){

		$pending = $GLOBALS["cfg"]["uploads_pending_dir"];

		if ((! $pending) || (! is_dir($pending))){
			return array("ok" => 0, "error" => "Invalid pending directory");
		}

		$tmp_file = $file["tmp_name"];

		if (! file_exists($tmp_file)){
			return array("ok" => 0, "error" => "Upload has vanished");		
		}

		$id = dbtickets_create(64);

		$root = uploads_id2tree($id);
		$root = $pending . DIRECTORY_SEPARATOR . $root;

		if (! is_dir($root)){

			$recursive = true;

			if (! mkdir($root, 0700, $recursive)){
				return array("ok" => 0, "error" => "Failed to create pending (sub) directory");
			}
		}
		
		$pending_file = $root . DIRECTORY_SEPARATOR . $id;

		if (file_exists($pending_file)){
			return array("ok" => 0, "error" => "Upload already exists");
		}

		if ($file["isnot_upload"]){

			if (! rename($tmp_file, $pending_file)){
				return array("ok" => 0, "error" => "Failed to move pending file FOO");
			}
		}

		else {

			if (! move_uploaded_file($tmp_file, $pending_file)){
				return array("ok" => 0, "error" => "Failed to move pending file WHAT");
			}
		}

		$fingerprint = sha1_file($pending_file);
		$remote_addr = remote_addr_as_int();

		$status_map = uploads_status_map("string keys");
		$now = time();

		$upload = array(
			"id" => $id, 
			"user_id" => $user["id"],
			"remote_addr" => $remote_addr,
			"fingerprint" => $fingerprint,
			"created" => $now,
			"lastmodified" => $now,
			"file" => json_encode($file),
			"properties" => json_encode($props),
			"status_id" => $status_map["pending"]
		);

		$insert = array();

		foreach ($upload as $k => $v){
			$insert[$k] = AddSlashes($v);
		}

		$rsp = db_insert("Uploads", $insert);

		if (!$rsp["ok"]){
			unlink($pending_file);
			return $rsp;
		} 

		$rsp["upload"] = $upload;
		return $rsp;
	}

	########################################################################

	function uploads_update_upload(&$upload, $to_update){

		$now = time();
		$to_update["lastmodified"] = $now;

		$update = array();

		foreach ($to_update as $k => $v){
			$update[$k] = AddSlashes($v);
		}

		$enc_id = AddSlashes($upload["id"]);
		$where = "id='{$enc_id}'";

		$rsp = db_update("Uploads", $update, $where);

		if ($rsp["ok"]){
			$upload = array_merge($upload, $update);
			$rsp["upload"] = $upload;
		}

		return $rsp;
	}

	########################################################################

	function uploads_set_processing(&$upload){

		$status_map = uploads_status_map("string keys");

		$update = array(
			"status_id" => $status_map["processing"]
		);

		return uploads_update_upload($upload, $update);
	}

	########################################################################

	function uploads_set_completed(&$upload){

		$status_map = uploads_status_map("string keys");

		$now = time();

		$update = array(
			"status_id" => $status_map["completed"],
			"completed" => $now,
		);

		return uploads_update_upload($upload, $update);
	}

	########################################################################

	function uploads_set_failed(&$upload, $error){

		$status_map = uploads_status_map("string keys");

		$update = array(
			"status_id" => $status_map["failed"],
			"error" => json_encode($error),
		);

		return uploads_update_upload($upload, $update);
	}

	########################################################################

	function uploads_can_process(&$upload){

		if (uploads_is_processing($upload)){
			return 0;
		}

		if (uploads_is_completed($upload)){
			return 0;
		}

		if (uploads_is_failed($upload)){
			return 0;
		}

		return 1;
	}

	########################################################################

	function uploads_is_processing(&$upload){

		$status_map = uploads_status_map();
		$status_id = $upload["status_id"];

		return ($status_map[$status_id] == "processing") ? 1 : 0;
	}

	########################################################################

	function uploads_is_completed(&$upload){

		$status_map = uploads_status_map();
		$status_id = $upload["status_id"];

		return ($status_map[$status_id] == "completed") ? 1 : 0;
	}

	########################################################################

	function uploads_is_failed(&$upload){

		$status_map = uploads_status_map();
		$status_id = $upload["status_id"];

		return ($status_map[$status_id] == "failed") ? 1 : 0;
	}

	########################################################################

	function uploads_get_by_id($id){

		$sql = "SELECT * FROM Uploads WHERE id=" . intval($id);

		$rsp = db_fetch($sql);
		$upload = db_single($rsp);

		return $upload;
	}

	########################################################################

	function uploads_id2abspath($id){

		$pending = $GLOBALS["cfg"]["uploads_pending_dir"];
		$rel_path = uploads_id2relpath($id);

		return $pending . DIRECTORY_SEPARATOR . $rel_path;
	}

	########################################################################

	function uploads_id2relpath($id){

		 $tree = uploads_id2tree($id);
		 $fname = $id;

		 return $tree . DIRECTORY_SEPARATOR . $id;
	}

	########################################################################

	function uploads_id2tree($id){

		$tree = array();
		$tmp = $id;

		while (strlen($tmp)){

			$slice = substr($tmp, 0, 3);
			array_push($tree, $slice);

			$tmp = substr($tmp, 3);
		}

		return implode(DIRECTORY_SEPARATOR, $tree);
	}

	########################################################################

	function uploads_enpublicify_upload(&$upload){

		$public = array(
			"id" => $upload["id"],
			"created" => $upload["created"],
			"lastmodified" => $upload["lastmodified"],
			"processings" => $upload["processing"],
			"status_id" => $upload["status_id"],
		);

		if ($upload["status_id"] == 0){
			$error = json_decode($upload["error"]);
			$public["error"] = $error;
		}
		
		return $public;
	}

	########################################################################

	function uploads_inflate_uploads(&$uploads){

		foreach ($uploads as &$u){
			uploads_inflate_upload($u);
		}
	}

	########################################################################

	function uploads_inflate_upload(&$upload){

		$upload["user"] = users_get_by_id($upload["user_id"]);

		$upload["file"] = json_decode($upload["file"], "as hash");
		$upload["properties"] = json_decode($upload["properties"], "as hash");

		if ($upload["error"]){
			$upload["error"] = json_decode($upload["error"], "as hash");			
		}

		$wof_id = $upload["properties"]["whosonfirst_id"];

		if (($wof_id) && ($wof_id > 0)){	
			$place = whosonfirst_places_get_by_id($wof_id);
			$upload["relation"] = $place;
		}

		# pass-by-ref
	}

	########################################################################

	# the end