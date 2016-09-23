<?php

	include("include/init.php");

	if ($GLOBALS['cfg']['api_require_loggedin']){
		login_ensure_loggedin();
	}

	$GLOBALS['smarty']->display("page_api_oauth2_howto.txt");
	exit();

?>
