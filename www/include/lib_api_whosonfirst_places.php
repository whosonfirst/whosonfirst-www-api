<?php

	loadlib("whosonfirst_places");

	loadlib("api_whosonfirst_output");
	loadlib("api_whosonfirst_utils");

	########################################################################

	function api_whosonfirst_places_search(){

		$q = request_str("q");

		$filters = api_whosonfirst_utils_search_filters();

		if (($q == "") && (! count($filters))){
			api_output_error(400, "E_INSUFFICIENT_QUERY");
		}

		$args = array();
		api_utils_ensure_pagination_args($args);

		$rsp = whosonfirst_places_search($q, $filters, $args);

		if (! $rsp['ok']){
			api_output_error(500, $rsp['error']);
		}

		api_whosonfirst_output_enpublicify($rsp['rows']);
		$pagination = $rsp['pagination'];

		$out = array(
			'results' => $rsp['rows']
		);

		api_utils_ensure_pagination_results($out, $pagination);
		api_output_ok($out);
	}

	########################################################################

	function api_whosonfirst_places_getInfo(){

		# please write me
	}

	########################################################################

	function api_whosonfirst_places_getDescendants(){

		$wofid = request_int64("id");

		if (! $wofid){
			api_output_error(400, "Missing 'id' parameter");
		}

		$filters = api_whosonfirst_utils_search_filters();
		$args = array();

		api_utils_ensure_pagination_args($args);

		$rsp = whosonfirst_places_get_descendants($wofid, $filters, $args);

		if (! $rsp['ok']){
			api_output_error(500, $rsp['error']);
		}

		$rows = $rsp['rows'];
		$pagination = $rsp['pagination'];

		$out = array(
			'results' => $rows
		);

		api_utils_ensure_pagination_results($out, $pagination);
		api_output_ok($out);	
	}

	########################################################################

	# the end