<?php

	########################################################################
	
	function api_whosonfirst_pelias_search(){

		$q = request_get("text");

		if (! $q){
			api_output_error(400);
		}

		$filters = array();
		
		$args = array();
		api_utils_ensure_pagination_args($args);

		$rsp = whosonfirst_places_search($q, $filters, $args);

		if (! $rsp['ok']){
			api_output_error(513);
		}

		api_whosonfirst_output_enpublicify($rsp['rows'], $more);
		$pagination = $rsp['pagination'];

		$out = array(
			'features' => $rsp['rows'],
		);

		api_utils_ensure_pagination_results($out, $pagination);

		$more = array(
			'key' => 'places',
		);

		api_output_ok($out, $more);
	}

	########################################################################

	# the end
