<?php

	loadlib("elasticsearch");
	loadlib("machinetags_elasticsearch_wildcard");
	loadlib("machinetags_elasticsearch_hierarchies");

	########################################################################

	function machinetags_elasticsearch_get_namespaces($field, $args=array()){

		$args['filter'] = 'namespaces';
		return machinetags_elasticsearch_hierarchies($field, $args);
	}

	########################################################################

	function machinetags_elasticsearch_get_predicates($field, $args=array()){

		$args['filter'] = 'predicates';
		return machinetags_elasticsearch_hierarchies($field, $args);
	}

	########################################################################

	function machinetags_elasticsearch_get_values($field, $args=array()){

		$args['filter'] = 'values';
		return machinetags_elasticsearch_hierarchies($field, $args);
	}

	########################################################################

	function machinetags_elasticsearch_hierarchies($field, $more=array()){

		list($include_filter, $exclude_filter, $rsp_filter) = machinetags_elasticsearch_hierarchies_query_filters($more);

		if ($include_filter){
			$more['include_filter'] = $include_filter;
		}

		if ($exlude_filter){
			$more['exclude_filter'] = $exclude_filter;
		}

		$more['search_type'] = 'count';

		# TO DO: do not paginate here - see below, basically we want
		# to paginate after the filtering (20160728/thisisaaronland)

		$rsp = elasticsearch_facet($field, $more);

		if (! $rsp['ok']){
			return $rsp;
		}

		if ($rsp_filter){
			$rsp['rows'] = call_user_func($rsp_filter, $rsp['rows']);
		}

		# return machinetags_elasticsearch_paginate_filtered_results($rsp, $more);
		return $rsp;
	}

	########################################################################

	function machinetags_elasticsearch_paginate_results($results, $more=array()){

		$page = isset($more['page']) ? max(1, $more['page']) : 1;
		$per_page = isset($more['per_page']) ? max(1, $more['per_page']) : $GLOBALS['cfg']['pagination_per_page'];

		$offset = ($page - 1) * $per_page;

		$total_count = count($results);
		$page_count = ceil($total_count / $per_page);
		$last_page_count = $total_count - (($page_count - 1) * $per_page);

		$pagination = array(
			'total_count' => $total_count,
			'page' => $page,
			'per_page' => $per_page,
			'page_count' => $page_count,
		);

		$results = array_slice($results, $offset, $per_page, 'preserve keys');

		return array(
			'ok' => 1,
			'aggregations' => $results,
			'pagination' => $pagination,
		);
	}

	########################################################################

	# the end
