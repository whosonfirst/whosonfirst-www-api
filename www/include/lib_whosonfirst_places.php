<?php

	loadlib("elasticsearch");
	loadlib("elasticsearch_spelunker");

	########################################################################

	function whosonfirst_places_get_by_id($id, $more=array()){

		$query = array('ids' => array(
			'values' => array($id)
		));

		$req = array(
			'query' => $query
		);

		$rsp = elasticsearch_spelunker_search($req, $more);

		if (! $rsp['ok']){
			return null;
		}

		return $rsp['rows'][0];
	}

	########################################################################

	function whosonfirst_places_get_by_id_multi($ids, $more=array()){

		return elasticsearch_spelunker_mget($ids, $more);
	}

	########################################################################

	function whosonfirst_places_get_random($more=array()){

		$seed = rand(0, time());

		$empty = new stdClass;		# I hate you, PHP...

		$query = array(
			'function_score' => array(
				'query' => array(
					'match_all' => $empty
				),
				'functions' => array(
					array('random_score' => array('seed' => $seed))
				)
			)
		);

		$req = array(
			'query' => $query
		);

		$more['per_page'] = 1;

		$rsp = elasticsearch_spelunker_search($req, $more);
		return $rsp;
	}

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

		$sort = array(
			array('wof:id' =>  array('mode' => 'max', 'order' => 'asc')),
		);

		$req = array(
			'query' => $query,
			'sort' => $sort,
		);

		$rsp = elasticsearch_spelunker_search($req, $more);
		# $rsp['query'] = $query;

		return $rsp;
	}

	########################################################################

	# the end