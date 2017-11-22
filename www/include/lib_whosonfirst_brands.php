<?php

	loadlib("elasticsearch");
	loadlib("elasticsearch_brands");


	########################################################################

	function whosonfirst_brands_search($q, $more=array()){

		$esc_q = elasticsearch_escape($q);

		$query = array("match" => array(
			"_all" => array(
				"query" => $esc_q,
				"operator" => "and",
			)
		));

		$sort = array(
			"wof:brand_name" => array("order" => "asc")
		);

		$req = array(
			"query" => $query,
			"sort" => $sort,
		);

		$rsp = elasticsearch_brands_search($req, $more);		
		return $rsp;
	}

	########################################################################

	function whosonfirst_brands_get_brands($more=array()){

		$query = array(
			"match_all" => array()
		);

		$filter = array();

		$sort = array(array(
			"wof:brand_name" => array("order" => "asc")
		));

		$req = array("filtered" => array(
			"filter" => $filter,
			"query" => $query,
		));

		$req = array(
			"query" => $query,
			"sort" => $sort,
		);

		$rsp = elasticsearch_brands_search($req, $more);		
		return $rsp;
	}

	########################################################################

	function whosonfirst_brands_get_by_id_multi($ids, $more=array()){

		return elasticsearch_brands_mget($ids, $more);
	}

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

	function whosonfirst_brands_url_for_brand($brand){

		$enc_id = urlencode($brand["wof:brand_id"]);
		return $GLOBALS["cfg"]["abs_root_url"] . "brands/{$enc_id}/";
	}

	########################################################################

	# the end