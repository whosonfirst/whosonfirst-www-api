<?php

	loadlib("elasticsearch");
	loadlib("elasticsearch_spelunker");

	loadlib("machinetags");
	loadlib("machinetags_elasticsearch");

	loadlib("api_whosonfirst_utils");

	########################################################################

	# TO DO - move all this in to a not-api library (20160718/thisisaaronland)

	function api_whosonfirst_spelunker_search(){

		$q = request_str("q");

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

		$filters = api_whosonfirst_utils_search_filters();

		if (($q == "") && (! count($filters))){
			api_output_error(400, "E_INSUFFICIENT_QUERY");
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

		# dumper($filter_query);

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

		$out = array(
			# 'query' => $es_query,
			'results' => $rows
		);

		api_utils_ensure_pagination_results($out, $pagination);
		api_output_ok($out);
	}

	########################################################################

	# the end
