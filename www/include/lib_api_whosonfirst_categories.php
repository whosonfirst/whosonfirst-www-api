<?php

	loadlib("whosonfirst_categories");

	########################################################################

	function api_whosonfirst_categories_getNamespaces(){

		$args = array();
		api_utils_ensure_pagination_args($args);

		if ($pred = request_str("predicate")){
			$args['predicate'] = $pred;
		}

		if ($value = request_str("value")){
			$args['value'] = $value;
		}

		$source = api_whosonfirst_categories_ensure_source();
		$rsp = whosonfirst_categories_get_namespaces($source, $args);

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

	function api_whosonfirst_categories_getPredicates(){

		$args = array();
		api_utils_ensure_pagination_args($args);

		if ($ns = request_str("namespace")){
			$args['namespace'] = $ns;
		}

		if ($value = request_str("value")){
			$args['value'] = $value;
		}

		$source = api_whosonfirst_categories_ensure_source();
		$rsp = whosonfirst_categories_get_predicates($source, $args);

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

	function api_whosonfirst_categories_getValues(){

		$args = array();
		api_utils_ensure_pagination_args($args);

		if ($ns = request_str("namespace")){
			$args['namespace'] = $ns;
		}

		if ($pred = request_str("predicate")){
			$args['predicate'] = $pred;
		}

		$source = api_whosonfirst_categories_ensure_source();
		$rsp = whosonfirst_categories_get_values($source, $args);

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

	function api_whosonfirst_categories_getSources(){

		$sources = whosonfirst_categories_sources();
		$out = array('sources' => $sources);
		
		api_output_ok($out);
	}

	########################################################################

	function api_whosonfirst_categories_ensure_source(){
	
		if ($source = request_str("source")){

			$sources = whosonfirst_categories_sources();

			if (! in_array($source, array("wof", "sg"))){
				api_output_error(400, "Invalid source");
			}

			return "{$source}:categories";
		}

		return "categories_all";
	}

	########################################################################

	# the end