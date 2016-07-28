<?php

	loadlib("elasticsearch_spelunker");
	loadlib("machinetags_elasticsearch");

	########################################################################

	function whosonfirst_categories_sources(){

		$sources = array(
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
		return machinetags_elasticsearch_get_namespaces($field, $args);
	}

	########################################################################

	function whosonfirst_categories_get_predicates($field, $args=array()){

		elasticsearch_spelunker_append_config($args);
		return machinetags_elasticsearch_get_predicates($field, $args);
	}

	########################################################################

	function whosonfirst_categories_get_values($field, $args=array()){

		elasticsearch_spelunker_append_config($args);
		return machinetags_elasticsearch_get_values($field, $args);
	}

	########################################################################

	# the end