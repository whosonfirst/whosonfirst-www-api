<?php
	include('include/init.php');
	error_404();

	$smarty->display('page_about.txt');
	exit();