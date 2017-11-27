<?php

	loadlib("http_codes");

	#################################################################

	function api_output_ok($rsp=array(), $more=array()){
		api_output_send($rsp, $more);
	}

	#################################################################

	function api_output_error($code=450, $msg='', $more=array()){

		$rsp = array('error' => array(
			'code' => $code,
			'message' => $msg,
		));

		$more['is_error'] = 1;
		api_output_send($rsp, $more);
	}

	#################################################################

	function api_output_send($rsp, $more=array()){

		$defaults = array(
			"key" => "results",
			"is_singleton" => 0,
		);

		$more = array_merge($defaults, $more);

		api_log(array('stat' => $rsp['stat']), 'write');

		api_output_utils_start_headers($rsp, $more);

		if (features_is_enabled("api_cors")){

			if ($origin = $GLOBALS['cfg']['api_cors_allow_origin']){
				header("Access-Control-Allow-Origin: " . htmlspecialchars($origin));
			}
		}

		if (! request_isset("inline")){
			header("Content-Type: text/csv");
		}

		if (! $more['is_error']){

			$fh = fopen("php://memory", "w");

			$k = $more["key"];
			$possible = $rsp[ $k ];

			if ($more["is_singleton"]){				
				$possible = array($possible);
			}

			$header = array();
			$lookup = array();

			foreach ($possible as $p){

				foreach (array_keys($p) as $k){

					$k_clean = api_output_csv_clean_header($k);

					if (! $lookup[$k_clean]){
						$header[] = $k_clean;
						$lookup[$k_clean] = $k;
					}
				}		
			}

			# so here's a thing, well two things actually:
			#
			# 1. if you request extras that are not in a response (say foo:*) they
			#    will not be included (for example, how do we know what to include
			#    for 'foo:*")
			# 2. the list of headers may vary across paginated responses because
			#    the records in the first set may not have the same properties as
			#    those in the subsequent sets
			#
			# this is not a feature but short of getting in to a whole lot of weird
			# session maintenance hoohah (mostly just for CSV headers...) it seems
			# like the more appropriate course of action right now is just to convey
			# the disconnect to api consumers and have them handle it on their end
			# as they see fit - this makes simple and consistent piping of CSV results
			# for anything but a default SPR response difficult but sometimes we can't
			# have nice things... (20171127/thisisaaronland)

			sort($header);

			$str_header = implode(",", $header);
			header("X-api-format-csv-header: " . htmlspecialchars($str_header));
			
			# sudo put me in a foo_print_header() function or something...
			# we are doing the same in lib_api_output_meta.php
			# (20170304/thisisaaronland)

			if (! $more["is_singleton"]){

				$out = array_values($header);
				fputcsv($fh, $out);
			}

			else {

				$pg_args = array();
				api_utils_ensure_pagination_args($pg_args);

				if (($pg_args['page'] == 1) && (! isset($pg_args['cursor']))){
					$out = array_values($header);
					fputcsv($fh, $out);
				}
			}

			foreach ($possible as $row){

				$out = array();

				foreach ($header as $k_clean){

					$key = $lookup[$k_clean];
					$value = $row[ $key ];

					if (! is_scalar($value)){
						$value = json_encode($value);
					}

					$out[] = $value;
				}

				fputcsv($fh, $out);
			}

			header("Content-Length: " . ftell($fh));

			rewind($fh);
			echo stream_get_contents($fh);
		}

		exit();
	}

	#################################################################

	function api_output_csv_clean_header($header){

		$clean = str_replace(":", "_", $header);
		return $clean;
	}

	#################################################################

	# the end
