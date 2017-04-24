<?php

	########################################################################

	loadlib("http_codes");

	#################################################################

	function api_output_ok($rsp=array(), $more=array()){

		$defaults = array(
			"pelias_query" => array(),
		);

		$more = array_merge($defaults, $more);

		$features = array();

		# we assume that someone (or code) earlier up the stack
		# has assigned ?extras:geom:latitude,geom:longitude

		$swlat = null;
		$swlon = null;		
		$nelat = null;
		$nelon = null;		
		
		foreach ($rsp["places"] as $pl){

			$lat = $pl["geom:latitude"];
			$lon = $pl["geom:longitude"];			

			# update swlat/lon and nelat/lon here...
			
			unset($pl["geom:latitude"]);
			unset($pl["geom:longitude"]);
			
			$coords = array($lon, $lat);
			
			$geom = array(
				"type" => "Point",
				"coordinates" => $coords
			);

			$feature = array(
				"type" => "Feature",
				"geometry" => $geom,
				"properties" => $pl,
			);

			$features[] = $feature;

			if ((! isset($swlat)) || ($lat < $swlat)){
				$swlat = $lat;
			}

			if ((! isset($swlon)) || ($lon < $swlon)){
				$swlon = $lon;
			}

			if ((! isset($nelat)) || ($lat > $nelat)){
				$nelat = $lat;
			}

			if ((! isset($nelon)) || ($lon > $nelon)){
				$nelon = $lon;
			}

		}

		$bbox = array(
			$swlon, $swlat,
			$nelon, $nelat,
		);
		
		$now = time();

		$engine = array(
			"name" => "Who's On First",
			"author" => "Mapzen",
			"version" => "0.1"
		);

		$geocoding = array(
			"version" => "0.2",
			"attribution" => "https://github.com/whosonfirst/whosonfirst-data/blob/master/LICENSE.md",
			"query" => $more["pelias_query"],
			"engine" => $engine,
			"timestamps" => $now,
		);

		$pagination = $rsp;
		unset($pagination["places"]);

		$collection = array(
			"geocoding" => $geocoding,
			"type" => "FeatureCollection",
			"features" => $features,
			"bbox" => $bbox,
			# "wof:pagination" => $pagination,
		);
		
		api_output_send($collection, $more);
	}

	#################################################################

	function api_output_error($code=450, $msg='', $more=array()){

		$more['is_error'] = 1;

		$err = api_errors_build_error($code, $msg);
		$out = array('error' => $err);

		api_log($out);

		api_output_send($out, $more);
	}

	#################################################################

	function api_output_send($rsp, $more=array()){

		$stat = (isset($more['is_error'])) ? 'error' : 'ok';
		api_log(array('stat' => $stat), 'write');

		api_output_utils_start_headers($rsp, $more);

		if (features_is_enabled("api_cors")){

			if ($origin = $GLOBALS['cfg']['api_cors_allow_origin']){
				header("Access-Control-Allow-Origin: " . htmlspecialchars($origin));
			}
		}

		if (! request_isset("inline")){
			header("Content-Type: text/json");
		}

		$json = json_encode($rsp);
		header("Content-Length: " . strlen($json));

		echo $json;
		exit();
	}

	########################################################################

	# the end
