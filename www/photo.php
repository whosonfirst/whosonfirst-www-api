<?php

	include("include/init.php");
	loadlib("whosonfirst_media");
	loadlib("whosonfirst_media_permissions");

	features_ensure_enabled("whosonfirst_media");

	$id = get_int64("id");

	if (! $id){
		error_404();
	}

	$photo = whosonfirst_media_get_by_id($id);

	if (! $photo){
		error_404();
	}

	if ($photo["deleted"]){
		error_404();
	}
	
	if ($photo["medium"] != "image"){
		error_404();
	}

	$viewer_id = ($GLOBALS['cfg']['user']) ? $GLOBALS['cfg']['user']['id'] : 0;

	if (! whosonfirst_media_permissions_can_view_media($photo, $viewer_id)){
		error_403();	  
	}

	whosonfirst_media_inflate_media($photo);

	$place = whosonfirst_places_get_by_id($photo["whosonfirst_id"]);

	$GLOBALS['smarty']->assign_by_ref("place", $place);
	$GLOBALS['smarty']->assign_by_ref("photo", $photo);

	$GLOBALS['smarty']->display("page_photo.txt");
	exit();


