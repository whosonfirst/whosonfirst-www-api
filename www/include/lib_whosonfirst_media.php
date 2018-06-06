<?php

	loadlib("whosonfirst_places");
	loadlib("whosonfirst_uploads");
	loadlib("whosonfirst_media_depicts");
	loadlib("whosonfirst_media_permissions");
	loadlib("random");
	loadlib("brooklyn_integers");

	########################################################################

	function whosonfirst_media_status_map($string_keys=0){

		$map = array(
			-1 => "other",
			0 => "private",
			1 => "public",
		);

		if ($string_keys){
			$map = array_flip($map);
		}

		return $map;
	}

	########################################################################

	function whosonfirst_media_status_id_to_label($id){

		$map = whosonfirst_media_status_map();
		return (isset($map[$id])) ? $map[$id] : "other";
	}

 	########################################################################

	function whosonfirst_media_get_random($viewer_id, $more=array()){

		$more["random"] = 1;
		$more["per_page"] = 1;
	
		$rsp = whosonfirst_media_get_media($viewer_id, $more);
		$row = db_single($rsp);

		return $row;
	}

 	########################################################################

	function whosonfirst_media_get_by_id($id){

		$enc_id = AddSlashes($id);

		$sql = "SELECT * FROM whosonfirst_media WHERE id='{$enc_id}'";
		$rsp = db_fetch($sql);
		$rsp = db_single($rsp);

		return $rsp;
	}

	########################################################################

	function whosonfirst_media_get_by_flickr_id($id){

		$enc_id = AddSlashes($id);

		$sql = "SELECT *  FROM whosonfirst_media WHERE source='flickr' AND JSON_EXTRACT(properties, '$.photo_id') = '{$enc_id}'";
		$rsp = db_fetch($sql);
		$rsp = db_single($rsp);

		return $rsp;
	}

	########################################################################

	function whosonfirst_media_get_by_fingerprint($fp){

		$enc_fp = AddSlashes($fp);

		$sql = "SELECT * FROM whosonfirst_media WHERE fingerprint='{$enc_fp}'";
		$rsp = db_fetch($sql);
		$rsp = db_single($rsp);

		return $rsp;
	}

	########################################################################

	function whosonfirst_media_get_media_for_place(&$place, $viewer_id, $more=array()){

		$media = array();

		$rsp = whosonfirst_media_depicts_get_depictions_for_place($place, $viewer_id, $more);

		if (! $rsp["ok"]){
			return $rsp;
		}

		# just do a SELECT ... IN() query on the grounds that the pagination
		# limits will make it cheap enough? (20180530/thisisaaronland)

		foreach ($rsp["rows"] as $row){
			$media[] = whosonfirst_media_get_by_id($row["media_id"]);
		}

		$rsp["rows"] = $media;
		return $rsp;
	}

	########################################################################

	function whosonfirst_media_get_media($viewer_id, $more=array()){

		$where = array(
			"deleted=0",
		);

		if ($medium = $more["medium"]){		
			$enc_medium = AddSlashes($medium);
			$where[] = "medium='{$enc_medium}'";
		}

		if ($extra = whosonfirst_media_permissions_get_media_where($viewer_id)){
			$where[] = $extra;
		}  

		$sql = "SELECT * FROM whosonfirst_media";

		if (count($where)){

			$where = implode(" AND ", $where);
			$sql = "{$sql} WHERE {$where}";
		}

		if ($more["random"]){
			$sql .= " ORDER BY RAND()";
		}

		else {
			$sql .= " ORDER BY created DESC";
		}

		return db_fetch_paginated($sql, $more);
	}

	########################################################################

	function whosonfirst_media_set_status(&$media, $status_id){

		if ($status_map[$status_id] != "public"){

			$rsp = whosonfirst_media_refresh_secrets($media);

			if (! $rsp["ok"]){
				return $rsp;
			}
		}

		$update = array(
			"status_id" => $status_id,
		);

		$rsp = whosonfirst_media_update_media($media, $update);

		if (! $rsp["ok"]){
			return $rsp;
		}
			
		$media = array_merge($media, $update);

		# hey look... see the way we're not error checking... yeah...
		# (20180525/thisisaaronland)

		whosonfirst_media_depicts_set_status_for_media($media);						
		
		$rsp["media"] = $media;
		return $rsp;
	}

	########################################################################

	function whosonfirst_media_update_media(&$media, $update){

		$now = time();

		$update["lastmodified"] = $now;

		$insert = array();

		foreach ($update as $k => $v){
			$insert[$k] = AddSlashes($v);
		}

		$enc_id = AddSlashes($media["id"]);
		$where = "id='{$enc_id}'";

		$rsp = db_update("whosonfirst_media", $insert, $where);

		if ($rsp["ok"]){
			$media = array_merge($media, $update);
			$rsp["media"] = $media;
		}

		return $rsp;
	}

	########################################################################

	function whosonfirst_media_delete_media(&$media){

		$now = time();

		$update = array(
			"deleted" => $now,		
		);

		$rsp = whosonfirst_media_update_media($media, $update);

		if (! $rsp["ok"]){
			return $rsp;
		}

		$media = $rsp["media"];
		whosonfirst_media_inflate_media($media);

		# hey look... see the way we're not error checking... yeah...
		# (20180525/thisisaaronland)

		whosonfirst_media_depicts_delete_for_media($media);

		$props = $media["properties"];
		$sizes = $props["sizes"];

		foreach ($sizes as $sz => $ignore){

			$abs_path = whosonfirst_media_media_to_abspath($media, $sz);

			if (file_exists($abs_path)){

				if (! unlink($abs_path)){

					return array("ok" => 0, "error" => "Failed to delete {$abs_path}");
				}
			}
		}

		return array("ok" => 1);
	}

	########################################################################

	# $media_path is the path to the "original" (or fullsize) media
	# $derivatives is a dictionary of "label" => "path" pairs for derivative
	# medias that were produced from $media_path
	#
	# a few important things to note:
	#
	# 1. $upload is something produced by lib_uploads
	# 2. it is assumed that by the time you've gotten here you have scrubbed
	#    and sanitized all your medias
	# 3. the label "o" is reserved for the original/fullsize media - if you
	#    assign it in $derivatives it will be overwritten
	#
	# see also: https://github.com/aaronland/go-iiif
	# (20180509/thisisaaronland)

	function whosonfirst_media_import_media_with_upload(&$upload, $media_path, $derivatives=array(), $more=array()) {

		$defaults = array(
			"status_id" => 0,
		);

		$more = array_merge($defaults, $more);

		$derivatives["o"] = $media_path;

		if (whosonfirst_uploads_is_completed($upload)){
			return array("ok" => 0, "error" => "Upload is already completed");
		}

		$props = $upload["properties"];

		if (! is_array($props)){
			$props = json_decode($props, "as hash");
		}

		if (! $props){
			return array("ok" => 0, "error" => "Unable to parse properties");
		}
		
		$fp = $upload["fingerprint"];

		# FIX ME... TO BE MORE NUANCED... I'M NOT SURE WHAT THAT MEANS YET...
		# (20180528/thisisaaronland)

		# if (whosonfirst_media_get_by_fingerprint($fp)){
		# 	return array("ok" => 0, "Media with matching fingerprint already exists");
		# }

		$media_id = whosonfirst_media_generate_id();
		
		# because we might be using artisanal integers... no, really
		# (20180518/thisisaaronland)

		if (! $media_id){
			return array("ok" => 0, "error" => "Failed to generate media ID");
		}

		$rsp = whosonfirst_media_mkroot($media_id);

		if (! $rsp["ok"]){
			return $rsp;
		}

		$sizes = array();

		$rsp = whosonfirst_media_import_processed($derivatives, $media_id, $sizes);

		if (! $rsp["ok"]){
			return $rsp;
		}

		$new_props = array_merge($props, $more);		
		$new_props["sizes"] = $rsp["sizes"];
			
		$str_props = json_encode($new_props);

		$now = time();

		$media_row = array(
			"id" => $media_id,
			"user_id" => $upload["user_id"],
			"upload_id" => $upload["id"],
			"status_id" => $more["status_id"],
			"fingerprint" => $upload["fingerprint"],
			"created" => $now,
			"lastmodified" => $now,
			"properties" => $str_props,
		);

		$insert = array();

		foreach ($media_row as $k => $v){
			$insert[$k] = AddSlashes($v);
		}

		$rsp = db_insert("whosonfirst_media", $insert);

		if (!$rsp["ok"]){
			return $rsp;
		} 

		$rsp["media"] = $media_row;

		# depicts
				
		$upload_props = $upload["properties"];

		if ((is_array($upload_props["depicts"])) && (count($upload_props["depicts"]))){

			$user = users_get_by_id($upload["user_id"]);

			$to_depict = array();

			foreach ($upload_props["depicts"] as $id){

				$pl = whosonfirst_places_get_by_id($id);
				$to_depict[$id] = $pl;
				
				if (features_is_enabled("whosonfirst_media_depicts_infer_depictions")){

					$infers = whosonfirst_media_depicts_get_inferences($pl);

					foreach ($infers as $id){

						if (! isset($to_depict[$id])){
							continue;
						}

						$pl = whosonfirst_places_get_by_id($id);
						$to_depict[$id] = $pl;
					}
				}
			}

			foreach ($to_depict as $ignore => $place){
				$depicts_rsp = whosonfirst_media_depicts_add_depiction($media_row, $place, $user);
				# HOW TO HANDLE ERRORS ?
			}
		}

		# end of depicts

		return $rsp;
	}

	########################################################################

	function whosonfirst_media_reprocess_image(&$media){

		$pending = $GLOBALS["cfg"]["whosonfirst_uploads_pending_dir"];
		$static = $GLOBALS["cfg"]["whosonfirst_media_root"];

		whosonfirst_media_inflate_media($media);

		$media_id = $media["id"];

		$props = $media["properties"];
		$sizes = $props["sizes"];

		$rel_path = whosonfirst_media_media_to_relpath($media, "o");
		$abs_path = $static . DIRECTORY_SEPARATOR . $rel_path;

		$root = dirname($rel_path);

		$ext = $sizes["o"]["extension"];
		$tmp_source = $root . DIRECTORY_SEPARATOR . "{$media_id}.{$ext}";

		$tmp_file = $pending . DIRECTORY_SEPARATOR . $tmp_source;
		$tmp_root = dirname($tmp_file);

		if (! is_dir($tmp_root)){

			$recursive = true;

			if (! mkdir($tmp_root, 0755, $recursive)){
				return array("ok" => 0, "error" => "Unable to create tmp dir");
			}
		}

		# TO DO: LIB_STORAGE

		if (! copy($abs_path, $tmp_file)){
			return array("ok" => 0, "error" => "Unable to copy tmp file");
		}

		$instructions = $GLOBALS["cfg"]["iiif_default_instructions"];
		$instructions["o"]["format"] = $ext;

		$args = array(
			"destination" => $pending,
		);

		$rsp = whosonfirst_media_iiif_process_image($tmp_source, $instructions, $args);

		if (! $rsp["ok"]){
			return $rsp;
		}

		$processed = $rsp["processed"];

		# do colour extraction
		
		if (features_is_enabled("whosonfirst_media_iiif_colours")){

			$sz = $GLOBALS["cfg"]["iiif_colours_use_size"];

			if ($sz){
				$fname = basename($processed[$sz]);
				$root = whosonfirst_media_id_to_tree($media_id);
		
				$palette_src = $root . DIRECTORY_SEPARATOR . $fname;

				$rsp = whosonfirst_media_iiif_get_palette_service($palette_src);

				if ($rsp["ok"]){
					$service = $rsp["service"];
					$palette = $service["palette"];
					$props["colours"] = $palette;
				}
			}

			else {
				error_log("missing GLOBALS['cfg']['iiif_colours_use_size'] property");
			}
		}

		#

		$rsp = whosonfirst_media_import_processed($processed, $media_id, $sizes);

		if (! $rsp["ok"]){
			return $rsp;
		}

		$props["sizes"] = $rsp["sizes"];
		$str_props = json_encode($props);
	
		$update = array(
			"properties" => $str_props
		);

		$rsp = whosonfirst_media_update_media($media, $update);
		return $rsp;
	}

	########################################################################

	function whosonfirst_media_reimport_image_for_media(&$media, $source, $instructions){

		$pending = $GLOBALS["cfg"]["whosonfirst_uploads_pending_dir"];

		$args = array(
			"destination" => $pending,
		);

		whosonfirst_media_inflate_media($media);
		$props = $media["properties"];
		$sizes = $props["sizes"];

		$process_rsp = whosonfirst_media_iiif_process_image($source, $instructions, $args);

		if (! $process_rsp){
			return $process_rsp;
		}

		$processed = $process_rsp["processed"];

		$media_id = $media["id"];

		$import_rsp = whosonfirst_media_import_processed($processed, $media_id, $sizes);

		if (! $import_rsp["ok"]){
			return $import_rsp;
		}

		$props["sizes"] = $import_rsp["sizes"];
		$str_props = json_encode($props);
	
		$update = array(
			"properties" => $str_props
		);

		$update_rsp = whosonfirst_media_update_media($media, $update);
		return $update_rsp;
	}

	########################################################################

	function whosonfirst_media_refresh_secrets(&$media){

		$static = $GLOBALS["cfg"]["whosonfirst_media_root"];

		whosonfirst_media_inflate_media($media);

		$media_id = $media["id"];

		$props = $media["properties"];
		$sizes = $props["sizes"];

		$to_rename = array();

		foreach ($sizes as $sz => $details){

			$rel_path = whosonfirst_media_media_to_relpath($media, $sz);
			$abs_path = $static . DIRECTORY_SEPARATOR . $rel_path;

			$to_rename[$sz] = $abs_path;
		}

		$more = array(
			"refresh_secrets" => 1,
		);

		$rsp = whosonfirst_media_import_processed($to_rename, $media_id, $sizes, $more);

		if (! $rsp["ok"]){
			return $rsp;
		}

		$sizes = $rsp["sizes"];
		$props["sizes"] = $sizes;

		$update = array(
			"properties" => json_encode($props)
		);

		$rsp = whosonfirst_media_update_media($media, $update);
		return $rsp;
	}

	########################################################################

	function whosonfirst_media_import_processed($processed, $media_id, $sizes, $more=array()){

		$defaults = array(
			"refresh_secrets" => 0
		);

		$more = array_merge($defaults, $more);
		
		# setup secrets

		$secret_o = null;
		$secret = null;

		if (isset($sizes["o"])){
			$secret_o = $sizes["o"]["secret"];
		}

		foreach ($sizes as $sz => $details){

			if ($sz != "o"){
				$secret = $sizes[$sz]["secret"];
				break;
			}
		}

		if ((! $secret_o) || ($more["refresh_secrets"])){
			$secret_o = random_string();
		}

		if ((! $secret) || ($more["refresh_secrets"])){
			$secret = random_string();
		}

		$to_import = array();

		# PLEASE MOVE THIS IN TO A COMMON FUNCTION FOR ALL THE THINGS
		# (20180530/thisisaaronland)

		foreach ($processed as $sz => $tmp_path){

			$s = ($sz == "o") ? $secret_o : $secret;
			$ext = pathinfo($tmp_path, PATHINFO_EXTENSION);

			$fname = "{$media_id}_{$s}_{$sz}.{$ext}";		     
			$root = whosonfirst_media_id_to_tree($media_id);

			$rel_path = $root . DIRECTORY_SEPARATOR . $fname;

			$sizes[$sz] = array(
				"secret" => $s,
				"extension" => $ext,
			);

			$abs_path = $GLOBALS["cfg"]["whosonfirst_media_root"] . DIRECTORY_SEPARATOR . $rel_path;

			$to_import[$sz] = array(
				"source" => $tmp_path,
				"destination" => $abs_path,
			);
		}

		# actually move the files

		foreach ($to_import as $sz => $paths){

			$src_path = $paths["source"];
			$dest_path = $paths["destination"];

			# TO DO: LIB_STORAGE

			if (! rename($src_path, $dest_path)){
				return array("ok" => 0, "error" => "Failed to import media");
			}

			if (! chmod($dest_path, 0644)){
				return array("ok" => 0, "error" => "Failed to assign permissions for media");
			}

			# maybe do this sooner with $source_path especially if (some day)
			# $dest_path is remote... (20180509/thisisaaronland)

			$info = getimagesize($dest_path);

			if ($info){
				$sizes[$sz]["width"] = $info[0];
				$sizes[$sz]["height"] = $info[1];
				$sizes[$sz]["mimetype"] = $info["mime"];
			}
		}

		return array("ok" => 1, "sizes" => $sizes);
	}

	########################################################################

	function whosonfirst_media_scrub_unknown_files(&$media){

		return array("ok" => 0, "error" => "This doesn't work properly yet");

		$static = $GLOBALS["cfg"]["whosonfirst_media_root"];

		whosonfirst_media_inflate_media($media);
		$props = $media["properties"];
		$sizes = $props["sizes"];

		$known = array();
		$scrubbed = array();

		foreach ($sizes as $sz => $igore){

			$rel_path = whosonfirst_media_media_to_relpath($media, $sz);
			$abs_path = $static . DIRECTORY_SEPARATOR . $rel_path;

			$known[] = $abs_path; 
		}

		$tree = whosonfirst_media_media_to_tree($media);
		$root = $static . DIRECTORY_SEPARATOR . $tree;

		if (file_exists($root)){

			foreach (glob("{$root}/*") as $path){

				if (in_array($path, $known)){
					continue;
				}

				if (! unlink($path)){
					return array("ok" => 0, "error" => "Failed to unlink path");
				}

				$scrubbed[] = $path;
			}
		}

		return array("ok" => 1, "scrubbed" => $scrubbed);
	}

	########################################################################

	function whosonfirst_media_media_to_uri(&$media, $sz="o"){

		$rel_path = whosonfirst_media_media_to_relpath($media, $sz);
		return "{$GLOBALS["cfg"]["abs_root_url"]}static/{$rel_path}";
	}

	########################################################################

	function whosonfirst_media_height(&$media, $sz="o"){

		if ($size = whosonfirst_media_size($media, $sz)){
			return $size["height"];
		}
	}

	########################################################################

	function whosonfirst_media_width(&$media, $sz="o"){

		if ($size = whosonfirst_media_size($media, $sz)){
			return $size["width"];
		}
	}

	########################################################################

	function whosonfirst_media_size(&$media, $sz="o"){

		whosonfirst_media_inflate_media($media);
		$props = $media["properties"];
		$sizes = $props["sizes"];

		if (! isset($sizes[$sz])){
			return null;
		}

		return $sizes[$sz];
	}

	########################################################################

	function whosonfirst_media_media_to_tree(&$media){

		return whosonfirst_media_id_to_tree($media["id"]);
	}

	########################################################################

	function whosonfirst_media_media_to_relpath(&$media, $sz="o"){

		$root = whosonfirst_media_media_to_tree($media);
		$fname = whosonfirst_media_fname($media, $sz);

		return $root . DIRECTORY_SEPARATOR . $fname;
	}

	########################################################################

	function whosonfirst_media_media_to_abspath(&$media, $sz="o"){

		$rel_path = whosonfirst_media_media_to_relpath($media, $sz);
		$abs_path = $GLOBALS["cfg"]["whosonfirst_media_root"] . DIRECTORY_SEPARATOR . $rel_path;

		return $abs_path;
	}

	########################################################################

	function whosonfirst_media_media_to_url(&$media, $sz="o"){
		# PLEASE WRITE ME
	}

	########################################################################

	function whosonfirst_media_fname(&$media, $sz="o"){

		whosonfirst_media_inflate_media($media);
		$props = $media["properties"];
		
		if (! $props){
			return null;
		}

		if (! isset($props["sizes"][$sz])){
			return null;
		}

		$props = $props["sizes"][$sz];

		$media_id = $media["id"];
		$secret = $props["secret"];
		$ext = $props["extension"];		

		return "{$media_id}_{$secret}_{$sz}.{$ext}";
	}

	########################################################################

	function whosonfirst_media_mkroot($id){

		$static = $GLOBALS["cfg"]["whosonfirst_media_root"];

		if (! is_dir($static)){
			return array("ok" => 0, "error" => "whosonfirst_media root misconfigured");
		}

		$tree = whosonfirst_media_id_to_tree($id);
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

	function whosonfirst_media_id_to_tree($id){

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

	function whosonfirst_media_generate_id(){

		if ($GLOBALS["cfg"]["whosonfirst_media_use_artisanal_integers"]){
			return brooklyn_integers_get_int();
		}

		return dbtickets_create(64);
	}

	########################################################################

	function whosonfirst_media_enpublicify_media(&$media){

		$public = array();

		foreach ($media as $m){	
			$public[] = whosonfirst_media_enpublicify_media_single($m);
		}

		return $public;
	}

	########################################################################

	function whosonfirst_media_enpublicify_media_single(&$media){

		whosonfirst_media_inflate_media($media);

		$urls = array(
			"n" => "",
			"b" => "",
			"z" => "",
			# "o" if admin...
		);

		foreach ($urls as $sz => $ignore){

			$rel_path = whosonfirst_media_media_to_relpath($media, $sz);
			$abs_url = "{$GLOBALS["cfg"]["abs_root_url"]}static/{$rel_path}";
			
			$urls[$sz] = $abs_url;
		}	

		$creditline = "";

		$status_map = whosonfirst_media_status_map();
		$status = $status_map[$media["status_id"]];

		$public = array(
			"id" => $media["id"],
			"medium" => $media["medium"],
			"source" => $media["source"],
			"status" => $status,
			"mimetype" => $media["mimetype"],
			"urls" => $urls,
			"creditline" => $creditline,
		);

		if ($media["source"] == "flickr"){

			$props = $media["properties"];
			$info = $props["photo_info"];

			$GLOBALS["smarty"]->assign_by_ref("info", $info);
			$creditline = $GLOBALS["smarty"]->fetch("inc_photo_flickr_attribution.txt");

			$public["creditline"] = $creditline;
		}

		return $public;	
	}

	########################################################################

	function whosonfirst_media_inflate_media(&$media){

		if (! is_array($media["properties"])){
			$media["properties"] = json_decode($media["properties"], "as hash");
		}

		# pass-by-ref
	}

	########################################################################

	function whosonfirst_media_write_pending_for_media(&$media, $bytes, $fname=null){

		$pending = $GLOBALS["cfg"]["whosonfirst_uploads_pending_dir"];

		$tree = whosonfirst_media_media_to_tree($media);
		
		if (! $fname){
			$fname = $wof_id;
		}

		$path = $pending . DIRECTORY_SEPARATOR . $tree . DIRECTORY_SEPARATOR . $fname;
		$root = dirname($path);

		if (! is_dir($root)){

			$recursive = true;

			if (! mkdir($root, 0755, $recursive)){
				return array("ok" => 0, "error" => "Failed to create root");
			}
		}

		$fh = fopen($path, "wb");

		if (! $fh){
			return array("ok" => 0, "error" => "Failed to create path");
		}

		fwrite($fh, $bytes);
		fclose($fh);

		if (filesize($path) == 0){

			unlink($path);

			return array("ok" => 0, "error" => "Failed to write path");
		}

		$source = $tree . DIRECTORY_SEPARATOR . $fname;

		return array("ok" => 1, "path" => $path, "source" => $source);
	}

	########################################################################

	# the end