<?php
	include("include/init.php");

	error_404();

	login_ensure_loggedin();

	$smarty->display("page_account.txt");
	exit();