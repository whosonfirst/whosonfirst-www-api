<?php

	loadlib("whosonfirst_places");
	loadlib("whosonfirst_spatial");

	loadlib("api_whosonfirst_output");
	loadlib("api_whosonfirst_utils");

	loadlib("geo_utils");

	########################################################################

	function api_whosonfirst_places_search(){

		$q = request_str("q");

		$filters = api_whosonfirst_utils_search_filters();

		if (($q == "") && (count($filters) <= 1)){
			api_output_error(400, "E_INSUFFICIENT_QUERY");
		}

		$args = array();
		api_utils_ensure_pagination_args($args);

		$rsp = whosonfirst_places_search($q, $filters, $args);

		if (! $rsp['ok']){
			api_output_error(500, $rsp['error']);
		}

		$more = array();

		if ($extras = request_str("extras")){
			$more["extras"] = $extras;
		}

		api_whosonfirst_output_enpublicify($rsp['rows'], $more);
		$pagination = $rsp['pagination'];

		$out = array(
			'results' => $rsp['rows']
		);

		api_utils_ensure_pagination_results($out, $pagination);
		api_output_ok($out);
	}

	########################################################################

	function api_whosonfirst_places_getInfo(){

		# please write me
	}

	########################################################################

	function api_whosonfirst_places_getNearby(){

		$lat = null;
		$lon = null;

		if ($wofid = request_int64("id")){
		
			api_output_error(400, "This has not been implemented yet");
		}

		else {

			$lat = request_float("latitude");

			if (! $lat){
				api_output_error(400, "Missing latitude");
			}

			if (! geo_utils_is_valid_latitude($lat)){
				api_output_error(400, "Invalid latitude");
			}

			$lon = request_float("longitude");

			if (! $lon){
				api_output_error(400, "Missing longitude");
			}

			if (! geo_utils_is_valid_longitude($lon)){
				api_output_error(400, "Invalid longitude");
			}
		}

		$r = 100;

		$more = array(
			'wof:placetype_id' => 102312325,	# venues
		);

		$rsp = whosponfirst_spatial_nearby_latlon($lat, $lon, $r, $more);

		api_output_ok($rsp);
	}

	########################################################################

	function api_whosonfirst_places_getDescendants(){

		$wofid = request_int64("id");

		if (! $wofid){
			api_output_error(400, "Missing 'id' parameter");
		}

		$filters = api_whosonfirst_utils_search_filters();
		$args = array();

		api_utils_ensure_pagination_args($args);

		$rsp = whosonfirst_places_get_descendants($wofid, $filters, $args);

		if (! $rsp['ok']){
			api_output_error(500, $rsp['error']);
		}

		$more = array();

		if ($extras = request_str("extras")){
			$more["extras"] = $extras;
		}

		api_whosonfirst_output_enpublicify($rsp['rows'], $more);
		$pagination = $rsp['pagination'];

		$out = array(
			'results' => $rsp['rows']
		);

		api_utils_ensure_pagination_results($out, $pagination);
		api_output_ok($out);	
	}

	########################################################################

	# the end