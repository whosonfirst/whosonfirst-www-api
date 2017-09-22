<?php

	include('include/init.php');
	loadlib('elasticsearch_spelunker');
	loadlib('whosonfirst_places');
	loadlib('search_utils');
	loadlib('api_whosonfirst_utils');
	loadlib('api_whosonfirst_output');

	$q = request_str("q");

	// Coerce something that looks like a search. (20170922/dphiffer)
	$_REQUEST['names'] = $q;
	$_REQUEST['method'] = 'whosonfirst.places.search';

	$GLOBALS['smarty']->assign('query', $q);

	if ($q) {

		// Based on code from api_whosonfirst_places_search. This should
		// get moved into a library. (20170922/dphiffer)

		$filters = api_whosonfirst_utils_search_filters();

		$args = array(
			'per_page' => 36
		);
		api_utils_ensure_pagination_args($args);
		dumper($args);

		$rsp = whosonfirst_places_search($q, $filters, $args);

		if (! $rsp['ok']){
			error_500();
		}

		$more = array();
		$pagination = $rsp['pagination'];

		api_whosonfirst_output_enpublicify($rsp['rows'], $more);

		$out = array(
			'places' => $rsp['rows']
		);

		api_utils_ensure_pagination_results($out, $pagination);
		search_utils_ensure_pagination($q, $out, $pagination);

		//dumper($out['next_query']);

		$GLOBALS['smarty']->assign_by_ref('results', $out['places']);
		$GLOBALS['smarty']->assign_by_ref('pagination', $pagination);
		$GLOBALS['smarty']->assign('results_start', 1 + $pagination['per_page'] * ($pagination['page'] - 1));

		$an_placetypes = array(
			'address',
			'empire',
			'intersection',
			'ocean'
		);
		$GLOBALS['smarty']->assign_by_ref('an_placetypes', $an_placetypes);

		$GLOBALS['smarty']->assign('id_key', 'wof:id');
		$GLOBALS['smarty']->assign('name_key', 'wof:name');
		$GLOBALS['smarty']->assign('placetype_key', 'wof:placetype');
		$GLOBALS['smarty']->assign('country_key', 'wof:country');
	}

	$GLOBALS['smarty']->display('page_search.txt');
	exit();
