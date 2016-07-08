<?php

	loadlib("elasticsearch");
	loadlib("elasticsearch_spelunker");

	########################################################################

	function api_whosonfirst_spelunker_search(){

		$q = request_str("q");

		if (! $q){
			api_output_error(400, "Missing query");
		}

		$esc_q = elasticsearch_escape($q);
		
		$query = array(
			'match' => array( '_all' => array(
				'operator' => 'and',
				'query' => $esc_q,
			))
		);

		$filter = api_whosonfirst_search_filters();

		$filter_query = array('filtered' => array(
			'query' => $query,
			'filter' => $filter,
		));

		$functions = array(
			array(
				'filter' => array('not' => array('term' => array('wof:placetype' => 'venue'))),
				'weight' => 2.0
			),
			array(
				'filter' => array('exists' => array('field' => 'wk:population')),
				'weight' => 1.25
			),
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

		$args = array();
		api_utils_ensure_pagination_args($args);

		$rsp = elasticsearch_spelunker_search($req, $args);

		if (! $rsp['ok']){
			api_output_error(500, $rsp['error']);
		}

		$rows = $rsp['rows'];
		$pagination = $rsp['pagination'];

		$out = array('results' => $rows);
		api_utils_ensure_pagination_results($out, $pagination);

		api_output_ok($out);
	}

	########################################################################

	function api_whosonfirst_spelunker_search_filters(){

		$placetype = request_str("placetype");
		$iso = request_str("iso");

		$tag = request_str("tag");		     
		$machinetag = request_str("mt");

		$name = request_str("name");			# wof:name
		$names = request_str("names");			# names_all

		$preferred = request_str("preferred");		# names_preferred
		$alt = request_str("alt");			# names_colloquial; names_variant

		$colloquial = request_str("colloquial");	# names_colloquial
		$variant = request_str("variant");		# names_variant

		$concordance = request_str("concordance");
		
		$country = request_int64("country_id");
		$region = request_int64("region_id");
		$locality = request_int64("locality_id");
		$neighbourhood = request_int64("neighbourhood_id");

		$exclude = request_str("exclude");
		$include = request_str("include");

		$nullisland = true;
		$deprecated = false;
		
		$filters = array();
		$must_not = array();

		if (! $nullisland){

			$must_not[] = array('term' => array('geom:latitude' => 0.0));
			$must_not[] = array('term' => array('geom:longitude' => 0.0));	
		}

		if (! $deprecated){

			$must_not[] = array('exists' => array('field' => 'edtf:deprecated'));
		}

		if ($placetype){

			$esc_placetype = elasticsearch_escape($placetype);
			$filters[] = array('term' => array('wof:placetype' => $esc_placetype));
		}

		# tag here

		# categories here

		# machine tags here

		$simple = array(
			"iso:country" => $iso,
			"names_all" => $names,
			"names_preferred" => $preferred,
			"names_alt" => $alt,
			"names_colloquial" => $colloquial,
			"names_variant" => $variant,
			"wof:name" => $name,
			"country_id" => $country,
			"region_id" => $region,
			"locality_id" => $locality,
			"neighbourhood_id" => $neighbourhood,
			"wof:concordances_sources" => $concordance,
		);

		foreach ($simple as $field => $input){

			if ($input){
				$filters[] = api_whosonfirst_spelunker_enfilterify_simple($field, $input);
			}
		}
		
		if (count($must_not)){
			$filters[] = array('bool' => array('must_not' => $must_not));
		}

		return $filters;
	}
	
	########################################################################

	function api_whosonfirst_spelunker_enfilterify_simple($field, $terms){

		if (! is_array($terms)){
			$terms = array($terms);
		}
		
		if (count($terms) == 1){

			$term = $terms[0];
			$esc_term = elasticsearch_escape($term);

			return array('query' => array(
				'match' => array($field => array(
					'query' => $esc_term, 'operator' => 'and'
				)
			));
		}

		$must = array();
		
		foreach ($terms as $term){

			$esc_term = elasticsearch_escape($term);
			
			$must[] = array('query' => array(
				'match' => array($field => array(
					'query' => $esc_term, 'operator' => 'and'
				)
			));
		}

		return array('bool' => array(
			'must' => $must
		));
	}
	
	########################################################################
	
	# the end
