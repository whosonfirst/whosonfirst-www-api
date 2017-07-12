<?php

	loadlib("whosonfirst_places");
	loadlib("api_whosonfirst_output");
	loadlib("api_whosonfirst_placetypes");	
	loadlib("api_whosonfirst_utils");
	loadlib("geo_utils");

	# https://mapzen.com/documentation/mapzen-js/search/
	# https://mapzen.com/documentation/search/search/#available-search-parameters
	# https://mapzen.com/documentation/search/response/

	########################################################################

	function api_whosonfirst_pelias_autocomplete(){

		api_whosonfirst_pelias_ensure_format();

		if (request_isset("version")){

			if (request_str("version") != "v1"){
				api_output_error(441);
			}
		}

		# TO DO: support focus.point.lat and focus.point.lon

		$text = request_str("text");

		$query = array("match" => array(
			"names_autocomplete" => $text
		));

		# okay set up search filters
		
		$filters = api_whosonfirst_pelias_ensure_filters();


		$req = array(
			"query" => $query,
		);

		$more = array();

		$rsp = elasticsearch_spelunker_search($req, $more);

		if (! $rsp["ok"]){
			api_output_error(513);
		}

		$extras = api_whosonfirst_utils_get_extras();
		
		$more = array(
			"extras" => $extras,
		);
		
		api_whosonfirst_output_enpublicify($rsp['rows'], $more);
		$pagination = $rsp['pagination'];

		$out = array(
			"places" => $rsp['rows'],
		);

		$pelias_query = array(
			"text" => request_str("q"),
		);

		$more = array(
			"query" => $pelias_query,
			"geocoding" => 1,
			"key" => "places",
		);

		api_output_ok($out, $more);
	}

	########################################################################

	function api_whosonfirst_pelias_search(){

		api_whosonfirst_pelias_ensure_format();

		if (request_isset("version")){

			if (request_str("version") != "v1"){
				api_output_error(441);
			}
		}

		# first make sure there is a query
		
		$text = request_str("text");

		$query_field = "q";

		if ($qf = request_str("query_field")){

			if (! in_array($qf, array("q", "alt", "name", "names", "preferred", "variant"))){
				api_output_error(442);
			}

			$query_field = $qf;
		}

		$_REQUEST[ $query_field ] = $text;
		$q = request_str("q");

		if ((! trim($text)) && (! trim($q))){
			api_output_error(453);
		}
		
		# okay set up search filters
		
		$filters = api_whosonfirst_pelias_ensure_filters();

		$args = array();
		api_utils_ensure_pagination_args($args);
		
		$rsp = whosonfirst_places_search($q, $filters, $args);

		if (! $rsp['ok']){
			api_output_error(513);
		}

		$extras = api_whosonfirst_utils_get_extras();
		
		$more = array(
			"extras" => $extras,
		);
		
		api_whosonfirst_output_enpublicify($rsp['rows'], $more);
		$pagination = $rsp['pagination'];

		$out = array(
			"places" => $rsp['rows'],
		);

		api_utils_ensure_pagination_results($out, $pagination);

		$query_map = array(
			$query_field => "text",
			"per_page" => "size",
			"iso" => "boundary.country",
			"placetype" => "layers",
			"min_latitude" => "boundary.rect.min_lat",
			"min_longitude" => "boundary.rect.min_lon",
			"max_latitude" => "boundary.rect.max_lat",
			"max_longitude" => "boundary.rect.max_lon",
		);

		$pelias_query = array(

			"lang" => array(
				"name" => "English",
				"iso6391" => "en",
				"iso6392" => "eng",
			),
		);

		foreach ($query_map as $wof_k => $pelias_k){

			if (! request_isset($wof_k)){
				continue;
			}

			$v = request_str($wof_k);

			if ($pelias_k == "layers"){
				$v = array($v);
			}

			$pelias_query[$pelias_k] = $v;
		}

		$is_pelias_query = false;

		foreach ($query_map as $ignore => $pelias_k){

			if (request_isset($pelias_k)){
				$is_pelias_query = true;
				break;
			}
		}

		if ($is_pelias_query){
		
			$next_query = $pelias_query;
			
			if ($c = $out["cursor"]){

				$next_query["cursor"] = $c;
				$out["next_query"] = http_build_query($next_query);

			} else {

				if ($out["page"] < $out["pages"]){

					$next_query["page"] = $out["page"] + 1;
					$out["next_query"] = http_build_query($next_query);
				}
			}
		}

		$more = array(
			"geocoding" => 1,
			"query" => $pelias_query,
			"key" => "places",
		);

		api_output_ok($out, $more);
	}

	########################################################################

	function api_whosonfirst_pelias_ensure_filters(){

		# https://github.com/whosonfirst/whosonfirst-www-api/issues/33		
		# https://github.com/whosonfirst/whosonfirst-www-api/issues/34

		$unsupported = array(
			"boundary.circle.lat",
			"boundary.circle.lon",
			"boundary.circle.radius",
			"boundary.rect.min_lat",
			"boundary.rect.min_lon",
			"boundary.rect.max_lat",
			"boundary.rect.max_lon",
			"focus.point.lat",
			"focus.point.lon",
			"sources",
		);

		foreach ($unsupported as $param){

			if (get_isset($param)){
				api_output_error(432);
			}
		}

		# okay see what else there is to process and convert
		# it from a pelias query to a wof query
		
		if ($sz = get_int64("size")){
			$_REQUEST["per_page"] = $sz;
		}

		if ($iso = get_str("boundary.country")){
			$_REQUEST["iso"] = iso;
		}

		if ($pt = get_str("layers")){

			$pt = explode(",", $pt);

			if (count($pt) > 1){
				api_output_error(433);
			}

			if (! whosonfirst_placetypes_is_valid_placetype($pt[0])){
				api_output_error(434);
			}
			
			$_REQUEST["placetype"] = $pt[0];
		}

		# see above (inre: bbox queries)

		if ($min_lat = get_float("boundary.rect.min_lat")){
			$_REQUEST["min_latitude"] = $min_lat;
		}

		if ($min_lon = get_float("boundary.rect.min_lon")){
			$_REQUEST["min_longitude"] = $min_lon;
		}

		if ($max_lat = get_float("boundary.rect.max_lat")){
			$_REQUEST["max_latitude"] = $max_lat;
		}

		if ($max_lon = get_float("boundary.rect.max_lon")){
			$_REQUEST["max_longitude"] = $max_lon;
		}

		# validate bounding box query here...

		$bbox = array();
		
		$swlat = request_float("min_latitude");
		$swlat = trim($swlat);

		if ($swlat){

			if (! geo_utils_is_valid_latitude($swlat)){
				api_output_error(435);
			}

			$bbox[] = $swlat;
		}

		$swlon = request_float("min_longitude");
		$swlon = trim($swlon);

		if ($swlon){

			if (! geo_utils_is_valid_longitude($swlon)){
				api_output_error(436);
			}

			$bbox[] = $swlon;
		}
		
		$nelat = request_float("max_latitude");
		$nelat = trim($nelat);

		if ($nelat){

			if (! geo_utils_is_valid_latitude($nelat)){
				api_output_error(437);
			}

			$bbox[] = $nelat;
		}
		
		$nelon = request_float("max_longitude");
		$nelon = trim($nelon);

		if ($nelon){

			if (! geo_utils_is_valid_longitude($nelon)){
				api_output_error(438);
			}

			$bbox[] = $nelon;
		}

		if ($count_bbox = count($bbox)){

			if ($count_bbox != 4){
				api_output_error(439);
			}
		}

		$filters = api_whosonfirst_utils_search_filters();
		return $filters;
	}

	########################################################################

	function api_whosonfirst_pelias_ensure_format(){

		$allowed = array(
			"chicken",
			"geojson"
		);

		if (request_isset("format")){

			$fmt = request_str("format");

			if (! in_array($fmt, $allowed)){
				api_output_error(440);
			}
		}

	}

	########################################################################

	# the end
