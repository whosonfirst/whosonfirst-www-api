<?php

	include("include/init.php");

	loadlib("machinetags");
	loadlib("whosonfirst_brands");
	loadlib("whosonfirst_places");

	if (! get_isset("id")){
		header("location: {$GLOBALS['cfg']['abs_root_url']}");
		exit();
	}

	$id = get_int64("id");

	$brand = whosonfirst_brands_get_by_id($id);

	if (! $brand){
		error_404();
	}

	$categories = $brand["wof:categories"];

	if (! is_array($categories)){
		$categories = array();
	}

	sort($categories);

	$tree = array();

	foreach ($categories as $mt){

		$rsp = machinetags_parse_machinetag($mt);

		if (! $rsp['ok']){
			continue;
		}

		$ns = $rsp["namespace"];
		$pred = $rsp["predicate"];
		$value = $rsp["value"];

		if (! is_array($tree[$ns])){
			$tree[$ns] = array();
		}

		if (! is_array($tree[$ns][$pred])){
			$tree[$ns][$pred] = array();
		}

		$tree[$ns][$pred][] = $value;
	}

	$supersedes = array();
	$superseded_by = array();

	if (is_array($brand["wof:superseded_by"])){

		foreach ($brand["wof:superseded_by"] as $other_id){

			$other_brand = whosonfirst_brands_get_by_id($other_id);
			$superseded_by[] = $other_brand;		
		}
	}

	if (is_array($brand["wof:supersedes"])){

		foreach ($brand["wof:supersedes"] as $other_id){

			$other_brand = whosonfirst_brands_get_by_id($other_id);
			$supersedes[] = $other_brand;		
		}
	}

	$more = array();

	if ($p = get_int32("page")){
		$more["page"] = $p;
	}	

	# if you're looking at this thinking... wait, WTF??
	# then you'd be correct - it works but it's neither
	# pretty nor does make much sense (beyond you know...
	# working) - it's all still in flux and wrapped up with
	# the way we're doing stuff in the API - it can (should?)
	# all be changed... (20171202/thisisaaronland)

	$filters = array(
		array("term" => array("wof:brand_id" => $id ))
	);

	$rsp = whosonfirst_places_get_by_brand($brand, $filters, $more);

	if (! $rsp["ok"]){
		error_500();
	}

	$places = $rsp["rows"];
	$pagination = $rsp["pagination"];

	$GLOBALS['smarty']->assign_by_ref("brand", $brand);
	$GLOBALS['smarty']->assign_by_ref("superseded_by", $superseded_by);
	$GLOBALS['smarty']->assign_by_ref("supersedes", $supersedes);

	$GLOBALS['smarty']->assign_by_ref("categories", $categories);
	$GLOBALS['smarty']->assign_by_ref("categories_tree", $tree);

	$GLOBALS['smarty']->assign_by_ref("places", $places);
	$GLOBALS['smarty']->assign_by_ref("pagination", $pagination);

	$pagination_url = $GLOBALS['cfg']['abs_root_url'] . "brands/$id/";
	$GLOBALS['smarty']->assign("pagination_url", $pagination_url);

	$GLOBALS['smarty']->display("page_brand.txt");
	exit();
?>