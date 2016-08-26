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

		$id = request_int64("id");

		if (! $id){
			api_output_error(400, "Missing 'id' parameter");
		}

		$rsp = whosonfirst_places_get_by_id($id);

		if (! $rsp['ok']){
			api_output_error(500, "Failed to retrieve ID");
		}

		$more = array();

		if ($extras = request_str("extras")){
			$more["extras"] = $extras;
		}

		$doc = $rsp['rows'][0];
		$doc = api_whosonfirst_output_enpublicify_single($doc, $more);

		$out = array(
			'record' => $doc		     
		);

		api_output_ok($out);
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

		if ($r = request_int32("radius")){

			if (($r < 0) || ($r > 100)){
				api_output_error(400, "Invalid radius");
			}
		}

		else {
			$r = 100;
		}

		# IMPORTANT - WE AREN'T DEALING WITH TILE38 PAGINATION AT ALL YET BECAUSE TILE38
		# USES 'cursors' AND ... YEAH, CURSORS. WE WILL NEED TO FIGURE SOMETHING OUT BUT
		# NOT TODAY (20160811/thisisaaronland)

		$more = array(
			'wof:placetype_id' => 102312325,	# venues - PLEASE DO NOT HARDCODE ME
		);

		$rsp = whosonfirst_spatial_nearby_latlon($lat, $lon, $r, $more);

		if (! $rsp['ok']){
			api_output_error(500, $rsp['error']);
		}
		
		# See this? It takes ~ 20-40 µs to fetch each name individually.
		# Which isn't very much even when added up. There are two considerations
		# here: 1) It's useful just to be able to append the name from the 
		# tile38 index itself 2) It might be just as fast to look up the
		# entire record from ES itself. Basically what I am trying to say is
		# that it's too soon so we're just going to do this for now...
		# (20160811/thisisaaronland)

		whosonfirst_spatial_append_names($rsp);

		$results = array();

		# please put me in a function somewhere (20160811/thisisaaronland)

		$fields = $rsp['fields'];
		$count_fields = count($fields);

		foreach ($rsp['objects'] as $row){

			$geom = $row['object'];
			$coords = $geom['coordinates'];

			$props = array();

			for ($i=0; $i < $count_fields; $i++){
				$props[ $fields[$i] ] = $row['fields'][$i];
			}

			list($id, $repo) = explode("#", $row['id']);
			
			$results[] = array(
				'wof:name' => $props['wof:name'],
				'wof:id' => $props['wof:id'],
				'wof:placetype' => "venue",	# PLEASE DO NOT HARDCODE ME
				'wof:parent_id' => -1,		# PLEASE FIX ME
				'wof:country' => "XY",		# PLEASE FIX ME
				'wof:repo' => $repo,
				'geom:latitude' => $coords[1],
				'geom:longitude' => $coords[0],
			);
		}

		# end of please put me in a function somewhere

		$out = array('results' => $results);
		api_output_ok($out);
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