<?php
	include('include/init.php');

	if (! $GLOBALS['cfg']['user']){
		header("location: https://mapzen.com/documentation/wof/");
		exit();
	}

	$GLOBALS['smarty']->display('page_index.txt');
	exit();

?>
