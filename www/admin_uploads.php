<?php

	include("include/init.php");
	loadlib("admin");
	loadlib("uploads");

	admin_ensure_admin();

	$args = array();

	if ($page = get_int32("page")){
		$args["page"] = $page;
	}

	$rsp = uploads_get_uploads($args);

	if ($rsp["ok"]){

		$uploads = $rsp["rows"];
		$pagination = $rsp["pagination"];

		uploads_inflate_uploads($uploads);

		$GLOBALS["smarty"]->assign_by_ref("uploads", $uploads);
		$GLOBALS["smarty"]->assign_by_ref("pagination", $pagination);
	}

	$GLOBALS["smarty"]->display("page_admin_uploads.txt");
	exit();
	
	
	