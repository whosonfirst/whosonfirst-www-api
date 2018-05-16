<?php

	loadlib("whosonfirst_uploads");

	########################################################################

	function api_whosonfirst_uploads_getInfo() {

		api_utils_features_ensure_enabled(array(
			"whosonfirst_uploads",
		));

		$id = request_int64("id");

		if (! $id){
			api_output_error(404);
		}

		$upload = whosonfirst_uploads_get_by_id($id);

		if (! $upload){
			api_output_error(404);
		}

		$user = $GLOBALS['cfg']['user'];

		if ($upload["user_id"] != $user["id"]){
			api_output_error(404);
		}

		$public = whosonfirst_uploads_enpublicify_upload($upload);

		$more = array(
			"key" => "upload",
			"is_singleton" => 1,
		);

		$out = array(
			"upload" => $public,
		);

		api_output_ok($out);
	}

	########################################################################

	function api_whosonfirst_uploads_deleteUpload(){

		api_utils_features_ensure_enabled(array(
			"whosonfirst_uploads",
		));

		$user = $GLOBALS['cfg']['user'];

		if (! users_acl_has_capability($user, "can_delete_uploads")){
			api_output_error(403);
		}

		$id = request_int64("upload_id");

		if (! $id){
			api_output_error(404);
		}

		$upload = whosonfirst_uploads_get_by_id($id);

		if (! $upload){
			api_output_error(404);
		}

		$status_map = whosonfirst_uploads_status_map("string keys");

		if ($upload["status_id"] == $status_map["processing"]){
			api_output_error(400);
		}

		if ($upload["status_id"] == $status_map["completed"]){
			api_output_error(400);
		}

		if ($upload["status_id"] == $status_map["deleted"]){
			api_output_error(400);
		}

		$rsp = whosonfirst_uploads_delete_upload($upload);

		if (! $rsp["ok"]){
			api_output_error(500);
		}
		
		$upload = $rsp["upload"];

		$public = whosonfirst_uploads_enpublicify_upload($upload);

		$more = array(
			"key" => "upload",
			"is_singleton" => 1,
		);

		$out = array(
			"upload" => $public,
		);

		api_output_ok($out);
	}

	########################################################################

	# the end