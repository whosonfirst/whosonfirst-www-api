<?php

	loadlib("elasticsearch");

	########################################################################

	function api_whosonfirst_spelunker_search(){

		$q = request_str("q");

		if (! $q){
			api_output_error(400, "Missing query");
		}

		$out = array("query" => $q);		
		api_output_ok($out);		
	}

	########################################################################

	# the end