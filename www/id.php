<?php

	include("include/init.php");

	loadlib("whosonfirst_places");

	$id = get_int64("id");

	$place = whosonfirst_places_get_by_id($id);

	if (! $place){
		error_404();
	}

	$GLOBALS['smarty']->assign_by_ref("place", $place);
	
	$GLOBALS['smarty']->display("page_id.txt", $place);
	exit();
?>