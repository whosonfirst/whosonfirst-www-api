<?php

	loadlib("whosonfirst_machinetags");

	########################################################################

	function api_whosonfirst_machinetags_getNamespaces(){

		$args = array();
		api_utils_ensure_pagination_args($args);

		if ($pred = request_str("predicate")){
			$args['predicate'] = $pred;
		}

		$rsp = whosonfirst_machinetags_get_namespaces($args);

		if (! $rsp['ok']){
			api_output_error(500, $rsp['error']);
		}

		$pagination = $rsp['pagination'];

		$out = array(
			'namespaces' => $rsp['rows']
		);

		api_utils_ensure_pagination_results($out, $pagination);
		api_output_ok($out);
	}

	########################################################################

	function api_whosonfirst_machinetags_getPredicates(){

		$args = array();
		api_utils_ensure_pagination_args($args);

		if ($ns = request_str("namespace")){
			$args['namespace'] = $ns;
		}

		$rsp = whosonfirst_machinetags_get_predicates($args);

		if (! $rsp['ok']){
			api_output_error(500, $rsp['error']);
		}

		$pagination = $rsp['pagination'];

		$out = array(
			'predicates' => $rsp['rows']
		);

		api_utils_ensure_pagination_results($out, $pagination);
		api_output_ok($out);
	}

	########################################################################

	function api_whosonfirst_machinetags_getValues(){

		$args = array();
		api_utils_ensure_pagination_args($args);

		if ($ns = request_str("namespace")){
			$args['namespace'] = $ns;
		}

		if ($pred = request_str("predicate")){
			$args['predicate'] = $pred;
		}

		$rsp = whosonfirst_machinetags_get_values($args);

		if (! $rsp['ok']){
			api_output_error(500, $rsp['error']);
		}

		$pagination = $rsp['pagination'];

		$out = array(
			'values' => $rsp['rows']
		);

		api_utils_ensure_pagination_results($out, $pagination);
		api_output_ok($out);
	}

	########################################################################

	# the end