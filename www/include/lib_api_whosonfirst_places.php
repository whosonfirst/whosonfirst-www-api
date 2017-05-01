<?php

	loadlib("whosonfirst_placetypes");
	
	loadlib("whosonfirst_places");
	loadlib("whosonfirst_spatial");
	loadlib("whosonfirst_pip");

	loadlib("api_whosonfirst_output");
	loadlib("api_whosonfirst_utils");

	loadlib("geo_utils");

	########################################################################

	function api_whosonfirst_places_search(){

		$q = request_str("q");

		$filters = api_whosonfirst_utils_search_filters();

		if (($q == "") && (count($filters) <= 1)){
			api_output_error(452);
		}

		$args = array();
		api_utils_ensure_pagination_args($args);

		$rsp = whosonfirst_places_search($q, $filters, $args);

		if (! $rsp['ok']){
			error_log("[SEARCH]" . var_export($rsp, 1));
			api_output_error(513);
		}

		$more = array();

		if ($extras = api_whosonfirst_utils_get_extras()){
			$more["extras"] = $extras;
		}

		api_whosonfirst_output_enpublicify($rsp['rows'], $more);
		$pagination = $rsp['pagination'];

		$out = array(
			'places' => $rsp['rows'],
		);

		if ($GLOBALS['cfg']['environment'] == 'dev'){
			$out['_query'] = $rsp['_query'];
		}

		api_utils_ensure_pagination_results($out, $pagination);

		$more = array(
			'key' => 'places',
		);

		api_output_ok($out, $more);
	}

	########################################################################

	function api_whosonfirst_places_getHierarchiesByLatLon(){

		api_utils_features_ensure_enabled(array(
			"pip"
		));

		$lat = request_float("latitude");
		$lon = request_float("longitude");
		$pt = request_str("placetype");

		if (! $lat){
			api_output_error(432);
		}

		if (! $lon){
			api_output_error(433);
		}

		if (! geo_utils_is_valid_latitude($lat)){
			api_output_error(434);
		}

		if (! geo_utils_is_valid_longitude($lon)){
			api_output_error(435);
		}

		if (! $pt){
			$pt = "microhood";
		}

		if (! whosonfirst_placetypes_is_valid_placetype($pt)){
			api_output_error(436);
		}

		$placetypes = whosonfirst_placetypes_ancestors($pt);
		array_unshift($placetypes, $pt);

		$possible = array();

		foreach ($placetypes as $pt){

			$more = array("placetype" => $pt);
			$rsp = whosonfirst_pip_get_by_latlon($lat, $lon, $more);

			if (! $rsp["ok"]){
				api_output_error(513);
			}

			if (count($rsp["rows"])){
				$possible = $rsp["rows"];			   	
				break;
			} 
		}

		$results = array();
		$keys = array();

		foreach ($possible as $pip_row) {

			$row = whosonfirst_places_get_by_id($pip_row["Id"]);

			foreach ($row["wof:hierarchy"] as $hier){

				# see below for why we're doing this
				
				foreach (array_keys($hier) as $k){

					if (! in_array($k, $keys)){
						$keys[] = $k;
					}
				}

				$results[] = $hier;
			}
		}

		# this is mostly to make sure that columns line up
		# if someone is asking for stuff formatted as CSV
		# (20170228/thisisaaronland)

		if (count($results) > 1){

			foreach ($results as &$r){

				foreach ($keys as $k){

					if (! isset($r[$k])){
						$r[$k] = "";
					}
				}
			}
		}

		$out = array(
			"hierarchies" => $results
		);

		$more = array(
			'key' => 'hierarchies',
		);

		api_output_ok($out, $more);
	}

	########################################################################

	function api_whosonfirst_places_getParentByLatlon(){

		api_utils_features_ensure_enabled(array(
			"pip"
		));

		$lat = request_float("latitude");
		$lon = request_float("longitude");
		$pt = request_str("placetype");

		if (! $lat){
			api_output_error(432);
		}

		if (! $lon){
			api_output_error(433);
		}

		if (! geo_utils_is_valid_latitude($lat)){
			api_output_error(434);
		}

		if (! geo_utils_is_valid_longitude($lon)){
			api_output_error(435);
		}
		
		if (! $pt){
			api_output_error(436);
		}

		if (! whosonfirst_placetypes_is_valid_placetype($pt)){
			api_output_error(437);
		}

		$more = array();
		$more["placetype"] = $pt;

		$ancestors = whosonfirst_placetypes_ancestors($pt);
		$possible = array();

		$last_parent = null;

		foreach ($ancestors as $a){

			$last_parent = $a;

			$more = array("placetype" => $a);
			$rsp = whosonfirst_pip_get_by_latlon($lat, $lon, $more);

			if (! $rsp["ok"]){
				api_output_error(513);
			}

			if (count($rsp["rows"])){
				$possible = $rsp["rows"];			   	
				break;
			} 
		}

		$count = count($possible);

		if ($count == 0){
			$parent_id = -1;
		}

		else if ($count == 1){
			$first = $possible[0];
			$parent_id = $first["Id"];
		}

		else if ($last_parent == "neighbourhood"){
			$parent_id = -3;
		}

		else {}

		# maybe return a record... not sure how best to do
		# that if the parent_id is -1, -3, etc.
		# (20170301/thisisaaronland)

		$out = array('place' => array(
			'wof:parent_id' => $parent_id
		));

		$more = array(
			'is_singleton' => 1,
			'key' => 'place',
		);

		api_output_ok($out, $more);
	}

	########################################################################

	function api_whosonfirst_places_getByLatLon(){

		api_utils_features_ensure_enabled(array(
			"pip"
		));

		$lat = request_float("latitude");
		$lon = request_float("longitude");
		$pt = request_str("placetype");

		if (! $lat){
			api_output_error(432);
		}

		if (! $lon){
			api_output_error(433);
		}

		if (! geo_utils_is_valid_latitude($lat)){
			api_output_error(434);
		}

		if (! geo_utils_is_valid_longitude($lon)){
			api_output_error(435);
		}
		
		$more = array();
		
		if ($pt){

			if (! whosonfirst_placetypes_is_valid_placetype($pt)){
				api_output_error(436);
			}

			$more["placetype"] = $pt;
		}

		$rsp = whosonfirst_pip_get_by_latlon($lat, $lon, $more);

		if (! $rsp["ok"]){
			api_output_error(513);
		}

		$more = array();

		if ($extras = api_whosonfirst_utils_get_extras()){
			$more["extras"] = $extras;
		}

		$results = array();

		foreach ($rsp["rows"] as $pip_row){
			
			$row = whosonfirst_places_get_by_id($pip_row["Id"]);
			$public = api_whosonfirst_output_enpublicify_single($row, $more);

			$results[] = $public;
		}

		$out = array(
			"places" => $results,
		);

		$more = array(
			'key' => 'places',
		);

		api_output_ok($out, $more);
	}

	########################################################################

	function api_whosonfirst_places_getInfo(){

		$id = request_int64("id");

		if (! $id){
			api_output_error(432);
		}

		$place = whosonfirst_places_get_by_id($id);

		if (! $place){
			api_output_error(513);
		}

		$more = array();

		if ($extras = api_whosonfirst_utils_get_extras()){
			$more["extras"] = $extras;
		}

		$public = api_whosonfirst_output_enpublicify_single($place, $more);

		$out = array(
			'place' => $public 
		);

		$more = array(
			'key' => 'place',
			'is_singleton' => 1
		);

		api_output_ok($out, $more);
	}

	########################################################################

	function api_whosonfirst_places_getInfoMulti(){

		$str_ids = request_str("ids");

		if (! $str_ids){
			api_output_error(432);
		}

		$ids = array();

		foreach (explode(",", $str_ids) as $id){

			if ($id = intval($id)){
				$ids[] = $id;
			}
		}

		if (count($ids) == 0){
			api_output_error(432);
		}

		if (count($ids) > 20){
			api_output_error(433);
		}

		$places = whosonfirst_places_get_by_id_multi($ids);

		if (! $places){
			api_output_error(513);
		}

		$more = array();

		if ($extras = api_whosonfirst_utils_get_extras()){
			$more["extras"] = $extras;
		}

		api_whosonfirst_output_enpublicify($places['rows'], $more);

		$out = array(
			'places' => $places['rows'] 
		);

		$more = array(
			'key' => 'places',
		);

		api_output_ok($out, $more);
	}

	########################################################################

	function api_whosonfirst_places_getIntersects(){

		api_utils_features_ensure_enabled(array(
			"spatial", "spatial_intersects"
		));

		$swlat = null;
		$swlon = null;

		$nelat = null;
		$nelon = null;

		if ($wofid = request_int64("id")){		
			api_output_error(501);
		}

		else {

			$swlat = request_float("min_latitude");
			$swlat = trim($swlat);

			if (! $swlat){
				api_output_error(432);
			}

			if (! geo_utils_is_valid_latitude($swlat)){
				api_output_error(436);
			}

			$swlon = request_float("min_longitude");
			$swlon = trim($swlon);

			if (! $swlon){
				api_output_error(433);
			}

			if (! geo_utils_is_valid_longitude($swlon)){
				api_output_error(437);
			}
			
			$nelat = request_float("max_latitude");
			$nelat = trim($nelat);

			if (! $nelat){
				api_output_error(434);
			}

			if (! geo_utils_is_valid_latitude($nelat)){
				api_output_error(438);
			}

			$nelon = request_float("max_longitude");
			$nelon = trim($nelon);

			if (! $nelon){
				api_output_error(435);
			}

			if (! geo_utils_is_valid_longitude($nelon)){
				api_output_error(439);
			}

			if ($swlat > $nelat){
				api_output_error(436);
			}

			if ($swlon > $nelon){
				api_output_error(437);
			}
		}

		$more = array();

		if ($cursor = request_str("cursor")){

			api_whosonfirst_places_ensure_valid_cursor($cursor);
			$more['cursor'] = $cursor;
		}

		if ($placetype = request_str("placetype")){

			api_whosonfirst_places_ensure_valid_placetype($placetype);
			$more['placetype_id'] = whosonfirst_placetypes_name_to_id($placetype);
		}

		if ($extras = api_whosonfirst_utils_get_extras()){
			$more["extras"] = $extras;
		}

		api_utils_ensure_pagination_args($more);

		$rsp = whosonfirst_spatial_intersects($swlat, $swlon, $nelat, $nelon, $more);

		if (! $rsp['ok']){
			api_output_error(513);
		}

		$results = whosonfirst_spatial_inflate_results($rsp);

		$pagination = $rsp['pagination'];

		$more['is_tile38'] = 1;	# because this: https://github.com/whosonfirst/whosonfirst-www-api/issues/8
		api_whosonfirst_output_enpublicify($results, $more);

		$out = array(
			'places' => $results
		);

		api_utils_ensure_pagination_results($out, $pagination);

		$more = array(
			'key' => 'places',
		);

		api_output_ok($out, $more);
	}

	########################################################################

	function api_whosonfirst_places_getNearby(){

		api_utils_features_ensure_enabled(array(
			"spatial", "spatial_nearby"
		));

		$lat = null;
		$lon = null;

		if ($wofid = request_int64("id")){		
			api_output_error(501);
		}

		else {

			$lat = request_float("latitude");

			if (! $lat){
				api_output_error(432);
			}

			if (! geo_utils_is_valid_latitude($lat)){
				api_output_error(434);
			}

			$lon = request_float("longitude");

			if (! $lon){
				api_output_error(433);
			}

			if (! geo_utils_is_valid_longitude($lon)){
				api_output_error(435);
			}
		}

		if ($r = request_int32("radius")){

			if (($r < 0) || ($r > 500)){
				api_output_error(436);
			}
		}

		else {
			$r = 100;
		}

		$more = array();

		if ($placetype = request_str("placetype")){

			api_whosonfirst_places_ensure_valid_placetype($placetype);
			$more['wof:placetype_id'] = whosonfirst_placetypes_name_to_id($placetype);
		}
		
		if ($cursor = request_str("cursor")){

			api_whosonfirst_places_ensure_valid_cursor($cursor, array("error_code" => 437));
			$more['cursor'] = $cursor;
		}

		if ($extras = api_whosonfirst_utils_get_extras()){
			$more["extras"] = $extras;
		}

		api_utils_ensure_pagination_args($more);

		$rsp = whosonfirst_spatial_nearby_latlon($lat, $lon, $r, $more);

		if (! $rsp['ok']){
			api_output_error(513);
		}

		$results = whosonfirst_spatial_inflate_results($rsp);

		$pagination = $rsp['pagination'];

		$more['is_tile38'] = 1;	# because this: https://github.com/whosonfirst/whosonfirst-www-api/issues/8
		api_whosonfirst_output_enpublicify($results, $more);

		$out = array(
			'places' => $results
		);

		api_utils_ensure_pagination_results($out, $pagination);

		$more = array(
			'key' => 'places',
		);

		api_output_ok($out, $more);
	}

	########################################################################

	function api_whosonfirst_places_getRandom(){

		$rsp = whosonfirst_places_get_random();

		if (! $rsp['ok']){
			api_output_error(513);
		}

		$more = array();

		if ($extras = api_whosonfirst_utils_get_extras()){
			$more["extras"] = $extras;
		}

		$doc = $rsp['rows'][0];
		$doc = api_whosonfirst_output_enpublicify_single($doc, $more);

		$out = array(
			'place' => $doc		     
		);

		$more = array(
			'key' => 'place',
			'is_singleton' => 1
		);

		api_output_ok($out, $more);
	}
	
	########################################################################

	function api_whosonfirst_places_getDescendants(){

		$wofid = request_int64("id");

		if (! $wofid){
			api_output_error(432);
		}

		$filters = api_whosonfirst_utils_search_filters();
		$args = array();

		api_utils_ensure_pagination_args($args);

		$rsp = whosonfirst_places_get_descendants($wofid, $filters, $args);

		if (! $rsp['ok']){
			api_output_error(513);
		}

		$more = array();

		if ($extras = api_whosonfirst_utils_get_extras()){
			$more["extras"] = $extras;
		}

		api_whosonfirst_output_enpublicify($rsp['rows'], $more);
		$pagination = $rsp['pagination'];

		$out = array(
			'places' => $rsp['rows'],
		);

		if ($GLOBALS['cfg']['environment'] == 'dev'){
			$out['_query'] = $rsp['_query'];
		}

		api_utils_ensure_pagination_results($out, $pagination);

		$more = array(
			'key' => 'places',
		);

		api_output_ok($out, $more);	
	}

	########################################################################

	function api_whosonfirst_places_ensure_valid_placetype($pt, $more=array()){

		$defaults = array(
			"error_code" => 454
		);

		$more = array_merge($defaults, $more);

		if (! whosonfirst_placetypes_is_valid_placetype($pt)){

			api_output_error($more["error_code"]);
		}

		return 1;
	}

	########################################################################

	function api_whosonfirst_places_ensure_valid_cursor($cursor){

		if (! preg_match("/^[0-9]+$/", $cursor)){
			api_output_error(454, "Invalid cursor");
		}

		return 1;
	}
	
	########################################################################
	
	# the end
