<?php

	include("include/init.php");

	loadlib("whosonfirst_brands");
	loadlib("whosonfirst_places");

	if (! get_isset("id")){
		header("location: {$GLOBALS['cfg']['abs_root_url']}");
		exit();
	}

	$id = get_int64("id");

	# FETCH BRAND HERE, we need to (re) index ES first
	# (20171107/thisisaaronland)

	$more = array();

	if ($p = get_int32("page")){
		$more["page"] = $p;
	}	

	$rsp = whosonfirst_places_get_by_brand_id($id, $more);

	if (! $rsp["ok"]){
		error_500();
	}

	$places = $rsp["rows"];
	$pagination = $rsp["pagination"];

	$GLOBALS['smarty']->assign_by_ref("brand_id", $id);

	$GLOBALS['smarty']->assign_by_ref("places", $places);
	$GLOBALS['smarty']->assign_by_ref("pagination", $pagination);

	$pagination_url = $GLOBALS['cfg']['abs_root_url'] . "brands/$id/";
	$GLOBALS['smarty']->assign("pagination_url", $pagination_url);

	$GLOBALS['smarty']->display("page_brand.txt");
	exit();
?>