<?php

	loadlib("whosonfirst_places");
	loadlib("whosonfirst_uploads");

	loadlib("whosonfirst_media");
	loadlib("whosonfirst_media_depicts");
	loadlib("whosonfirst_media_flickr");
	loadlib("whosonfirst_media_permissions");

	# public facing methods

	########################################################################

	function api_whosonfirst_media_uploadFile() {

		api_utils_features_ensure_enabled(array(
			"whosonfirst_uploads",
			"whosonfirst_media",
		));

		$user = $GLOBALS["cfg"]["user"];

		api_whosonfirst_media_ensure_capability($user, "can_upload");

 		$medium = request_str("medium");
		api_whosonfirst_media_ensure_medium($medium);

		# this will validate mimetype(s)

		api_whosonfirst_media_ensure_files($_FILES);

		$depicts = api_whosonfirst_media_ensure_depicts();

		$props = array(
			"medium" => $medium,
			"source" => "user",
			"depicts" => $depicts,
			# mimetype is set below in api_whosonfirst_media_upload_files and per-file basis
		);

		api_whosonfirst_media_upload_files($user, $_FILES, $props);
	}

	########################################################################

	function api_whosonfirst_media_uploadFlickrPhoto() {

		api_utils_features_ensure_enabled(array(
			"whosonfirst_uploads",
			"whosonfirst_media",
			"whosonfirst_media_flickr",
		));

		$user = $GLOBALS["cfg"]["user"];

		api_whosonfirst_media_ensure_capability($user, "can_upload");

		$pl = api_whosonfirst_media_ensure_place();

		$photo_id = request_int64("photo_id");

		if (! $photo_id){
			api_output_error(400);
		}

		if ($upload = whosonfirst_uploads_get_by_flickr_id_pending($photo_id)){

			$file = json_decode($upload["file"], "as hash");
			$fname = $file["name"];

			$uploads = array(
				$fname => $upload["id"],
			);

			$out = array(
				"uploads" => $uploads,
			);

			$more = array(
				"key" => "uploads",
			);

			api_output_ok($out, $more);
		}

		# so this bit here lacks a measure of finesse - there are a bunch of
		# conditions that might get stuck here but we'll try it for now...
		# (20180522/thisisaaronland)

		if ($media = whosonfirst_media_get_by_flickr_id($photo_id)){
			
			$upload = whosonfirst_uploads_get_by_id($media["upload_id"]);

			$file = json_decode($upload["file"], "as hash");
			$fname = $file["name"];

			$uploads = array(
				$fname => $upload["id"],
			);

			$out = array(
				"uploads" => $uploads,
			);

			$more = array(
				"key" => "uploads",
			);

			api_output_ok($out, $more);
		}

 		$medium = "image";
		api_whosonfirst_media_ensure_medium($medium);

		$rsp = whosonfirst_media_flickr_fetch_photo_id($photo_id);

		if (! $rsp["ok"]){
			api_output_error(500);
		}
		
		$files = $rsp["files"];	
		api_whosonfirst_media_ensure_files($files);	# this will validate mimetype(s)

		$depicts = api_whosonfirst_media_ensure_depicts();

		$props = array(
			"medium" => $medium,
			"source" => "flickr",
			# mimetype is set below in api_whosonfirst_media_upload_files and per-file basis
			"depicts" => $depicts,
			"photo_id" => $photo_id,
			"photo_info" => $rsp["info"],
		);

		api_whosonfirst_media_upload_files($user, $files, $props);
	}

	########################################################################

	function api_whosonfirst_media_addDepiction(){

		$user = $GLOBALS["cfg"]["user"];

		$id = request_int64("id");

		$media = whosonfirst_media_get_by_id($id);

		if (! $media){
			api_output_error(400);
		}

		if (! whosonfirst_media_permissions_can_view_media($media, $user["id"])){
			api_output_error(403);
		}

		$wofid = request_int64("whosonfirst_id");

		$place = whosonfirst_places_get_by_id($wofid);

		if (! $place){
			api_output_error(404);
		}

		$rsp = whosonfirst_media_depicts_add_depiction($media, $place, $user);

		if (! $rsp["ok"]){
			api_output_error(500);
		}

		$depicts = $rsp["depicts"];

		$out = array(
			"depicts" => $depicts
		);

		$more = array(
			"key" => "depicts",
			"singleton" => 1,
		);

		api_output_ok($out, $more);
	}

	########################################################################

	function api_whosonfirst_media_removeDepiction(){

		api_output_error(503);		# please write me
	}

	########################################################################

	function api_whosonfirst_media_setStatus(){

		api_utils_features_ensure_enabled(array(
			"whosonfirst_media",
		));

		$user = $GLOBALS["cfg"]["user"];

		$id = request_int64("id");

		if (! $id){
			api_output_error(400);
		}

		if (! request_isset("status_id")){
			api_output_error(400);
		}

		$status_id = request_int64("status_id");

		$status_map = whosonfirst_media_status_map();

		if (! isset($status_map[$status_id])){
			api_output_error(400);
		}

		$media = whosonfirst_media_get_by_id($id);

		if (! $media){
			api_output_error(400);
		}

		if (! whosonfirst_media_permissions_can_view_media($media, $user["id"])){
			api_output_error(403);
		}

		if (($user["id"] != $media["user_id"]) && (! users_acl_has_capability($user, "can_edit_media"))){
			api_output_error(403);
		}

		$rsp = whosonfirst_media_set_status($media, $status_id);

		if (! $rsp["ok"]){
			api_output_error(500);
		}
			
		$media = $rsp["media"];

		$public = whosonfirst_media_enpublicify_media_single($media);

		$out = array(
			"media" => $public,
		);

		$more = array(
			"key" => "media",
			"singleton" => 1,
		);

		api_output_ok($out, $more);
	}

	########################################################################

	function api_whosonfirst_media_deleteFile(){

		api_utils_features_ensure_enabled(array(
			"whosonfirst_media",
		));

		$id = request_int64("id");

		if (! $id){
			api_output_error(400);
		}

		$media = whosonfirst_media_get_by_id($id);

		if (! $media){
			api_output_error(404);
		}

		if ($media["deleted"]){
			api_output_error(500);
		}

		$user = $GLOBALS["cfg"]["user"];

		if (($media["user_id"] != $user["id"]) && (users_roles_has_role($user, "admin"))){
			api_output_error(403);
		}

		$rsp = whosonfirst_media_delete_media($media);

		if (! $rsp){
			api_output_error(500, $rsp["error"]);
		}  

		api_output_ok();
	}

	########################################################################

	# internal / utility functions

	########################################################################
	
	function api_whosonfirst_media_upload_files($user, $files, $props){

		$uploads = array();

		foreach ($files as $f){

			$props["mimetype"] = $f["type"];

			$rsp = whosonfirst_uploads_create($user, $f, $props);

			if (! $rsp["ok"]){
				api_output_error(500);
			}

			$uploads[] = array(
				"id" => $rsp["upload"]["id"],
				"name" => $f["name"],
			);
		}

		$out = array(
			"uploads" => $uploads,
		);

		$more = array(
			"key" => "uploads",
		);

		api_output_ok($out, $more);
	}

	########################################################################

	# this assumes $_FILES or something that looks like it
	# (20180517/thisisaaronland)

	function api_whosonfirst_media_ensure_files($files=array()){

		if (count($files) == 0){
			api_output_error(500);
		}

		foreach ($files as $f){

			# http://php.net/manual/en/features.file-upload.errors.php

			if ($f["error"]) {
				api_output_error(512);			
			}

			# this triggers api_output_error which is a bit confusing
			# since this function also does... we'll live with it for
			# today (20180517/thisisaaronland)

			$type = $f["type"];
			api_whosonfirst_media_ensure_mimetype($type);
		}

	}

	########################################################################

	# PLEASE PUT THIS IN A WRAPPER FUNCTION OR SOMETHING...
	# (20180517/thisisaaronland)

	function api_whosonfirst_media_ensure_capability(&$user, $cap){

		if (! users_acl_has_capability($user, $cap)){
			api_output_error(403);
		}
	}

	########################################################################

	function api_whosonfirst_media_ensure_medium($medium){

		$allowed = $GLOBALS["cfg"]["whosonfirst_uploads_allowable_media"];

		if (count($allowed) == 0){
			return;		# okay!
		}
		
		if (in_array($medium, $allowed)){
			return;		# okay!
		}

		api_output_error(400);
	}

	########################################################################

	function api_whosonfirst_media_ensure_mimetype($type){

		$allowed = $GLOBALS["cfg"]["whosonfirst_uploads_allowable_mimetypes"];

		if (count($allowed) == 0){
			return;		# okay!
		}
		
		if (in_array($type, $allowed)){
			return;		# okay!
		}

		api_output_error(400);
	}

	########################################################################

	function api_whosonfirst_media_ensure_depicts(){

		$depicts = array();

		if ($str_wofids = request_str("whosonfirst_id")){

			foreach (explode(",", $str_wofids) as $id){

				$pl = whosonfirst_places_get_by_id($id);

				if (! $pl){
					api_output_error(404);
				}

				if (! in_array($id, $depicts)){
					$depicts[] = $id;
				}
			}
		}
		
		return $depicts;
	}
	
	########################################################################

	# the end