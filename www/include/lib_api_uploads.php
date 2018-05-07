<?php

	loadlib("uploads");

	########################################################################

	function api_uploads_getInfo() {

		api_utils_features_ensure_enabled(array(
			"uploads",
		));

		$id = request_int64("id");

		if (! $id){
			api_output_error(404);
		}

		$user = $GLOBALS["cfg"]["user"]["id"];
		$user = array("id" => 0);	# PLEASE FIX ME!!!!

		$upload = uploads_get_by_id($id);

		if (! $upload){
			api_output_error(404);
		}

		if ($upload["user_id"] != $user["id"]){
			api_output_error(404);
		}

		$public = uploads_enpublicify_upload($upload);

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