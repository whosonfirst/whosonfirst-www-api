<?php

	loadlib("elasticsearch");
	loadlib("elasticsearch_spelunker");

	loadlib("machinetags");
	loadlib("machinetags_elasticsearch");

	########################################################################

	function whosonfirst_machinetags_get_namespaces($args){

		return whosonfirst_machinetags_hierarchies($args);
	}

	########################################################################

	function whosonfirst_machinetags_get_predicates($args){

		return whosonfirst_machinetags_hierarchies($args);
	}

	########################################################################

	function whosonfirst_machinetags_get_values($args){

		return whosonfirst_machinetags_hierarchies($args);
	}

	########################################################################

	function whosonfirst_machinetags_hierarchies($args){

		$aggrs = array('hierarchies' => array(
			'terms' => 'field' => 'machinetags', 'size' => 0
		));

		list($include_filter, $exclude_filter) = machinetags_elasticsearch_hierarchy_query_filters($args);

		if ($include_filter){
			$aggrs['hierarchies']['terms']['include'] = $include_filter;
		}

		if ($exlude_filter){
			$aggrs['hierarchies']['terms']['exclude'] = $exclude_filter;
		}

	}

	########################################################################

	# the end