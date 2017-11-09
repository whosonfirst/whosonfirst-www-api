<?php

	loadlib("elasticsearch");

	########################################################################

	function elasticsearch_brands_search($query, $more=array()){

		elasticsearch_brands_append_config($more);

		$rsp = elasticsearch_search($query, $more);
		return $rsp;
	}

	########################################################################

	function elasticsearch_brands_mget($ids, $more=array()){

		elasticsearch_brands_append_config($more);

		$rsp = elasticsearch_mget($ids, $more);
		return $rsp;
	}

	########################################################################

	function elasticsearch_brands_append_config(&$more){

		$defaults = array(
			'host' => $GLOBALS['cfg']['elasticsearch_brands_host'],
			'port' => $GLOBALS['cfg']['elasticsearch_brands_port'],
			'index' => $GLOBALS['cfg']['elasticsearch_brands_index'],
			'scroll' => false,	# PLEASE PUT ME IN A CONFIG, also see notes in brands.php (20171109/thisisaaronland)
		);

		$more = array_merge($defaults, $more);
	
		# pass by ref
	}	

	########################################################################

	# the end
