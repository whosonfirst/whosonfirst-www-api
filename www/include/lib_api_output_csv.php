<?php

	loadlib("http_codes");

	#################################################################

	function api_output_ok($rsp=array(), $more=array()){
		api_output_send($rsp, $more);
	}

	#################################################################

	function api_output_error($code=999, $msg='', $more=array()){

		$rsp = array('error' => array(
			'code' => $code,
			'message' => $msg,
		));

		$more['is_error'] = 1;
		api_output_send($rsp, $more);
	}

	#################################################################

	function api_output_send($rsp, $more=array()){

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

			header("X-whosonfirst-pagination-total: " . htmlspecialchars($rsp['total']));
			header("X-whosonfirst-pagination-per-page: " . htmlspecialchars($rsp['per_page']));
			header("X-whosonfirst-pagination-pages: " . htmlspecialchars($rsp['pages']));
			header("X-whosonfirst-pagination-page: " . htmlspecialchars($rsp['page']));

			$fh = fopen("php://memory", "w");

			$header = array();
			$lookup = array();

			foreach (array_keys($rsp['results'][0]) as $k){

				$k_clean = api_output_csv_clean_header($k);

				$header[] = $k_clean;
				$lookup[$k_clean] = $k;
			}

			sort($header);

			$str_header = implode(",", $header);
			header("X-whosonfirst-csv-header: " . htmlspecialchars($str_header));
			
			if ($rsp['page'] == 1){
				$out = array_values($header);
				fputcsv($fh, $out);
			}

			foreach ($rsp['results'] as $row){

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
