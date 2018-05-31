<?php

	include("include/init.php");
	loadlib("whosonfirst_places");
	loadlib("whosonfirst_placetypes");
	
	loadlib("whosonfirst_media");
	loadlib("whosonfirst_media_depicts");

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

	if ($parent_id > -1){
		$parent = whosonfirst_places_get_by_id($parent_id);
		$place["wof:parent"] = $parent;
	}

	$search_url = whosonfirst_places_search_referer_url($query, $filters, $args);
	$GLOBALS['smarty']->assign("search_url", $search_url);

	$GLOBALS['smarty']->assign_by_ref("place", $place);

	$photos_more = array(
		"per_page" => 3,
		"random" => 1,
		"medium" => "image"			 
	);

	$viewer_id = ($GLOBALS["cfg"]["user"]) ? $GLOBALS["cfg"]["user"]["id"] : 0;
	$rsp = whosonfirst_media_get_media_for_place($place, $viewer_id, $photos_more);

	if ($rsp["ok"]){

		$photos = $rsp["rows"];
		$photos_pagination = $rsp["pagination"];

		$GLOBALS["smarty"]->assign_by_ref("photos", $photos);
		$GLOBALS["smarty"]->assign_by_ref("photos_pagination", $photos_pagination);
	}

	$rsp = whosonfirst_media_depicts_get_other_places_for_depicted_place($place, $viewer_id);

	if ($rsp["ok"]){
		$GLOBALS["smarty"]->assign_by_ref("also_depicts", $rsp["rows"]);
	}

	$GLOBALS['smarty']->display("page_id.txt");
	exit();
?>
