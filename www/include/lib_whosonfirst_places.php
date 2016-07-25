<?php

	loadlib("elasticsearch");
	loadlib("elasticsearch_spelunker");

	########################################################################

	function whosonfirst_places_search($q, $filters, $more=array()){

		if ($q == ""){

			$esc_q = "*";

			$empty = new stdClass;
			$query = array('match_all' => $empty);
		}

		else {
			$esc_q = elasticsearch_escape($q);
		
			$query = array(
				'match' => array( '_all' => array(
					'operator' => 'and',
					'query' => $esc_q,
				))
			);
		}

		$filter_query = array('filtered' => array(
			'query' => $query,
			'filter' => array('and' => $filters),
		));

		$functions = array();

		if ($q != ""){

			$functions = array(
				array(
					'filter' => array('term' => array('names_preferred' => $esc_q)),
					'weight' => 3.0
				),
				array(
					'filter' => array('term' => array('names_alt' => $esc_q)),
					'weight' => 1.0
				),
				array(
					'filter' => array('term' => array('wof:name' => $esc_q)),
					'weight' => 1.5
				),
			);
		}

		$functions[] = array(
			'filter' => array('not' => array('term' => array('wof:placetype' => 'venue'))),
			'weight' => 2.0
		);

		$functions[] = 	array(
			'filter' => array('exists' => array('field' => 'wk:population')),
			'weight' => 1.25
		);

		$sort = array(
			array('geom:area' =>  array('mode' => 'max', 'order' => 'desc')),
			array('wof:scale' => array('mode' => 'max', 'order' => 'desc')),
			array('wof:megacity' => array('mode' => 'max', 'order' => 'desc')),
			array('gn:population' => array('mode' => 'max', 'order' => 'desc')),
		);

		$es_query = array('function_score' => array(
			'query' => $filter_query,
			'functions' => $functions,
			'boost_mode' => 'multiply',
			'score_mode' => 'multiply',
		));

		# dumper($filter_query);

		$req = array(
			'query' => $es_query,
			'sort' => $sort,
		);

		$rsp = elasticsearch_spelunker_search($req, $more);
		return $rsp;
	}

	########################################################################

	function whosonfirst_places_get_descendants($wofid, $filters, $more=array()){

		$esc_id = elasticsearch_escape($wofid);

		$query = array('term' => array(
			'wof:belongsto' => $esc_id
		));

		if (count(array_keys($filters))){

			$query = array('filtered' => array(
				'query' => $query,
				'filter' => array('and' => $filters),
			));
		}

		$req = array(
			'query' => $query
		);

		$rsp = elasticsearch_spelunker_search($req, $more);
		return $rsp;
	}

	########################################################################

	# the end