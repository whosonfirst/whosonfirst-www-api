<?php

	loadlib("iso639");

	loadlib("elasticsearch");
	loadlib("elasticsearch_spelunker");

	########################################################################

	function whosonfirst_places_get_by_id($id, $more=array()){

		$cache_key = "whosonfirst_{$id}";

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

		$rsp = elasticsearch_spelunker_search($req, $more);

		if (! $rsp['ok']){
			return null;
		}

		$row = $rsp['rows'][0];

		cache_set($cache_key, $row);
		return $row;
	}

	########################################################################

	function whosonfirst_places_get_by_id_multi($ids, $more=array()){

		return elasticsearch_spelunker_mget($ids, $more);	
	}

	########################################################################

	function whosonfirst_places_get_random($more=array()){

		$seed = rand(0, time());

		$empty = new stdClass;			# I hate you, PHP...

		$country = iso639_random();
		$code = $country['alpha2'];

		$code = strtolower($code);	# I also hate you too, Elasticsearch...

		$must = array();

		$must_not = array(
			array('term' => array('geom:latitude' => '0.0' )),
			array('term' => array('geom:longitude' => '0.0' )),
		);

		$query = array(
			'function_score' => array(

				# the old way

				# 'query' => array(
				# 	'match_all' => $empty
				# ),

				# the new way

				'query' => array(
					'filtered' => array(
						'query' => array('term' => array('wof:country' => $code)),
						'filter' => array(
							'and' => array(
								array('bool' => array('must_not' => $must_not)),
								array('bool' => array('must' => $must))
							)
						)
					)
				),
				'functions' => array(
					array('random_score' => array('seed' => $seed))
				)
			)
		);

		$req = array(
			'query' => $query
		);

		$more['per_page'] = 1;

		$rsp = elasticsearch_spelunker_search($req, $more);
		return $rsp;
	}

	########################################################################

	function whosonfirst_places_search($q, $filters, $more=array()){

		if ($q == ""){

			$esc_q = "*";

			$empty = new stdClass;
			$query = array('match_all' => $empty);
		}

		else {
			$esc_q = elasticsearch_escape($q);
		
			$query = array(
				'match' => array( '_all' => array(
					'operator' => 'and',
					'query' => $esc_q,
				))
			);
		}

		$filter_query = array('filtered' => array(
			'query' => $query,
			'filter' => array('and' => $filters),
		));

		$functions = array();

		if ($q != ""){

			$functions = array(
				array(
					'filter' => array('term' => array('names_preferred' => $esc_q)),
					'weight' => 3.0
				),
				array(
					'filter' => array('term' => array('names_alt' => $esc_q)),
					'weight' => 1.0
				),
				array(
					'filter' => array('term' => array('wof:name' => $esc_q)),
					'weight' => 1.5
				),
			);
		}

		$functions[] = array(
			'filter' => array('not' => array('term' => array('wof:placetype' => 'venue'))),
			'weight' => 2.0
		);

		$functions[] = 	array(
			'filter' => array('exists' => array('field' => 'wk:population')),
			'weight' => 1.25
		);

		$sort = array(
			array('geom:area' =>  array('mode' => 'max', 'order' => 'desc')),
			array('wof:scale' => array('mode' => 'max', 'order' => 'desc')),
			array('wof:megacity' => array('mode' => 'max', 'order' => 'desc')),
			array('gn:population' => array('mode' => 'max', 'order' => 'desc')),
		);

		$es_query = array('function_score' => array(
			'query' => $filter_query,
			'functions' => $functions,
			'boost_mode' => 'multiply',
			'score_mode' => 'multiply',
		));

		$req = array(
			'query' => $es_query,
			'sort' => $sort,
		);

		$rsp = elasticsearch_spelunker_search($req, $more);
		return $rsp;
	}

	########################################################################

	function whosonfirst_places_get_descendants($wofid, $filters, $more=array()){

		$esc_id = elasticsearch_escape($wofid);

		$query = array('term' => array(
			'wof:belongsto' => $esc_id
		));

		if (count(array_keys($filters))){

			$query = array('filtered' => array(
				'query' => $query,
				'filter' => array('and' => $filters),
			));
		}

		$sort = array(
			array('wof:id' =>  array('mode' => 'max', 'order' => 'asc')),
		);

		$req = array(
			'query' => $query,
			'sort' => $sort,
		);

		$rsp = elasticsearch_spelunker_search($req, $more);
		return $rsp;
	}

	########################################################################

	function whosonfirst_places_get_tagged($tag, $filters, $more=array()){

		$esc_tag = elasticsearch_escape($tag);

		$query = array("match" => array(
			"wof:tags" => $esc_tag
		));

		$req = array(
			"query" => $query,
			'filter' => array('and' => $filters),
		);

		$rsp = elasticsearch_spelunker_search($req, $more);
		return $rsp;
	}

	########################################################################

	function whosonfirst_places_property($place, $path){

		$property = null;

		foreach (explode(".", $path) as $p){
		
			if (! isset($place[$p])){
				return null;
			}

			$property = $place[$p];

			if (is_array($property)){
				$place = $property;
			}
		}

		return $property;
	}

	########################################################################

	function whosonfirst_places_url_for_place($place){

		$enc_id = urlencode($place["wof:id"]);
		return $GLOBALS["cfg"]["abs_root_url"] . "id/{$enc_id}/";
	}

	########################################################################

	function whosonfirst_places_nearby_url_for_place($place){

		$enc_id = urlencode($place["wof:id"]);
		return $GLOBALS["cfg"]["abs_root_url"] . "nearby/{$enc_id}/";
	}

	########################################################################

	function whosonfirst_places_data_url_for_place($place){

		loadlib("whosonfirst_uri");
		return whosonfirst_uri_id2abspath("https://whosonfirst.mapzen.com/data", $place["wof:id"]);
	}

	########################################################################

	# the end