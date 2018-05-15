<?php

	loadlib("whosonfirst_photos");
	loadlib("users_roles");

	########################################################################

	function whosonfirst_photos_permissions_can_view_photo(&$photo, $viewer_id=0){

		$status_map = whosonfirst_photos_status_map("string keys");

		if ($photo["status_id"] == $status_map["public"]){
			return 1;
		}

		if ($viewer_id == 0){
			return 0;
		}

		$user = users_get_by_id($viewer_id);

		if (! $user){
			return 0;
		}

		if ($user["deleted"]){
			return 0;
		}

		if ($user["id"] == $photo["user_id"]){
			return 1;
		}

		if (users_roles_has_role($user, "admin")){
			return 1;
		}
		
		return 0;
	}

	########################################################################

	function whosonfirst_photos_permissions_get_photos_where($viewer_id){

		$status_map = whosonfirst_photos_status_map("string keys");

		$user = null;
		$where = null;

		if ($viewer_id != 0){

			$user = users_get_by_id($viewer_id);

			if (($user) && ($user["deleted"])){
				$user = null;
			}
		}

		if (! $user){

			$enc_public = AddSlashes($status_map["public"]);
			$where = "status_id='{$enc_public}'";
		}

		else if (! users_roles_has_role($user, "admin")){	

			$enc_public = AddSlashes($status_map["public"]);
			$enc_user = AddSlashes($user["id"]);

			$where = "status_id='{$enc_public}' OR user_id='{$enc_user}'";
		}

		else {}

		return $where;
	}

	########################################################################

	# the end