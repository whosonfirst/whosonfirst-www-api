<?php

	loadlib("elasticsearch");
	loadlib("elasticsearch_spelunker");

	########################################################################

	function whosonfirst_tags_sources(){

		$sources = array(
			"sg",
			"wof"
		);

		return $sources;
	}

	########################################################################

	function whosonfirst_tags_is_valid_source($source){

		$sources = whosonfirst_tags_sources();
		return (in_array($source, $sources)) ? 1 : 0;
	}

	########################################################################

	function whosonfirst_tags_get_tags($field, $args=array()){

		elasticsearch_spelunker_append_config($args);
		$rsp = elasticsearch_facet($field, $args);

		if (! $rsp['ok']){
			return $rsp;
		}

		$rows = array();

		if ($rsp['ok']){
			$rsp['rows'] = whosonfirst_tags_format_results('tag', $rsp['rows']);
		}

		return $rsp;
	}

	########################################################################

	function whosonfirst_tags_format_results($key, $unformatted){

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