<?php

	########################################################################

	loadlib("http_codes");

	#################################################################

	function api_output_ok($rsp=array(), $more=array()){

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
				"properties" => $pt,
			);

			$features[] = $feature;
		}

		$bbox = array(
			$swlon, $swlat,
			$nelon, $nelat,
		);
		
		$collection = array(
			"geocoding" => array(),
			"type" => "FeatureCollection",
			"features" => "features",
			"bbox" => $bbox,
		);
		
		api_output_send($rsp, $more);
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

		$rsp['stat'] = (isset($more['is_error'])) ? 'error' : 'ok';
		api_log(array('stat' => $rsp['stat']), 'write');

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
