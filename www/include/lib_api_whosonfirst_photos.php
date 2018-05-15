<?php

	loadlib("whosonfirst_photos");
	loadlib("whosonfirst_photos_permissions");

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