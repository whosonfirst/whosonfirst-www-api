<?php

	loadlib("whosonfirst_places");
	loadlib("whosonfirst_uploads");

	loadlib("whosonfirst_photos");
	loadlib("whosonfirst_photos_flickr");
	loadlib("whosonfirst_photos_permissions");

	########################################################################

	function api_whosonfirst_photos_uploadPhoto() {

		api_utils_features_ensure_enabled(array(
			"whosonfirst_uploads",
			"whosonfirst_photos",
		));

		$user = $GLOBALS["cfg"]["user"];

		api_whosonfirst_photos_ensure_capability($user, "can_upload");

		api_whosonfirst_photos_ensure_files();

		$pl = api_whosonfirst_photos_ensure_place();

		$props = array(
			"context" => "photo",
			"whosonfirst_id" => $pl["wof:id"],
		);

		api_whosonfirst_photos_upload_files($user, $_FILES, $props);
	}

	########################################################################

	function api_whosonfirst_photos_uploadFlickrPhoto() {

		api_utils_features_ensure_enabled(array(
			"whosonfirst_uploads",
			"whosonfirst_photos",
		));

		$user = $GLOBALS["cfg"]["user"];

		api_whosonfirst_photos_ensure_capability($user, "can_upload");

		$pl = api_whosonfirst_photos_ensure_place();

		$photo_id = request_int64("photo_id");

		if (! $photo_id){
			api_output_error(400);
		}

		$rsp = whosonfirst_photos_flickr_fetch_photo_id($photo_id);

		if (! $rsp["ok"]){
			api_output_error(500);
		}
		
		$files = $rsp["files"];

		$props = array(
			"context" => "photo",
			"source" => "flickr",
			"whosonfirst_id" => $pl["wof:id"],
			"photo_id" => $photo_id,
			"photo_info" => $rsp["info"],
		);

		api_whosonfirst_photos_upload_files($user, $files, $props);
	}

	########################################################################
	
	function api_whosonfirst_photos_upload_files($user, $files, $props){

		$uploads = array();

		foreach ($files as $f){

			$rsp = whosonfirst_uploads_create($user, $f, $props);

			if (! $rsp["ok"]){
				api_output_error(500);
			}

			$fname = $f["name"];
			$uploads[$fname] = $rsp["upload"]["id"];
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

	function api_whosonfirst_photos_ensure_place(){

		$id = request_int64("whosonfirst_id");

		if (! $id){
			api_output_error(404);
		}

		$pl = whosonfirst_places_get_by_id($id);
		
		if (! $pl){
			api_output_error(404);
		}

		return $pl;
	}

	########################################################################

	function api_whosonfirst_photos_ensure_files(){

		if (count($_FILES) == 0){
			api_output_error(500);
		}

		foreach ($_FILES as $f){

			# http://php.net/manual/en/features.file-upload.errors.php

			if ($f["error"]) {
				api_output_error(512);			
			}

			# check type here...
		}

	}

	########################################################################

	function api_whosonfirst_photos_ensure_capability(&$user, $cap){

		if (! users_acl_has_capability($user, $cap)){
			api_output_error(403);
		}
	}

	########################################################################

	function api_whosonfirst_photos_setStatus(){

		$user = $GLOBALS["cfg"]["user"];

		$photo_id = request_int64("photo_id");

		if (! $photo_id){
			api_output_error(400);
		}

		if (! request_isset("status_id")){
			api_output_error(400);
		}

		$status_id = request_int64("status_id");

		$status_map = whosonfirst_photos_status_map();

		if (! isset($status_map[$status_id])){
			api_output_error(400);
		}

		$photo = whosonfirst_photos_get_by_id($photo_id);

		if (! $photo){
			api_output_error(400);
		}

		if (! whosonfirst_photos_permissions_can_view_photo($photos, $user["id"])){
			api_output_error(403);
		}

		if (($user["id"] != $photo["user_id"]) && (! users_acl_has_capability($user, "can_edit_photos"))){
			api_output_error(403);
		}

		if ($photo["status_id"] != $status_id){

			if ($status_map[$status_id] != "public"){

				# TO DO: PLEASE CHANGE ALL THE SECRETS... (20180515/thisisaaronland)
			}

			$update = array(
				"status_id" => $status_id,
			);

			$rsp = whosonfirst_photos_update_photo($photo, $update);

			if (! $rsp["ok"]){
				api_output_error(500);
			}
			
			$photo = $rsp["photo"];
		}

		$public = api_whosonfirst_photos_enpublicify($photo);

		$out = array(
			"photo" => $public,
		);

		$more = array(
			"key" => "photo",
			"singleton" => 1,
		);

		api_output_ok($out, $more);
	}

	########################################################################

	function api_whosonfirst_photos_enpublicify(&$photo){

		$public = array(
			"id" => $photo["id"],
			"whosonfirst_id" => $photo["whosonfirst_id"],
			"status_id" => $photo["status_id"],
		);

		return $public;
	}

	########################################################################