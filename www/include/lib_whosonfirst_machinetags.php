<?php

	loadlib("elasticsearch_spelunker");
	loadlib("machinetags_elasticsearch");

	########################################################################

	function whosonfirst_machinetags_get_namespaces($args=array()){

		elasticsearch_spelunker_append_config($args);
		$rsp = machinetags_elasticsearch_get_namespaces('machinetags_all', $args);

		if ($rsp['ok']){
			$rsp['rows'] = whosonfirst_machinetags_format_results('namespace', $rsp['rows']);
		}

		return $rsp;
	}

	########################################################################

	function whosonfirst_machinetags_get_predicates($args=array()){

		elasticsearch_spelunker_append_config($args);
		$rsp = machinetags_elasticsearch_get_predicates('machinetags_all', $args);

		if ($rsp['ok']){
			$rsp['rows'] = whosonfirst_machinetags_format_results('predicate', $rsp['rows']);
		}

		return $rsp;
	}

	########################################################################

	function whosonfirst_machinetags_get_values($args=array()){

		elasticsearch_spelunker_append_config($args);
		$rsp = machinetags_elasticsearch_get_values('machinetags_all', $args);

		if ($rsp['ok']){
			$rsp['rows'] = whosonfirst_machinetags_format_results('value', $rsp['rows']);
		}

		return $rsp;
	}

	########################################################################

	function whosonfirst_machinetags_format_results($key, $unformatted){

		$formatted = array();

		foreach ($unformatted as $row){

			$formatted[] = array(
				'count' => $row['doc_count'],
				$key => $row['key'],
			);
		}

		return $formatted;
	}

	########################################################################

	# the end