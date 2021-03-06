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

		$flags_more = array(
			"prefix" => null,
		);

		$flags = api_whosonfirst_ensure_existential_flags($flags_more);

		$placetypes = whosonfirst_placetypes_ancestors($pt);
		array_unshift($placetypes, $pt);

		$possible = array();

		foreach ($placetypes as $pt){

			$more = array("placetype" => $pt);
			$more = array_merge($more, $flags);

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

			$row = whosonfirst_places_get_by_id($pip_row["wof:id"]);

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

		# but only when people are asking for things to be
		# returned as CSV files because this:
		# https://github.com/whosonfirst/whosonfirst-www-api/issues/49
		# (20170622/thisisaaronland)

		$format = request_str("format");

		if (($format == "csv") && (count($results) > 1)){

			foreach ($results as &$r){

				foreach ($keys as $k){

					if (! isset($r[$k])){
						$r[$k] = "";
					}
				}
			}
		}

		if (request_str("spr")){

			$lookup = array();
			$ids = array();

			foreach ($results as $hier){

				foreach ($hier as $pt => $id){

					$ids[] = $id;
				}
			}

			$places = whosonfirst_places_get_by_id_multi($ids);

			if (! $places){
				api_output_error(514);
			}

			$more = array();

			if ($extras = api_whosonfirst_utils_get_extras()){
				$more["extras"] = $extras;
			}

			api_whosonfirst_output_enpublicify($places['rows'], $more);

			if (is_array($places['rows'])){

				foreach ($places['rows'] as $row){
					$lookup[$row['wof:id']] = $row;
				}
			}

			$results_spr = array();

			foreach ($results as $hier){

				$hier_spr = array();

				foreach ($hier as $pt => $id){

					if (isset($lookup[$id])){				
						$row = $lookup[$id];
						$hier_spr[$row['wof:placetype']] = $row;
					}

					else {
						$pt = str_replace("_id", "", $pt);
						$hier_spr[$pt] = null;	# https://github.com/whosonfirst/whosonfirst-www-api/issues/54
					}
				}

				$results_spr[] = $hier_spr;
			}

			$results = $results_spr;
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

	function api_whosonfirst_places_getByPolyline($method_row){

		api_utils_features_ensure_enabled(array(
			"pip",
			"pip_polyline"
		));

		$polyline = request_str("polyline");
		
		if (! $polyline){
			api_output_error(432);
		}

		$args = array();

		if ($p = request_int32("precision")){

			if (! in_array($p, array(5, 6))){
				api_output_error(433);
			}

			$args["precision"] = $p;
		}

		if (request_int32("unique")){
			$args["unique"] = 1;
		}

		if ($placetype = request_str("placetype")){
			api_whosonfirst_places_ensure_valid_placetype($placetype);
			$args["placetype"] = $placetype;
		}

		$flags_more = array(
			"prefix" => null,
		);

		$flags = api_whosonfirst_ensure_existential_flags($flags_more);
		$args = array_merge($args, $flags);

		api_utils_ensure_pagination_args($args, $method_row);

		$rsp = whosonfirst_pip_get_by_polyline($polyline, $args);

		if (! $rsp["ok"]){
			api_output_error(513);
		}

		$more = array();

		if ($extras = api_whosonfirst_utils_get_extras()){
			$more["extras"] = $extras;
		}

		$results = array();

		foreach ($rsp["rows"] as $step){

			$places = array();

			foreach ($step as $pip_row){

				$row = whosonfirst_places_get_by_id($pip_row["wof:id"]);

				$public = api_whosonfirst_output_enpublicify_single($row, $more);
				$places[] = $public;
			}

			$results[] = $places;
		}

		$pagination = $rsp["pagination"];

		$out = array(
			"places" => $results,
		);

		# see notes in method spec in config_api_methods_whosonfirst.php
		# (20171101/thisisaaronland)

		if ($args["unique"]){
			$pagination["total_count"] = null;
		}

		api_utils_ensure_pagination_results($out, $pagination);

		$more = array(
			'key' => 'places',
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

		$flags_more = array(
			"prefix" => null,
		);

		$flags = api_whosonfirst_ensure_existential_flags($flags_more);
		$more = array_merge($more, $flags);

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

			$row = whosonfirst_places_get_by_id($pip_row["wof:id"]);

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

	# regions that intersect burkina faso that are superseded
	# ?method=whosonfirst.places.getIntersects&min_latitude=9.393889&min_longitude=-5.521112&max_latitude=15.085111&max_longitude=2.404293&placetype=region&is_superseded=1&extras=edtf:,wof:superseded,wof:superseded_by

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
			$more['wof:placetype_id'] = whosonfirst_placetypes_name_to_id($placetype);
		}

		$flags = api_whosonfirst_ensure_existential_flags();
		$more = array_merge($more, $flags);

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

		if ($GLOBALS['cfg']['environment'] == 'dev'){
			$out['_query'] = $rsp['command'];
		}

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

			if (($r < 0) || ($r > $GLOBALS['cfg']['spatial_nearby_max_radius'])){
				api_output_error(436);
			}
		}

		else {
			$r = $GLOBALS['cfg']['spatial_nearby_default_radius'];
		}

		$more = array();

		if ($placetype = request_str("placetype")){

			api_whosonfirst_places_ensure_valid_placetype($placetype);
			$more['wof:placetype_id'] = whosonfirst_placetypes_name_to_id($placetype);
		}

		$flags = api_whosonfirst_ensure_existential_flags();
		$more = array_merge($more, $flags);

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

		if ($GLOBALS['cfg']['environment'] == 'dev'){
			$out['_query'] = $rsp['command'];
		}

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
	
	function api_whosonfirst_ensure_existential_flags($more=array()){

		$defaults = array(
			"prefix" => "mz",
		);

		$more = array_merge($defaults, $more);

		$flags = array();

		$existential = array(
			"is_current",
			"is_deprecated",
			"is_ceased",
			"is_superseded",
			"is_superseding",
		);

		foreach ($existential as $k){

			if (! request_isset($k)){
				continue;
			}

			$v = request_str($k);

			if ($k == "is_current"){

				if (! in_array($v, array("-1", "0", "1"))){
					api_output_error(400);
				}
			}

			else {

				if (! in_array($v, array("0", "1"))){
					api_output_error(400);
				}
			}

			$fq_k = $k;

			if ($more["prefix"]){
				$fq_k = $more["prefix"] . ":" . $k;
			}
			
			$flags[ $fq_k ] = $v;
		}

		return $flags;
	}

	########################################################################

	# the end
