<?php

	# code to work with tables indexed by this:
	# https://github.com/whosonfirst/go-whosonfirst-mysql

	# see also: www/geojson.php

	########################################################################

	function whosonfirst_geojson_get_by_id($id){

		$enc_id = AddSlashes($id);

		$sql = "SELECT * FROM geojson WHERE id='{$enc_id}'";
	     	$rsp = db_fetch($sql);
		$rsp = db_single($rsp);

		return $rsp;
	}

	########################################################################

	# the end
	