<?php

	include("include/init.php");
	loadlib("api");

	features_ensure_enabled("api");
	login_ensure_loggedin();

	$GLOBALS['smarty']->display("page_api.txt");
	exit();
?>
