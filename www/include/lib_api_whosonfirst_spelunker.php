<?php

	loadlib("whosonfirst_spelunker");

	########################################################################

	function api_whosonfirst_spelunker_search(){

		$q = request_str("q");

		if (! $q){
			api_output_error(400, "Missing query");
		}
										  
		$query = array(
			'match' => array( '_all' => array(
				'operator' => 'and',
				'query' => $q,
			))
		);

		$filter = array();

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

		$rsp = whosonfirst_spelunker_search($req, $args);


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

	# the end