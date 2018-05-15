<?php

	include("include/init.php");
	loadlib("whosonfirst_photos");
	loadlib("whosonfirst_photos_permissions");
	
	$viewer_id = ($GLOBALS['cfg']['user']) ? $GLOBALS['cfg']['user']['id'] : 0;

	$args = array();

	if ($page = get_int32("page")){
		$args["page"] = $page;
	}

	$rsp = whosonfirst_photos_get_photos_actually($viewer_id, $args);

	if ($rsp["ok"]){

		$photos = $rsp["rows"];
		$pagination = $rsp["pagination"];

		$GLOBALS['smarty']->assign_by_ref("pagination", $pagintion);
		$GLOBALS['smarty']->assign_by_ref("photos", $photos);
	}

	$GLOBALS['smarty']->display("page_photos.txt");
	exit();


