<?php

	loadlib("elasticsearch");
	loadlib("elasticsearch_spelunker");

	########################################################################

	function api_whosonfirst_concordances_getById(){

		$id = request_str("id");

		if (! $id){
			api_output_error(400, "Missing 'id' parameter");
		}

		$source = request_str("source");

		if (! $source){
			$source = "wof";
		}

		
	}

	########################################################################
	
	# the end