<?php

	loadlib("elasticsearch");
	loadlib("elasticsearch_spelunker");

	########################################################################

	function whosonfirst_concordances_get_by_id($source, $id, $more=array()){

		$esc_id = elasticsearch_escape($id);

		$concordance = "wof:concordances.{$source}";

		if ($source == "wof"){
			$concordance = "wof:id";
		}

		$query = array(
			'match' => array( $concordance => $esc_id )
		);

		$req = array(
			'query' => $query,
		);

		$rsp = elasticsearch_spelunker_search($req, $more);

		if (! $rsp['ok']){
			return $rsp;
		}

		$results = array();

		foreach ($rsp['rows'] as $row){

			$concordances = $row['wof:concordances'];
			$concordances['wof:id'] = $row['wof:id'];

			$results[] = $concordances;
		}

		$pagination = $rsp['pagination'];

		return array(
			'ok' => 1,
			'rows' => $results,
			'pagination' => $pagination
		);
	}

	########################################################################

	# the end