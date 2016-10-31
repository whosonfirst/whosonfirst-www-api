<?php

	loadlib("elasticsearch");
	loadlib("elasticsearch_spelunker");

	loadlib("whosonfirst_places");

	########################################################################

	function whosonfirst_concordances_get_sources($args=array()){

		elasticsearch_spelunker_append_config($args);
		$rsp = elasticsearch_facet("wof:concordances_sources", $args);

		if ($rsp['ok']){

			$sources = array();

			foreach ($rsp['rows'] as $row){
				$sources[] = array('source' => $row['key'], 'concordances' => $row['doc_count']);
			}

			$rsp['rows'] = $sources;
		}

		return $rsp;
	}

	########################################################################

	function whosonfirst_concordances_get_by_id($source, $id, $more=array()){

		$esc_id = elasticsearch_escape($id);

		$concordance = "wof:concordances.{$source}";

		if ($source == "wof"){
			$concordance = "wof:id";
		}

		if ($concordance == "wof:concordances.wof:id"){

			$place = whosonfirst_places_get_by_id($id);

			if (! $place){
				return array('ok' => 0, 'error' => 'Invalid wof:id');
			}

			$concordances = $place['wof:concordances'];

			$results = array();

			$pagination = array(
				'total_count' => 0,
				'page' => 1,
				'per_page' => 1,
				'page_count' => 1
			);

			if ($concordances){
				$results[] = $concordances;
				$pagination['total_count'] = 1;
			}

			return array(
				'ok' => 1,
				'rows' => $results,
				'pagination' => $pagination
			);			
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