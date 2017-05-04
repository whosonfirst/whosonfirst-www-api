<?php

	loadlib("geo_utils");

	loadlib("whosonfirst_pip");
	loadlib("whosonfirst_placetypes");
	loadlib("whosonfirst_places");
	loadlib("api_whosonfirst_output");

	########################################################################

	function api_whosonfirst_repos_getByLatLon(){

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

		# please put me in GLOBALS or a config somewhere

		$repo = array(
			"whosonfirst",
			"data",
		);

		$append_repo = array(
			"constituency",
			"intersection",
			"postalcode",
			"venue",
		);

		$reversegeo_country = array(
			"constituency",
			"intersection",
			"postalcode",
			"venue",
		);

		$reversegeo_region = array(
			"constituency" => array("US"),
			"intersection",
			"postalcode",
			"venue" => array("US"),
		);
		
		# end of please put me in GLOBALS

		if (in_array($pt, $append_repo)){
			$repo[] = $pt;
		}

		if (in_array($pt, $reversegeo_country)){

			$more["placetype"] = "region";
			$rsp = whosonfirst_pip_get_by_latlon($lat, $lon, $more);

			if (! $rsp){
				api_output_error(513);			
			}

			$rows = $rsp["rows"];
			$count = count($rows);
			
			if (! $count){
				api_output_error(514);
			}

			if ($count > 1){
				api_output_error(514);
			}

			$pip_row = $rows[0];

			$more = array("extras" => "unlc:");

			$row = whosonfirst_places_get_by_id($pip_row["Id"]);
			$public = api_whosonfirst_output_enpublicify_single($row, $more);

			$iso = $public["wof:country"];

			if (! $iso){
				api_output_error(516);
			}

			$repo[] = strtolower($iso);

			if ((isset($reversegeo_region[$pt])) && (in_array($iso, $reversegeo_region[$pt]))){

				if (! isset($public["unlc:subdivision"])){
					api_output_error(517);
				}

				$sub = $public["unlc:subdivision"];
				list($ignore, $region) = explode("-", $sub);

				if (! $region){
					api_output_error(518);
				}

				$repo[] = strtolower($region);
			}
		}

		$repo = implode("-", $repo);

		$url = "https://github.com/whosonfirst-data/{$repo}";

		$out = array(
			"repo" => $repo,
			"url" => $url,
		);

		api_output_ok($out);
	}

	########################################################################

	# the end