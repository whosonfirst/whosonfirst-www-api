<?php

	include("include/init.php");
	loadlib("whosonfirst_media");

	loadlib("admin");
	admin_ensure_admin();

	$args = array();

	if ($page = get_int32("page")){
		$args["page"] = $page;
	}

	$viewer_id = $GLOBALS["cfg"]["user"]["id"];

	$rsp = whosonfirst_media_get_media($viewer_id, $args);

	if ($rsp["ok"]){

		$media = $rsp["rows"];
		$pagination = $rsp["pagination"];

		$GLOBALS["smarty"]->assign_by_ref("media", $media);
		$GLOBALS["smarty"]->assign_by_ref("pagination", $pagination);
	}

	$GLOBALS["smarty"]->display("page_admin_media.txt");
	exit();
	
	
	