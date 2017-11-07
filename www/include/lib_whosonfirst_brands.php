<?php

	loadlib("elasticsearch");
	loadlib("elasticsearch_spelunker");

	########################################################################

	function whosonfirst_brands_get_by_id($id, $more=array()){

		return null;

		$cache_key = "whosonfirst_brand_{$id}";

		$cache = cache_get($cache_key);

		if ($cache['ok']){
			return $cache['data'];
		}

		$row = $rsp['rows'][0];

		cache_set($cache_key, $row);
		return $row;
	}

	########################################################################

	# the end