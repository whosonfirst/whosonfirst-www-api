<?php

	loadlib("elasticsearch");
	loadlib("elasticsearch_spelunker");

	########################################################################

	function whosonfirst_places_get_descendants($wofid, $filters, $more=array()){

		$esc_id = elasticsearch_escape($wofid);

		$query = array('term' => array(
			'wof:belongsto' => $esc_id
		));

		# something something something filters

		$req = array(
			'query' => $query
		);

		$rsp = elasticsearch_spelunker_search($req, $more);
		return $rsp;
	}

	########################################################################

	# the end