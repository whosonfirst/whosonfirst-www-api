<?php

	loadlib("machinetags_elasticsearch_wildcard");
	loadlib("machinetags_elasticsearch_hierarchies");

	########################################################################

	function machinetags_elasticsearch_get_namespaces($field, $args=array()){

		$args['filter'] = 'namespaces';
		return machinetags_elasticsearch_hierarchies($field, $args);
	}

	########################################################################


	########################################################################


	########################################################################

	# the end
