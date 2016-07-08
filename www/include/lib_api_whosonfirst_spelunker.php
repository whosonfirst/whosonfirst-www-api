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

		$req = array('query' => array(
			'filtered' => array(
				'query' => $query,
				'filter' => $filter,
			)
		));

		$args = array();
		api_utils_ensure_pagination_args($args);

		$rsp = whosonfirst_spelunker_search($req, $args);

		if (! $rsp['ok']){
			api_output_error(500, "OH NO");
		}

		$rows = $rsp['rows'];
		$pagination = $rsp['pagination'];

		$out = array('results' => $rows);
		api_utils_ensure_pagination_results($out, $pagination);

		api_output_ok($out);
	}

	########################################################################

	# the end