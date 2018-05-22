<?php

	include("include/init.php");
	loadlib("whosonfirst_uploads");

	loadlib("admin");
	admin_ensure_admin();

	$rsp = whosonfirst_uploads_get_stats();

	if ($rsp["ok"]){
		$stats = $rsp["stats"];
		$GLOBALS["smarty"]->assign_by_ref("stats", $stats);
	}

	$args = array();

	if ($page = get_int32("page")){
		$args["page"] = $page;
	}

	if ($status = get_str("status")){

		$status_id = whosonfirst_uploads_status_label_to_id($status);

		if ($status_id != -1){
			$args["status_id"] = $status_id;
		}
	}

	$rsp = whosonfirst_uploads_get_uploads($args);

	if ($rsp["ok"]){

		$uploads = $rsp["rows"];
		$pagination = $rsp["pagination"];

		whosonfirst_uploads_inflate_uploads($uploads);

		$GLOBALS["smarty"]->assign_by_ref("uploads", $uploads);
		$GLOBALS["smarty"]->assign_by_ref("pagination", $pagination);
	}

	$pagination_url = "{$GLOBALS["cfg"]["abs_root_url"]}admin/uploads/";

	if (isset($args["status_id"])){
	
		$enc_status = urlencode($status);
		$pagination_url .= "?status={$enc_status}";

		$GLOBALS["smarty"]->assign("pagination_url", $pagination_url);
		$GLOBALS["smarty"]->assign("pagination_page_as_queryarg", 1);
	}

	$GLOBALS["smarty"]->display("page_admin_uploads.txt");
	exit();
	
	
	