<?php

	include('include/init.php');
	loadlib('elasticsearch_spelunker');
	loadlib('whosonfirst_places');
	loadlib('search_utils');
	loadlib('api_whosonfirst_utils');
	loadlib('api_whosonfirst_output');

	// This makes the underlying API functions happy. (20170922/dphiffer)
	$_REQUEST['method'] = 'whosonfirst.places.search';

	$query = request_str("q");
	$scope = request_str("scope");
	if ($scope == 'names') {
		$_REQUEST['names'] = $query;
	} else if ($scope == 'default') {
		$_REQUEST['default'] = $query;
	} else if ($scope == 'preferred') {
		$_REQUEST['preferred'] = $query;
	} else if ($scope == 'alt') {
		$_REQUEST['alt'] = $query;
	}

	$GLOBALS['smarty']->assign('query', $query);
	$GLOBALS['smarty']->assign('scope', $scope);

	if ($query) {

		// Based on code from api_whosonfirst_places_search. This should
		// get moved into a library. (20170922/dphiffer)

		$filters = api_whosonfirst_utils_search_filters();

		$args = array(
			'per_page' => 36
		);
		api_utils_ensure_pagination_args($args);

		$rsp = whosonfirst_places_search($query, $filters, $args);

		if (! $rsp['ok']){
			error_500();
		}

		$pagination = $rsp['pagination'];
		$GLOBALS['smarty']->assign('pagination_page_as_queryarg', true);
		$args = http_build_query(array(
			'q' => $query,
			'scope' => $scope
		));
		$GLOBALS['smarty']->assign('pagination_url', $GLOBALS['cfg']['abs_root_url'] . "search/?$args");

		$more = array(
			'extras' => 'addr:,geom:latitude,geom:longitude'
		);
		api_whosonfirst_output_enpublicify($rsp['rows'], $more);

		$out = array(
			'places' => $rsp['rows']
		);

		api_utils_ensure_pagination_results($out, $pagination);
		search_utils_ensure_pagination($query, $out, $pagination);

		$GLOBALS['smarty']->assign_by_ref('results', $out['places']);
		$GLOBALS['smarty']->assign_by_ref('pagination', $pagination);
		$GLOBALS['smarty']->assign('results_start', 1 + $pagination['per_page'] * ($pagination['page'] - 1));
	}

	$GLOBALS['smarty']->display('page_search.txt');
	exit();
