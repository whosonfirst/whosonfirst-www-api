<?php

	include("include/init.php");
	loadlib("admin");
	loadlib("uploads");

	admin_ensure_admin();

	$id = get_int64("id");

	if (! $id){
		error_404();
	}

	$upload = uploads_get_by_id($id);

	if (! $upload){
		error_404();
	}

	uploads_inflate_upload($upload);

	$GLOBALS["smarty"]->assign_by_ref("upload", $upload);

	$GLOBALS["smarty"]->display("page_admin_upload.txt");
	exit();
	
	
	