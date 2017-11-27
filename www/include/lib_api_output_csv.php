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
