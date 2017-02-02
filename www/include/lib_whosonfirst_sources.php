<?php

	loadlib("whosonfirst_sources_spec");

	########################################################################

	# Hey look! Running code!! (20161010/thisisaaronland)
	
	$GLOBALS['whosonfirst_sources']['spec'] = json_decode($GLOBALS['whosonfirst_sources']['__SPEC__'], "as hash");

	if (! $GLOBALS['whosonfirst_sources']['spec']){
		log_fatal("failed to parse sources spec");
	}

	# Hey look! More running code!!! (20170202/thisisaaronland)
	
	$GLOBALS['whosonfirst_sources']['sources_by_id'] = array();
	$GLOBALS['whosonfirst_sources']['sources'] = array();

	foreach ($GLOBALS['whosonfirst_sources']['spec'] as $id => $details){

		$prefix = $details["prefix"];

		$GLOBALS['whosonfirst_sources']['sources'][$prefix] = $details;
		$GLOBALS['whosonfirst_sources']['sources_by_id'][$id] = $prefix;
	}

	########################################################################
	
	function whosonfirst_sources_is_valid_prefix($prefix){

		if (! isset($GLOBALS['whosonfirst_sources']['sources'][$prefix])){
			return 0;
		}

		return 1;
	}
	
	########################################################################
	# the end
