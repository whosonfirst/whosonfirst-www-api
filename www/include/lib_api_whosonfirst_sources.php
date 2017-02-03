<?php

	loadlib("whosonfirst_sources");

	########################################################################

	function api_whosonfirst_sources_getInfo(){

		$id = request_int64("id");
		$prefix = request_str("prefix");
		
		if ((! $id) && (! $prefix)){
			api_output_error(400, "Missing ID or prefix parameter");
		}

		if ($id){

			if (! isset($GLOBALS['whosonfirst_sources']['sources_by_id'][$id])){
				api_output_error(400, "Invalid source ID");
			}

			$prefix = $GLOBALS['whosonfirst_sources']['sources_by_id'][$id];
		} 

		if (! isset($GLOBALS['whosonfirst_sources']['sources'][$prefix])){
			api_output_error(400, "Invalid source prefix");
		}

		$source = $GLOBALS['whosonfirst_sources']['sources'][$prefix];

		$out = array("source" => $source);
		api_output_ok($out);
	}

	########################################################################

	function api_whosonfirst_sources_getList(){

		ksort($GLOBALS['whosonfirst_sources']['sources']);

		$sources = array_values($GLOBALS['whosonfirst_sources']['sources']);
 
		$out = array(
			"sources" => $sources
		);

		api_output_ok($out);
	}

	########################################################################

	function api_whosonfirst_sources_getPrefixes(){

		ksort($GLOBALS['whosonfirst_sources']['sources']);

		$sources = array_keys($GLOBALS['whosonfirst_sources']['sources']);
 
		$out = array(
			"prefixes" => $prefixes
		);

		api_output_ok($out);
	}

	########################################################################

	# the end
