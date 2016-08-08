<?php

	loadlib("elasticsearch_spelunker");
	loadlib("machinetags_elasticsearch");

	########################################################################

	function whosonfirst_categories_sources(){

		$sources = array(
			"mz",
			"osm",
			"sg",
			"wof"
		);

		return $sources;
	}

	########################################################################

	function whosonfirst_categories_is_valid_source($source){

		$sources = whosonfirst_categories_sources();
		return (in_array($source, $sources)) ? 1 : 0;
	}

	########################################################################

	function whosonfirst_categories_get_namespaces($field, $args=array()){

		elasticsearch_spelunker_append_config($args);
		$rsp = machinetags_elasticsearch_get_namespaces($field, $args);

		if ($rsp['ok']){
			$rsp['rows'] = whosonfirst_categories_format_results('namespace', $rsp['rows']);
		}

		return $rsp;
	}

	########################################################################

	function whosonfirst_categories_get_predicates($field, $args=array()){

		elasticsearch_spelunker_append_config($args);
		$rsp = machinetags_elasticsearch_get_predicates($field, $args);

		if ($rsp['ok']){
			$rsp['rows'] = whosonfirst_categories_format_results('namespace', $rsp['rows']);
		}

		return $rsp;
	}

	########################################################################

	function whosonfirst_categories_get_values($field, $args=array()){

		elasticsearch_spelunker_append_config($args);
		$rsp = machinetags_elasticsearch_get_values($field, $args);

		if ($rsp['ok']){
			$rsp['rows'] = whosonfirst_categories_format_results('namespace', $rsp['rows']);
		}

		return $rsp;
	}

	########################################################################


	function whosonfirst_categories_format_results($key, $unformatted){

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