<?php

	loadlib("whosonfirst_uri");

	########################################################################

	function api_whosonfirst_output_enpublicify(&$rows, $more=array()){

		$defaults = array(
			"extras" => "",
			"is_tile38" => 0,
		);

		$more = array_merge($defaults, $more);

		# because this: https://github.com/whosonfirst/whosonfirst-www-api/issues/11

		if (($extras = $more["extras"]) && ($more["is_tile38"])){

			if (! is_array($extras)){
				$extras = explode(",", $extras);
			}

			$ids = array();

			foreach ($rows as $row){
				$ids[] = $row['wof:id'];
			}

			$fields = array_keys($rows[0]);
			$has_extras = 0;

			foreach ($extras as $f){

				if (! in_array($f, $fields)){
					$has_extras = 1;
					$fields[] = $f;
				}
			}

			if ($has_extras){

				$es_more = array('fields' => $fields);

				$rsp = whosonfirst_places_get_by_id_multi($ids, $es_more);

				if (! $rsp['ok']){
					return;
				}

				$rows = $rsp['rows'];
			}
		}

		# okay, carry on...

		$count = count($rows);

		for ($i=0; $i < $count; $i++){

			$rows[$i] = api_whosonfirst_output_enpublicify_single($rows[$i], $more);
		}
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

			if ($k == "wof:path"){

				if (isset($raw[$k])){
					$out[$k] = $raw[$k];
				}

				else {
					$out[$k] = whosonfirst_uri_id2relpath($raw['wof:id']);
				}

				continue;
			}

			if ($k == "mz:uri"){

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

				continue;
			}

			if (! isset($raw[$k])){

				$out[$k] = "";
				continue;
			}

			$out[$k] = $raw[$k];
		}

		# note the pass by ref
	}

	########################################################################

	# the end