<?php

	loadlib("elasticsearch_spelunker");
	loadlib("machinetags_elasticsearch");

	########################################################################

	function whosonfirst_machinetags_get_namespaces($args=array()){

		elasticsearch_spelunker_append_config($args);

		return machinetags_elasticsearch_get_namespaces('machinetags_all', $args);
	}

	########################################################################

	function whosonfirst_machinetags_get_predicates($args=array()){

		elasticsearch_spelunker_append_config($args);

		return machinetags_elasticsearch_get_predicates('machinetags_all', $args);
	}

	########################################################################

	function whosonfirst_machinetags_get_values($args=array()){

		elasticsearch_spelunker_append_config($args);

		return machinetags_elasticsearch_get_value('machinetags_all', $args);
	}

	########################################################################

	# the end