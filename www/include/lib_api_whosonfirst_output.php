<?php

	loadlib("whosonfirst_uri");
	loadlib("whosonfirst_sources");

	########################################################################

	function api_whosonfirst_output_enpublicify(&$rows, $more=array()){

		$defaults = array(
			"extras" => "",
			"is_tile38" => 0,
		);

		$more = array_merge($defaults, $more);

		# because this: https://github.com/whosonfirst/whosonfirst-www-api/issues/11
		# and this: https://github.com/whosonfirst/whosonfirst-www-api/issues/8

		if (($extras = $more["extras"]) && ($more["is_tile38"])){

			if (! is_array($extras)){
				$extras = explode(",", $extras);
			}

			$fields = array_keys($rows[0]);		# don't forget to fetch the defaults
			$has_extras = 0;

			# just double check that there is actually something we need
			# pull out of ES before we poke the network (20161031/thisisaaronland)

			foreach ($extras as $f){

				# See this - it's important if you pass an empty field ('')
				# to ES it will FREAK OUT and return null values for all
				# the fields. This is why we can't have nice things...
				# (20170428/thisisaaronland)

				if (($f) && (! in_array($f, $fields))){
					$has_extras = 1;
					$fields[] = $f;
				}
			}

			if ($has_extras){

				$ids = array();

				foreach ($rows as $row){

					$wofid = $row['wof:id'];

					# this shouldn't be necassary but that's true of a lot of things in life...
					# https://github.com/whosonfirst/go-whosonfirst-tile38/issues/10

					if (! in_array($wofid, $ids)){
						$ids[] = $row['wof:id'];
					}
				}

				$es_more = array('fields' => $fields);

				$rsp = whosonfirst_places_get_by_id_multi($ids, $es_more);

				if (! $rsp['ok']){
					return;
				}

				# remember: we are passing $rows by reference so the tile38 rows
				# get clobbered here - we may live to regret that but today we don't
				# (20161031/thisisaaronland)

				$rows = $rsp['rows'];
			}
		}

		# okay, carry on...

		$count = count($rows);

		for ($i=0; $i < $count; $i++){

			$rows[$i] = api_whosonfirst_output_enpublicify_single($rows[$i], $more);
		}

		# pass-by-ref
	}

	########################################################################

	# Note: until necessary we have removed the is_tile38-and-fetch-from-es code
	# from this function. It lives in api_whosonfirst_output_enpublicify for now
	# (21061031/thisisaaronland)

	function api_whosonfirst_output_enpublicify_single($row, $more=array()){

		$defaults = array(
			"extras" => "",
		);

		$more = array_merge($defaults, $more);

		$public = array(
			'wof:id' => $row['wof:id'],
			'wof:parent_id' => $row['wof:parent_id'],
			'wof:name' => $row['wof:name'],
			'wof:placetype' => $row['wof:placetype'],
			'wof:country' => $row['wof:country'],
			'wof:repo' => $row['wof:repo'],
		);

		if ($extras = $more["extras"]){

			api_whosonfirst_output_add_extras($public, $row, $extras, $more);
		}

		return $public;
	}

	########################################################################

	function api_whosonfirst_output_add_extras(&$out, &$raw, &$extras, $more=array()){

		if (! is_array($extras)){
			$extras = explode(",", $extras);
		}

		foreach ($extras as $k){

			$k = trim($k);

			list($source, $ignore) = explode(":", $k, 2);

			if (! whosonfirst_sources_is_valid_prefix($source)){
				continue;
			}

			if ($k == "wof:path"){

				api_whosonfirst_output_add_wof_path($out, $raw);
			}

			else if ($k == "mz:uri"){

				api_whosonfirst_output_add_mz_uri($out, $raw);
			}

			# remember, we 've established $source above in the main foreach loop

			else if (preg_match("/^(?:.*)\:\*?$/", $k, $m)){

				foreach ($raw as $raw_k => $v){

					list($raw_prefix, $ignore) = explode(":", $raw_k, 2);

					if ($raw_prefix == $source){
						$out[$raw_k] = $v;
					}
				}

				if ($source == "mz"){
					api_whosonfirst_output_add_mz_uri($out, $raw);
				}

				else if ($source == "wof"){
					api_whosonfirst_output_add_wof_path($out, $raw);
				}

				else {}
			}

			else if (! isset($raw[$k])){

				$out[$k] = "";
			}

			else {
				$out[$k] = $raw[$k];
			}

		}

		# note the pass by ref
	}

	########################################################################

	# this is its own function so that we can return wof:path when extras=wof:path
	# or extras=wof:

	function api_whosonfirst_output_add_wof_path(&$out, &$raw){

		$k = "wof:path";

		if (isset($raw[$k])){
			$out[$k] = $raw[$k];
		}

		else {
			$out[$k] = whosonfirst_uri_id2relpath($raw['wof:id']);
		}

		# pass by ref
	}

	########################################################################

	# this is its own function so that we can return mz:uri when extras=mz:uri
	# or extras=mz:

	function api_whosonfirst_output_add_mz_uri(&$out, &$raw){

		if (isset($raw['wof:path'])){
			$path = $raw['wof:path'];
		}

		else {
			$path = whosonfirst_uri_id2relpath($raw['wof:id']);
		}

		# Because it's our party so we can decide these things
		# (20161021/thisisaaronland)

		$uri = "https://whosonfirst.mapzen.com/data/" . $path;
		$out['mz:uri'] = $uri;

		# pass by ref
	}

	########################################################################
	# the end