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

	function api_whosonfirst_uploads_getPending(){

		api_utils_features_ensure_enabled(array(
			"whosonfirst_uploads",
		));

		$user = $GLOBALS["cfg"]["user"];

		if (! users_acl_has_capability($user, "can_process_uploads")){
			api_output_error(403);
		}

		$args = array();
		api_utils_ensure_pagination_args($args);

		$rsp = whosonfirst_uploads_get_pending_uploads($args);

		if (! $rsp["ok"]){
			api_output_error(500);
		}

		$uploads = $rsp["rows"];
		$pagination = $rsp["pagination"];

		$public = whosonfirst_uploads_enpublicify_uploads($uploads);

		$out = array(
			"uploads" => $public
		);

		api_utils_ensure_pagination_results($out, $pagination);

		$more = array(
			"key" => "uploads",
		);

		api_output_ok($out);
	}

	########################################################################

	function api_whosonfirst_uploads_processUpload(){

		api_utils_features_ensure_enabled(array(
			"whosonfirst_uploads",
			"whosonfirst_media",
		));

		$user = $GLOBALS["cfg"]["user"];

		if (! users_acl_has_capability($user, "can_process_uploads")){
			api_output_error(403);
		}

		$upload_id = request_int64("upload_id");

		if (! $upload_id){
			api_output_error(404);
		}

		$process_func = "whosonfirst_uploads_process_upload";

		$rsp = whosonfirst_uploads_process_upload_id($upload_id, $process_func);

		if (! $rsp["ok"]){
			api_output_error(500);
		}

		$media = array(
			"id" => $rsp["media"]["id"],
		);
		
		$out = array(
			"media" => $media,
		);

		$more = array(
			"key" => "media",
			"singleton" => 1,
		);

		api_output_ok($out, $more);
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