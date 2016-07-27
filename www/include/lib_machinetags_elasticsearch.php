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

		$rsp = elasticsearch_facet($field, $more);

		if (! $rsp['ok']){
			return $rsp;
		}

		if ($rsp_filter){
			$rsp['rows'] = call_user_func($rsp_filter, $rsp['rows']);
		}

		return $rsp;
	}

	########################################################################

	# the end
