<?php
	include('include/init.php');

	if ($GLOBALS['cfg']['user']){

		$redir = $GLOBALS['cfg']['abs_root_url'] . "api/";
		header("location: $redir");
		exit();
	}

	$GLOBALS['smarty']->display('page_index.txt');
	exit();

?>
