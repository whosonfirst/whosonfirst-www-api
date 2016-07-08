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

			# PLEASE MAKE ME MORE FLEXIBLE TO ACCOMODATE THINGS THAT AREN'T PAGINATED
			# AND NOT JUST $rsp['results'] EITHER (20160708/thisisaaronland)

			header("X-whosonfirst-pagination-total: " . htmlspecialchars($rsp['total']));
			header("X-whosonfirst-pagination-per-page: " . htmlspecialchars($rsp['per_page']));
			header("X-whosonfirst-pagination-pages: " . htmlspecialchars($rsp['pages']));
			header("X-whosonfirst-pagination-page: " . htmlspecialchars($rsp['page']));

			$fh = fopen("php://memory", "w");
	
			$lookup = array(
				"id" => "wof:id",
				"name" => "wof:name",
				"placetype" => "wof:placetype",
			);

			$header = array_keys($lookup);
			sort($header);

			$str_header = implode(",", $header);
			header("X-whosonfirst-csv-header: " . htmlspecialchars($str_header));
			
			if ($rsp['page'] == 1){
				$out = array_values($header);
				fputcsv($fh, $out);
			}

			foreach ($rsp['results'] as $row){

				$out = array();

				foreach ($header as $key){
					$wof_key = $lookup[ $key ];
					$out[] = $row[ $wof_key ];
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

	# the end
