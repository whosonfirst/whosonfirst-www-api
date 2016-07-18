<?php

	loadlib("elasticsearch");

	########################################################################

	function elasticsearch_spelunker_search($query, $more=array()){

		$defaults = array(
			'host' => 'http://localhost',
			'port' => 9200,
			'index' => 'whosonfirst'
		);

		$more = array_merge($defaults, $more);

		# echo json_encode($query, JSON_PRETTY_PRINT);

		$rsp = elasticsearch_search($query, $more);
		return $rsp;
	}

	########################################################################

	# the end
