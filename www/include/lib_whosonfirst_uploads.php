<?php

	loadlib("whosonfirst_places");

	loadlib("whosonfirst_uploads_image");
	loadlib("whosonfirst_uploads_pdf");

	########################################################################

	function whosonfirst_uploads_status_map($string_keys="") {

		$map = array(
			0 => "failed",
			1 => "pending",
			2 => "processing",
			3 => "completed",
			4 => "deleted",
		);

		if ($string_keys){
			$map = array_flip($map);
		}

		return $map;
	}

	########################################################################

	function whosonfirst_uploads_status_id_to_label($id){

		$map = whosonfirst_uploads_status_map();
		return (isset($map[$id])) ? $map[$id] : "unknown";
	}

	########################################################################

	function whosonfirst_uploads_status_label_to_id($label){

		$map = whosonfirst_uploads_status_map("string keys");
		return (isset($map[$label])) ? $map[$label] : -1;
	}

	########################################################################

	function whosonfirst_uploads_get_stats(){

		$sql = "SELECT status_id, COUNT(id) AS counts FROM whosonfirst_uploads GROUP BY status_id ORDER BY counts DESC";
		$rsp = db_fetch($sql);

		if (! $rsp["ok"]){
			return $rsp;
		}

		$status_map = whosonfirst_uploads_status_map();
		$stats = array();
		
		foreach ($rsp["rows"] as $row){
			$status = $status_map[ $row["status_id"] ];
			$stats[ $status ] = $row["counts"];
		}

		return array("ok" => 1, "stats" => $stats);
	}

	########################################################################

	function whosonfirst_uploads_get_pending_uploads($more=array()){

		$status_map = whosonfirst_uploads_status_map("pending");
		$enc_status = AddSlashes($status_map["pending"]);

		$sql = "SELECT * FROM whosonfirst_uploads WHERE status_id='{$enc_status}' ORDER BY created ASC";
		$rsp = db_fetch_paginated($sql, $more);

		return $rsp;
	}

	########################################################################

	function whosonfirst_uploads_get_uploads($more=array()){

		$where = array();

		$sql = "SELECT * FROM whosonfirst_uploads";

		if (isset($more["status_id"])){

			$enc_status = AddSlashes($more["status_id"]);
			$where[] = "status_id='{$enc_status}'";
		}

		if (count($where)){

			$where = implode($where, " AND ");
			$sql .= " WHERE {$where}";
		}

		$sql .= " ORDER BY created DESC";
		$rsp = db_fetch_paginated($sql, $more);

		return $rsp;
	}

	########################################################################

	function whosonfirst_uploads_delete_upload(&$upload){

		$status_map = whosonfirst_uploads_status_map("string keys");

		$now = time();

		$update = array(
			"deleted" => $now,
			"status_id" => $status_map["deleted"],
		);

		$rsp = whosonfirst_uploads_update_upload($upload, $update);

		if (! $rsp["ok"]){
			return $rsp;
		}

		$path = whosonfirst_uploads_id2abspath($upload["id"]);

		if (file_exists($path)){

			if (! unlink($path)){
				return array("ok" => 0, "error" => "Failed to unlink upload");
			}
		}

		return $rsp;
	}

	########################################################################

	function whosonfirst_uploads_create($user, $file, $props){

		$pending = $GLOBALS["cfg"]["whosonfirst_uploads_pending_dir"];

		if ((! $pending) || (! is_dir($pending))){
			return array("ok" => 0, "error" => "Invalid pending directory");
		}

		$tmp_file = $file["tmp_name"];

		if (! file_exists($tmp_file)){
			return array("ok" => 0, "error" => "Upload has vanished");		
		}

		# something something something it might be tempting to check whether
		# fingerprint + props.whosonfirst_id + status_id='completed' and reject
		# new uploads if true until we have to deal with someone replacing a
		# file that's been deleted post-upload... so today we won't do that
		# (20180516/thisisaaronland) 

		$id = whosonfirst_uploads_generate_id();

		$root = whosonfirst_uploads_id2tree($id);
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

		$status_map = whosonfirst_uploads_status_map("string keys");
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

		$rsp = db_insert("whosonfirst_uploads", $insert);

		if (!$rsp["ok"]){
			unlink($pending_file);
			return $rsp;
		} 

		$rsp["upload"] = $upload;
		return $rsp;
	}

	########################################################################

	function whosonfirst_uploads_update_upload(&$upload, $to_update){

		$now = time();
		$to_update["lastmodified"] = $now;

		$update = array();

		foreach ($to_update as $k => $v){
			$update[$k] = AddSlashes($v);
		}

		$enc_id = AddSlashes($upload["id"]);
		$where = "id='{$enc_id}'";

		$rsp = db_update("whosonfirst_uploads", $update, $where);

		if ($rsp["ok"]){
			$upload = array_merge($upload, $update);
			$rsp["upload"] = $upload;
		}

		return $rsp;
	}

	########################################################################

	function whosonfirst_uploads_set_processing(&$upload){

		$status_map = whosonfirst_uploads_status_map("string keys");

		$update = array(
			"status_id" => $status_map["processing"]
		);

		return whosonfirst_uploads_update_upload($upload, $update);
	}

	########################################################################

	function whosonfirst_uploads_set_completed(&$upload){

		$status_map = whosonfirst_uploads_status_map("string keys");

		$now = time();

		$update = array(
			"status_id" => $status_map["completed"],
			"completed" => $now,
		);

		return whosonfirst_uploads_update_upload($upload, $update);
	}

	########################################################################

	function whosonfirst_uploads_set_failed(&$upload, $error){

		$status_map = whosonfirst_uploads_status_map("string keys");

		$update = array(
			"status_id" => $status_map["failed"],
			"error" => json_encode($error),
		);

		return whosonfirst_uploads_update_upload($upload, $update);
	}

	########################################################################

	function whosonfirst_uploads_can_process(&$upload){

		if (whosonfirst_uploads_is_processing($upload)){
			return 0;
		}

		if (whosonfirst_uploads_is_completed($upload)){
			return 0;
		}

		if (whosonfirst_uploads_is_failed($upload)){
			return 0;
		}

		return 1;
	}

	########################################################################

	function whosonfirst_uploads_is_processing(&$upload){

		$status_map = whosonfirst_uploads_status_map();
		$status_id = $upload["status_id"];

		return ($status_map[$status_id] == "processing") ? 1 : 0;
	}

	########################################################################

	function whosonfirst_uploads_is_completed(&$upload){

		$status_map = whosonfirst_uploads_status_map();
		$status_id = $upload["status_id"];

		return ($status_map[$status_id] == "completed") ? 1 : 0;
	}

	########################################################################

	function whosonfirst_uploads_is_failed(&$upload){

		$status_map = whosonfirst_uploads_status_map();
		$status_id = $upload["status_id"];

		return ($status_map[$status_id] == "failed") ? 1 : 0;
	}

	########################################################################

	function whosonfirst_uploads_get_by_id($id){

		$sql = "SELECT * FROM whosonfirst_uploads WHERE id=" . intval($id);

		$rsp = db_fetch($sql);
		$upload = db_single($rsp);

		return $upload;
	}

	########################################################################

	function whosonfirst_uploads_id2abspath($id){

		$pending = $GLOBALS["cfg"]["whosonfirst_uploads_pending_dir"];
		$rel_path = whosonfirst_uploads_id2relpath($id);

		return $pending . DIRECTORY_SEPARATOR . $rel_path;
	}

	########################################################################

	function whosonfirst_uploads_id2relpath($id){

		 $tree = whosonfirst_uploads_id2tree($id);
		 $fname = $id;

		 return $tree . DIRECTORY_SEPARATOR . $id;
	}

	########################################################################

	function whosonfirst_uploads_id2tree($id){

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

	function whosonfirst_uploads_enpublicify_uploads(&$uploads){

		$public = array();

		foreach ($uploads as $u){
			$public[] = whosonfirst_uploads_enpublicify_upload($u);
		}
		
		return $public;		
	}

	########################################################################

	function whosonfirst_uploads_enpublicify_upload(&$upload){

		$public = array(
			"id" => $upload["id"],
			"created" => $upload["created"],
			"lastmodified" => $upload["lastmodified"],
			"processing" => $upload["processing"],
			"status_id" => $upload["status_id"],
		);

		if ($upload["status_id"] == 0){
			$error = json_decode($upload["error"]);
			$public["error"] = $error;
		}
		
		return $public;
	}

	########################################################################

	function whosonfirst_uploads_inflate_uploads(&$uploads){

		foreach ($uploads as &$u){
			whosonfirst_uploads_inflate_upload($u);
		}
	}

	########################################################################

	function whosonfirst_uploads_inflate_upload(&$upload){

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

	function whosonfirst_uploads_process_upload_id($upload_id, $func){

		if ((! $func) || (! function_exists($func))){
			return array("ok" => 0, "error" => "Invalid processing function");
		}  

		$upload = whosonfirst_uploads_get_by_id($upload_id);

		if (! $upload){
			return array("ok" => 0, "error" => "Invalid upload ID");
		}

		whosonfirst_uploads_inflate_upload($upload);

		if (! whosonfirst_uploads_can_process($upload)){
			return array("ok" => 0, "error" => "Upload can not be processed");
		}

		$rsp = whosonfirst_uploads_set_processing($upload);

		if (! $rsp["ok"]){
			return $rsp;
		}

		$rsp = call_user_func_array($func, array($upload));

 		if (! $rsp["ok"]){
			whosonfirst_uploads_set_failed($upload, $rsp);
		}  

		else {
			whosonfirst_uploads_set_completed($upload);
		}

		return $rsp;		
	}

	########################################################################

	# this is here for some basic level of functionality - it is expected
	# that derivative applications will implement their own logic
	# (20180517/thisisaaronland)

	function whosonfirst_uploads_process_upload($upload){

		$ok_image = array("png", "jpg", "jpeg", "gif");

		$type = $upload["file"]["type"];
		list($major, $minor) = explode("/", $type, 2);

		$rsp = null;

		if (($major == "image") && (in_array($minor, $ok_image))){

			$rsp = whosonfirst_uploads_image_process_upload($upload);
		}

		else if (($major == "application") && ($minor == "pdf")){

			$rsp = whosonfirst_uploads_pdf_process_upload($upload);
		}

		else {

			$rsp = array("ok" => 0, "error" => "Don't know how to process this type");
		}

		return $rsp;
	}

	########################################################################

	function whosonfirst_uploads_generate_id(){
		return dbtickets_create(64);
	}

	########################################################################

	# the end