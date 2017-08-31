<?php

	include("include/init.php");
	loadlib("whosonfirst_placetypes");

	$pt = get_str("placetype");

	if (! $pt){
		error_404();
	}

	if (! whosonfirst_placetypes_is_valid_placetype($pt)){
		error_404();
	}

	$GLOBALS['smarty']->assign_by_ref("placetype", $pt);
	$GLOBALS['smarty']->display("page_placetype.txt");

	exit();
?>	