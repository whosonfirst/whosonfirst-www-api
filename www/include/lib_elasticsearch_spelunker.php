<?php

	loadlib("elasticsearch");

	########################################################################

	function elasticsearch_spelunker_search($query, $more=array()){

		$defaults = array(
			'host' => $GLOBALS['cfg']['elasticsearch_spelunker_host'],
			'port' => $GLOBALS['cfg']['elasticsearch_spelunker_port'],
			'index' => $GLOBALS['cfg']['elasticsearch_spelunker_index']
		);

		$more = array_merge($defaults, $more);

		$rsp = elasticsearch_search($query, $more);
		return $rsp;
	}

	########################################################################

	# the end
