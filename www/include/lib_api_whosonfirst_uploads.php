<?php

	loadlib("whosonfirst_places");
	loadlib("whosonfirst_photos");
	loadlib("whosonfirst_photos_flickr");
	loadlib("uploads");

	########################################################################

	function api_whosonfirst_uploads_uploadPhoto() {

		api_utils_features_ensure_enabled(array(
			"uploads",
		));

		$user = $GLOBALS["cfg"]["user"];

		api_whosonfirst_uploads_ensure_capability($user, "can_upload");

		api_whosonfirst_uploads_ensure_files();

		$pl = api_whosonfirst_uploads_ensure_place();

		$props = array(
			"context" => "photo",
			"whosonfirst_id" => $pl["wof:id"],
		);

		api_whosonfirst_uploads_upload_files($user, $_FILES, $props);
	}

	########################################################################

	function api_whosonfirst_uploads_uploadFlickrPhoto() {

		api_utils_features_ensure_enabled(array(
			"uploads",
		));

		$user = $GLOBALS["cfg"]["user"];

		api_whosonfirst_uploads_ensure_capability($user, "can_upload");

		$pl = api_whosonfirst_uploads_ensure_place();

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

		api_whosonfirst_uploads_upload_files($user, $files, $props);
	}

	########################################################################
	
	function api_whosonfirst_uploads_upload_files($user, $files, $props){

		$uploads = array();

		foreach ($files as $f){

			$rsp = uploads_create($user, $f, $props);

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

	function api_whosonfirst_uploads_ensure_place(){

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

	function api_whosonfirst_uploads_ensure_files(){

		if (count($_FILES) == 0){
			api_output_error(500);
		}

		foreach ($_FILES as $f){

			# http://php.net/manual/en/features.file-upload.errors.php

			if ($f["error"]) {
				api_output_error(512);			
			}
		}

	}

	########################################################################

	function api_whosonfirst_uploads_ensure_capability(&$user, $cap){

		if (! users_acl_has_capability($user, $cap)){
			api_output_error(403);
		}
	}

	########################################################################

	# the end