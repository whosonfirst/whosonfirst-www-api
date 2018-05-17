<?php

	include("include/init.php");
	loadlib("whosonfirst_media");

	loadlib("admin");
	admin_ensure_admin();

	$id = get_int64("id");

	if (! $id){
		error_404();
	}

	$media = whosonfirst_media_get_by_id($id);
	$media["properties"] = json_decode($media["properties"], "as hash");

	if (! $media){
		error_404();
	}

	$viewer_id = $GLOBALS["cfg"]["user"]["id"];

	if (! whosonfirst_media_permissions_can_view_media($media, $viewer_id)){
		error_403();
	}

	$GLOBALS["smarty"]->assign_by_ref("media", $media);

	$GLOBALS["smarty"]->display("page_admin_media_single.txt");
	exit();
	
	
	