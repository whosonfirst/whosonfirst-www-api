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
			header("X-api-format-meta-header: " . htmlspecialchars($str_header));
			
			if ($rsp['page'] == 1){
				$out = array_values($header);
				fputcsv($fh, $out);
			}

			foreach ($rsp['results'] as $row){

				$row = whosonfirst_places_get_by_id($row['wof:id']);

				# see notes below inre: keeping this in sync with py-mz-wof-meta
				# (20170228/thisisaaronland)

				$parent_hier = array(
					"country_id" => 0,
					"region_id" => 0,
					"locality_id" => 0
				);

				if (count($row["wof:hierarchy"]) == 1){

					$hier = $row["wof:hierarchy"][0];

					foreach ($parent_hier as $k => $ignore){
						$parent_hier[$k] = $hier[$k];
					}
				}
				
				$out = array();

				foreach ($map as $meta_k => $wof_k){

					if ($meta_k == "path"){
						$value = whosonfirst_uri_id2relpath($row['wof:id']);
					}

					else if ($meta_k == "file_hash"){
						$value = "";	# PLEASE FIX ME... we should store this in the ES index...
								# https://github.com/whosonfirst/py-mapzen-whosonfirst-search/issues/24
					}

					else if ($meta_k == "fullname"){
						$value = "";	# this has never really been implemented anywhere - maybe wof:label ?
					}

					else if (preg_match("/^(?:locality|region|country)_id$/", $meta_k)){
						$value = $parent_hier[$meta_k];
					}

					else {
						$value = $row[ $wof_k ];
					}

					if ((preg_match("/\:(latitude|longitude)$/", $wof_k)) && (! $value)){
						$value = 0.0;
					}

					else if (preg_match("/^wof:supersede/", $wof_k)){
						$value = implode(";", $value);
					}

					else {}

					if ((! $value) && (! is_numeric($value))){
						$value = "";
					}

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
			'id'			=> 'wof:id',
			'parent_id'		=> 'wof:parent_id',
			'name'			=> 'wof:name',
			'placetype'		=> 'wof:placetype',
			'fullname'		=> '',			# handled by code
			'source'		=> 'src:geom',
			'path'			=> '',			# handled by code
			'lastmodified'		=> 'wof:lastmodified',
			'iso'			=> 'iso:country',
			'iso_country'		=> 'iso:country',
			'wof_country'		=> 'wof:country',
			'bbox'			=> 'geom:bbox',
			'file_hash'		=> '',			# PLEASE FIX ME...
			'geom_hash'		=> 'wof:geomhash',
			'geom_latitude'		=> 'geom:latitude',
			'geom_longitude'	=> 'geom:longitude',
			'lbl_latitude'		=> 'lbl:latitude',
			'lbl_longitude'		=> 'lbl:longitude',
			'supersedes'		=> 'wof:supersedes',
			'superseded_by'		=> 'wof:superseded_by',
			'inception'		=> 'edtf:inception',
			'cessation'		=> 'edtf:cessation',
			'deprecated'		=> 'edtf:deprecated',
			'country_id'		=> '',			# handled by code
			'region_id'		=> '',			# handled by code
			'locality_id'		=> '',			# handled by code
		);

		return $map;
	}

	#################################################################

	# the end
