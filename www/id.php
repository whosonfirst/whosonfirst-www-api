<?php

	include("include/init.php");
	loadlib("whosonfirst_places");

	if (! get_isset("id")){
		header("location: {$GLOBALS['cfg']['abs_root_url']}");
		exit();
	}

	$id = get_int64("id");

	$place = whosonfirst_places_get_by_id($id);

	if (! $place){
		error_404();
	}

	if (get_isset("nearby")){
		$url = whosonfirst_places_nearby_url_for_place($place);
		header("location: {$url}");
		exit();
	}

	$parent_id = $place["wof:parent_id"];

	if ($parent_id != -1){
		$parent = whosonfirst_places_get_by_id($parent_id);
		$place["wof:parent"] = $parent;
	}

	$GLOBALS['smarty']->assign_by_ref("place", $place);
	$GLOBALS['smarty']->display("page_id.txt");

	exit();
?>