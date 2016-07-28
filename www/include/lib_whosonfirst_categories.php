<?php

	loadlib("elasticsearch_spelunker");
	loadlib("machinetags_elasticsearch");

	########################################################################

	function whosonfirst_categories_get_namespaces($args=array()){

		elasticsearch_spelunker_append_config($args);

		return machinetags_elasticsearch_get_namespaces('wof:categories', $args);
	}

	########################################################################

	function whosonfirst_categories_get_predicates($args=array()){

		elasticsearch_spelunker_append_config($args);

		return machinetags_elasticsearch_get_predicates('wof:categories', $args);
	}

	########################################################################

	function whosonfirst_categories_get_values($args=array()){

		elasticsearch_spelunker_append_config($args);

		return machinetags_elasticsearch_get_values('wof:categories', $args);
	}

	########################################################################

	# the end