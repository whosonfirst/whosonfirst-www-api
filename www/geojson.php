<?php

	include("include/init.php");
	loadlib("whosonfirst_geojson");

	# For example:
	# RewriteRule  ^data/([0-9/]+)/([0-9]+)\.geojson$		geojson.php?id=$2 [L]

	$id = get_int64("id");

	if (! $id){
		error_404();
	}

	$row = whosonfirst_geojson_get_by_id($id);

	if (! $row){
		error_404();
	}

	header("Content-type: application/json");
	echo $row["body"];

	exit();
?>