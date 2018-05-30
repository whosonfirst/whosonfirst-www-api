<?php

	include("include/init.php");
	loadlib("whosonfirst_places");
	
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

	$GLOBALS['smarty']->assign_by_ref("place", $place);

	$photos_more = array(
		"medium" => "image"			 
	);

	if ($page = get_int32("page")){
		$photos_more["page"] = $page;
	}
	
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

	$GLOBALS['smarty']->display("page_id_photos.txt");
	exit();
?>
