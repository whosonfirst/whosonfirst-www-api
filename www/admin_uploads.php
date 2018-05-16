<?php

	include("include/init.php");
	loadlib("whosonfirst_uploads");

	loadlib("admin");
	admin_ensure_admin();

	$args = array();

	if ($page = get_int32("page")){
		$args["page"] = $page;
	}

	$rsp = whosonfirst_uploads_get_uploads($args);

	if ($rsp["ok"]){

		$uploads = $rsp["rows"];
		$pagination = $rsp["pagination"];

		whosonfirst_uploads_inflate_uploads($uploads);

		$GLOBALS["smarty"]->assign_by_ref("uploads", $uploads);
		$GLOBALS["smarty"]->assign_by_ref("pagination", $pagination);
	}

	$GLOBALS["smarty"]->display("page_admin_uploads.txt");
	exit();
	
	
	