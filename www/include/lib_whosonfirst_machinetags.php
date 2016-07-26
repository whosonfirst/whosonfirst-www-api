<?php

	loadlib("elasticsearch_spelunker");
	loadlib("machinetags_elasticsearch_hierarchies");

	########################################################################

	function whosonfirst_machinetags_get_namespaces($args=array()){

		$args['filter'] = 'namespaces';
		return whosonfirst_machinetags_hierarchies('machinetags_all', $args);
	}

	########################################################################

	function whosonfirst_machinetags_get_predicates($args=array()){

		$args['filter'] = 'predicates';
		return whosonfirst_machinetags_hierarchies('machinetags_all', $args);
	}

	########################################################################

	function whosonfirst_machinetags_get_values($args=array()){

		$args['filter'] = 'values';
		return whosonfirst_machinetags_hierarchies('machinetags_all', $args);
	}

	########################################################################

	function whosonfirst_machinetags_hierarchies($field, $args){

		$aggrs = array('hierarchies' => array(
			'terms' => array('field' => $field, 'size' => 0)
		));

		list($include_filter, $exclude_filter, $rsp_filter) = machinetags_elasticsearch_hierarchies_query_filters($args);

		if ($include_filter){
			$aggrs['hierarchies']['terms']['include'] = $include_filter;
		}

		if ($exlude_filter){
			$aggrs['hierarchies']['terms']['exclude'] = $exclude_filter;
		}

		# curl -XGET 'http://example.com:9200/whosonfirst/_search?search_type=count' \
		# -d '{"aggregations": {"hierarchies": {"terms": {"exclude": ".*\\\\/.*", "field": "machinetags_all", "size": 0}}}}'

		$req = array(
			'aggregations' => $aggrs,
		);

		$more = array(
			'search_type' => 'count'
		);

		# TO DO - update all the things so that we can use elasticsearch_facet

		$rsp = elasticsearch_spelunker_search($req, $more);

		if (! $rsp['ok']){
			return $rsp;
		}

		$body = json_decode($rsp['body'], 'as hash');

		$aggregations = $body['aggregations'];
		$hierarchies = $aggregations['hierarchies'];
		$buckets = $hierarchies['buckets'];

		if ($rsp_filter){
			$buckets = call_user_func($rsp_filter, $buckets);
		}

		return array(
			'ok' => 1,
			'rows' => $buckets,
		);

		return $rsp;
	}

	########################################################################

	# the end