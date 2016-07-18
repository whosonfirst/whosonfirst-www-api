<?php

	loadlib("elasticsearch");
	loadlib("elasticsearch_spelunker");

	loadlib("whosonfirst_sources");

	########################################################################

	function api_whosonfirst_concordances_getById(){

		$id = request_str("id");

		if (! $id){
			api_output_error(400, "Missing 'id' parameter");
		}

		$source = request_str("source");

		if (! $source){
			api_output_error(400, "Missing 'source' parameter");
		}

		# TO DO - ensure valid source here 

		$esc_id = elasticsearch_escape($id);

		$concordance = "wof:concordances.{$source}";

		$query = array(
			'match' => array( $concordance => $esc_id )
		);

		$req = array(
			'query' => $query,
		);

		$args = array();
		api_utils_ensure_pagination_args($args);

		$rsp = elasticsearch_spelunker_search($req, $args);

		if (! $rsp['ok']){
			api_output_error(500, $rsp['error']);
		}

		$results = array();

		foreach ($rsp['rows'] as $row){

			$concordances = $row['wof:concordances'];
			$concordances['wof:id'] = $row['wof:id'];

			$results[] = $concordances;
		}

		$rows = $rsp['rows'];
		$pagination = $rsp['pagination'];

		$out = array(
			'results' => $results,
		);

		api_utils_ensure_pagination_results($out, $pagination);
		api_output_ok($out);
	}

	########################################################################
	
	# the end