<?php

	loadlib("whosonfirst_places");
	loadlib("random");

	########################################################################

	function whosonfirst_photos_status_map($string_keys=0){

		$map = array(
			-1 => "pending",
			0 => "private",
			1 => "public",
		);

		if ($string_keys){
			$map = array_flip($map);
		}

		return $map;
	}

	########################################################################

	function whosonfirst_photos_status_id_to_label($id){

		$map = whosonfirst_photos_status_map();
		return (isset($map[$id])) ? $map[$id] : "unknown";
	}

	########################################################################

	function whosonfirst_photos_get_by_id($id){

		$enc_id = AddSlashes($id);

		$sql = "SELECT * FROM Photos WHERE id='{$enc_id}'";
		$rsp = db_fetch($sql);
		$rsp = db_single($rsp);

		return $rsp;
	}

	########################################################################

	# see below... (20180515/thisisaaronland)

	function whosonfirst_photos_get_photos_actually($viewer_id, $more=array()){

		$sql = "SELECT * FROM Photos";

		if ($where = whosonfirst_photos_permissions_get_photos_where($viewer_id)){
			$sql = "{$sql} WHERE {$where}";
		}  

		return db_fetch($sql, $more);
	}

	########################################################################

	# PLEASE RENAME ME... (20180515/thisisaaronland)

	function whosonfirst_photos_get_photos(&$record, $more=array()){

		$status_map = whosonfirst_photos_status_map("string keys");

		$defaults = array(
			"status_id" => $status_map["public"],
		);

		$more = array_merge($defaults, $more);

		$enc_id = AddSlashes($record["wof:id"]);

		$sql = "SELECT * FROM Photos WHERE whosonfirst_id='{$enc_id}'";

		return db_fetch_paginated($sql, $more);
	}

	########################################################################

	# PLEASE RENAME ME... (20180515/thisisaaronland)

	function whosonfirst_photos_get_photo(&$record, $photo_id, $more=array()){

		$enc_exh = AddSlashes($record["whosonfirst:id"]);
		$enc_ph = AddSlashes($photo_id);

		$sql = "SELECT * FROM Photos WHERE id='{$enc_ph}' AND whosonfirst_id='{$enc_exh}'";

		$rsp = db_fetch($sql);
		$photo = db_single($rsp);

		return $photo;
	}

	########################################################################

	function whosonfirst_photos_update_photo(&$photo, $update){

		$now = time();

		$update["lastmodified"] = $now;

		$insert = array();

		foreach ($update as $k => $v){
			$insert[$k] = AddSlashes($v);
		}

		$enc_id = AddSlashes($photo["id"]);
		$where = "id='{$enc_id}'";

		$rsp = db_update("Photos", $insert, $where);

		if ($rsp["ok"]){
			$photo = array_merge($photo, $update);
			$rsp["photo"] = $photo;
		}

		return $rsp;
	}

	########################################################################

	function whosonfirst_photos_import_photo_with_upload_id($id, $photo_path, $derivatives=array(), $more=array()) {

		$upload = uploads_get_by_id($id);

		if (! $upload){
			return array("ok" => 0, "error" => "Invalid upload ID");
		}

		return whosonfirst_photos_import_upload($upload, $photo_path, $derivatives, $more);
	}

	########################################################################

	# $photo_path is the path to the "original" (or fullsize) photo
	# $derivatives is a dictionary of "label" => "path" pairs for derivative
	# photos that were produced from $photo_path
	#
	# a few important things to note:
	#
	# 1. $upload is something produced by lib_uploads
	# 2. it is assumed that by the time you've gotten here you have scrubbed
	#    and sanitized all your photos
	# 3. the label "o" is reserved for the original/fullsize photo - if you
	#    assign it in $derivatives it will be overwritten
	#
	# see also: https://github.com/aaronland/go-iiif
	# (20180509/thisisaaronland)

	function whosonfirst_photos_import_photo_with_upload(&$upload, $photo_path, $derivatives=array(), $more=array()) {

		$defaults = array(
			"status_id" => 0,
		);

		$more = array_merge($defaults, $more);

		if (uploads_is_completed($upload)){
			return array("ok" => 0, "error" => "Upload is already completed");
		}

		$props = $upload["properties"];
		$props = json_decode($props, "as hash");

		if (! $props){
			return array("ok" => 0, "error" => "Unable to parse properties");
		}

		$whosonfirst_id = $props["whosonfirst_id"];

		if (! $whosonfirst_id){
			return array("ok" => 0, "Missing whosonfirst ID");
		}

		$pl = whosonfirst_places_get_by_id($whosonfirst_id);

		if (! $pl){
			return array("ok" => 0, "Invalid record");
		}

		$rsp = whosonfirst_photos_mkroot($whosonfirst_id);

		if (! $rsp["ok"]){
			return $rsp;
		}

		$root = $rsp["root"];

		$photo_id = dbtickets_create(64);
		
		$secret_o = random_string();
		$secret = random_string();

		#

		$details = array_merge($props, $more);		
		$details["sizes"] = array();

		#

		$to_import = array();

		$derivatives["o"] = $photo_path;

		foreach ($derivatives as $sz => $source){
		
			$s = ($sz == "o") ? $secret_o : $secret;

			$ext = pathinfo($source, PATHINFO_EXTENSION);

			$fname = "{$whosonfirst_id}_{$photo_id}_{$s}_{$sz}.{$ext}";

			$destination = $root . DIRECTORY_SEPARATOR . $fname;
			
			$to_import[$sz] = array(
				"source" => $source,
				"destination" => $destination,
			);

			$details["sizes"][$sz]["secret"] = $s;
			$details["sizes"][$sz]["extension"] = $ext;
		}

		#

		foreach ($to_import as $sz => $paths){

			$src_path = $paths["source"];
			$dest_path = $paths["destination"];

			# SOMETHING SOMETHING SOMETHING LIB_STORAGE...

			if (file_exists($dest_path)){
				return array("ok" => 0, "error" => "Photo already exists");
			}

			# copy and then clean up later, maybe?

			if (! rename($src_path, $dest_path)){
				return array("ok" => 0, "error" => "Failed to import photo");
			}

			if (! chmod($dest_path, 0644)){
				return array("ok" => 0, "error" => "Failed to assign permissions for photo");
			}

			# maybe do this sooner with $source_path especially if (some day)
			# $dest_path is remote... (20180509/thisisaaronland)

			$info = getimagesize($dest_path);

			if (! $info){
				return array("ok" => 0, "error" => "Failed to determine size for photo");
			}

			$details["sizes"][$sz]["width"] = $info[0];
			$details["sizes"][$sz]["height"] = $info[1];
			$details["sizes"][$sz]["mime"] = $info["mime"];
		}

		$str_details = json_encode($details);

		$now = time();

		$photo_row = array(
			"id" => $photo_id,
			"whosonfirst_id" => $whosonfirst_id,
			"user_id" => $upload["user_id"],
			"upload_id" => $upload["id"],
			"status_id" => $more["status_id"],
			"fingerprint" => $upload["fingerprint"],
			"details" => $str_details,
			"created" => $now,
			"lastmodified" => $now,
		);

		$insert = array();

		foreach ($photo_row as $k => $v){
			$insert[$k] = AddSlashes($v);
		}

		$rsp = db_insert("Photos", $insert);

		if (!$rsp["ok"]){
			return $rsp;
		} 

		$rsp["photo"] = $photo_row;
		return $rsp;
	}

	########################################################################

	function whosonfirst_photos_photo_to_relpath(&$photo, $sz="o"){

		$root = whosonfirst_photos_id2tree($photo["whosonfirst_id"]);
		$fname = whosonfirst_photos_fname($photo, $sz);

		return $root . DIRECTORY_SEPARATOR . $fname;
	}

	########################################################################

	function whosonfirst_photos_fname(&$photo, $sz="o"){

		$details = json_decode($photo["details"], "as hash");
		
		if (! $details){
			return null;
		}

		if (! isset($details["sizes"][$sz])){
			return null;
		}

		$details = $details["sizes"][$sz];

		$wof_id = $photo["whosonfirst_id"];
		$photo_id = $photo["id"];
		$secret = $details["secret"];
		$ext = $details["extension"];		

		return "{$wof_id}_{$photo_id}_{$secret}_{$sz}.{$ext}";
	}

	########################################################################

	function whosonfirst_photos_mkroot($id){

		$static = $GLOBALS["cfg"]["whosonfirst_photos_root"];

		if (! is_dir($static)){
			return array("ok" => 0, "error" => "Photos root misconfigured");
		}

		$tree = whosonfirst_photos_id2tree($id);
		$root = $static . DIRECTORY_SEPARATOR . $tree;

		if (! is_dir($root)){

			$recursive = true;

			if (! mkdir($root, 0755, $recursive)){
				return array("ok" => 0, "error" => "Failed to create root");
			}
		}

		return array("ok" => 1, "root" => $root);
	}

	########################################################################

	function whosonfirst_photos_id2tree($id){

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

	# the end