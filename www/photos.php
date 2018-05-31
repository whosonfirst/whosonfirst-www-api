<?php

	include("include/init.php");
	loadlib("whosonfirst_media");
	loadlib("whosonfirst_media_permissions");

	features_ensure_enabled("whosonfirst_media");
	
	$viewer_id = ($GLOBALS['cfg']['user']) ? $GLOBALS['cfg']['user']['id'] : 0;

	$args = array(
		"medium" => "image",
		"per_page" => 3,
	);

	if ($page = get_int32("page")){
		$args["page"] = $page;
	}

	$rsp = whosonfirst_media_get_media($viewer_id, $args);

	if ($rsp["ok"]){

		$photos = $rsp["rows"];
		$pagination = $rsp["pagination"];

		$GLOBALS['smarty']->assign_by_ref("pagination", $pagintion);
		$GLOBALS['smarty']->assign_by_ref("photos", $photos);
	}

	$pagination_url = "{$GLOBALS["cfg"]["abs_root_url"]}photos/";
	$GLOBALS["smarty"]->assign("pagination_url", $pagination_url);

	$GLOBALS['smarty']->display("page_photos.txt");
	exit();


