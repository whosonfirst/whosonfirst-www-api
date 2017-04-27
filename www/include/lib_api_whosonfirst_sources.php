<?php

	loadlib("whosonfirst_sources");

	########################################################################

	function api_whosonfirst_sources_getInfo(){

		$id = request_int64("id");
		$prefix = request_str("prefix");
		
		if ((! $id) && (! $prefix)){
			api_output_error(452);
		}

		if ($id){

			if (! isset($GLOBALS['whosonfirst_sources']['sources_by_id'][$id])){
				api_output_error(432);
			}

			$prefix = $GLOBALS['whosonfirst_sources']['sources_by_id'][$id];
		} 

		if (! isset($GLOBALS['whosonfirst_sources']['sources'][$prefix])){
			api_output_error(433);
		}

		$source = $GLOBALS['whosonfirst_sources']['sources'][$prefix];
		api_whosonfirst_sources_enpublicify_source($source);

		$out = array("source" => $source);

		$more = array(
			'is_singleton' => 1,
			'key' => 'source',
		);

		api_output_ok($out, $more);
	}

	########################################################################

	function api_whosonfirst_sources_getList(){

		ksort($GLOBALS['whosonfirst_sources']['sources']);

		$sources = array();

		foreach ($GLOBALS['whosonfirst_sources']['sources'] as $ignore => $source){
 
			api_whosonfirst_sources_enpublicify_source($source);
			$sources[] = $source;
 		}

		$out = array(
			"sources" => $sources
		);

		$more = array(
			'key' => 'sources',
		);

		api_output_ok($out, $more);
	}

	########################################################################

	function api_whosonfirst_sources_getPrefixes(){

		ksort($GLOBALS['whosonfirst_sources']['sources']);

		$sources = array_keys($GLOBALS['whosonfirst_sources']['sources']);
 
		$out = array(
			"prefixes" => $sources,
		);

		$more = array(
			'key' => 'prefixes',
		);

		api_output_ok($out, $more);
	}

	########################################################################

	function api_whosonfirst_sources_enpublicify_source(&$source){

		ksort($source);

		# pass-by-ref
	}

	########################################################################

	# the end
