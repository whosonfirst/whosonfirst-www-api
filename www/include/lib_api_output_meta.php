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

			$header = array();
			$lookup = array();

			$map = api_output_meta_map();
			ksort($map);

			$header = array_keys($map);

			$str_header = implode(",", $header);
			header("X-whosonfirst-csv-header: " . htmlspecialchars($str_header));
			
			if ($rsp['page'] == 1){
				$out = array_values($header);
				fputcsv($fh, $out);
			}

			foreach ($rsp['results'] as $row){

				$out = array();

				foreach ($map as $meta_k => $wof_k){

					$value = $row[ $wof_key ];

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

	# see also which means read: please move this in a common JSON file or something...
	# https://github.com/whosonfirst/py-mapzen-whosonfirst-meta/blob/master/mapzen/whosonfirst/meta/__init__.py
	# (20170228/thisisaaronland)

	function api_output_meta_map(){

		$map = array(
			'id'			=>  'wof:id',
			'parent_id'		=> 'wof:parent_id',
			'name'			=> 'wof:name',
			'placetype'		=> 'wof:placetype',
			'fullname'		=> '',		#  what is this
			'source'		=> 'src:geom',
			'path'			=> '',		# please derive me
			'lastmodified'		=> 'wof:lastmodified',
			'iso'			=> 'iso:country',
			'iso_country'		=> 'iso:country',
			'wof_country'		=> 'wof:country',
			'bbox'			=> 'geom:bbox',
			'file_hash'		=> '',
			'geom_hash'		=> 'geom:hash',
			'geom_latitude'		=> 'geom:latitude',
			'geom_longitude'	=>'geom:longitude',
			'lbl_latitude'		=> 'lbl:latitude',
			'lbl_longitude'		=> 'lbl:longitude',
			'supersedes'		=> 'wof:supersedes',
			'superseded_by'		=> 'wof:superseded_by',
			'inception'		=> 'edtf:inception',
			'cessation'		=> 'edtf:cessation',
			'deprecated'		=> 'edtf:deprecated',
			'country_id'		=> '',
			'region_id'		=> '',
			'locality_id'		=> '',
		);

		return $map;
	}

	#################################################################

	# the end
