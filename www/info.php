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

	# TO DO: HEADERS
	# JSON
	# CORS

	$GLOBALS['smarty']->assign_by_ref("place", $place);
	$GLOBALS['smarty']->display("page_info.txt", $place);

	exit();
?>