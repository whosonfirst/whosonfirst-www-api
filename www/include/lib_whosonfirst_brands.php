<?php

	loadlib("elasticsearch");
	loadlib("elasticsearch_brands");

	########################################################################

	function whosonfirst_brands_get_by_id($id, $more=array()){

		$cache_key = "whosonfirst_brand_{$id}";

		$cache = cache_get($cache_key);

		if ($cache['ok']){
			return $cache['data'];
		}

		$query = array('ids' => array(
			'values' => array($id)
		));

		$req = array(
			'query' => $query
		);

		$rsp = elasticsearch_brands_search($req, $more);

		if (! $rsp['ok']){
			return null;
		}

		$row = $rsp['rows'][0];

		cache_set($cache_key, $row);
		return $row;
	}

	########################################################################

	function whosonfirst_brands_property($brand, $path){

		$property = null;

		foreach (explode(".", $path) as $p){

			if (! isset($brand[$p])){
				return null;
			}

			$property = $brand[$p];

			if (is_array($property)){
				$brand = $property;
			}
		}

		return $property;
	}

	########################################################################

	# the end