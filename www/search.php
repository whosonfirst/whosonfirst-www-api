<?php

	include('include/init.php');
	loadlib('elasticsearch_spelunker');
	loadlib('whosonfirst_places');
	loadlib('api_whosonfirst_utils');
	loadlib('api_whosonfirst_output');

	// Coerce a 'names' search. (20170922/dphiffer)
	$_REQUEST['names'] = $_REQUEST['q'];

	$q = request_str("q");
	$GLOBALS['smarty']->assign('query', $q);

	// Based on code from api_whosonfirst_places_search. This should
	// get moved into a library. (20170922/dphiffer)

	$filters = api_whosonfirst_utils_search_filters();

	$args = array(
		//'per_page' => 36
	);
	api_utils_ensure_pagination_args($args);

	$rsp = whosonfirst_places_search($q, $filters, $args);

	if (! $rsp['ok']){
		error_500();
	}

	$more = array();

	api_whosonfirst_output_enpublicify($rsp['rows'], $more);

	$GLOBALS['smarty']->assign_by_ref('results', $rsp['rows']);
	$GLOBALS['smarty']->assign_by_ref('pagination', $rsp['pagination']);

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

	$GLOBALS['smarty']->assign('pagination_url', 'search/?q=' . rawurlencode($q));
	$GLOBALS['smarty']->assign('pagination_page_as_queryarg', true);

	$GLOBALS['smarty']->display('page_search.txt');
	exit();
