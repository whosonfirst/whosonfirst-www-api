<?php

	loadlib("whosonfirst_uri");

	########################################################################

	function api_whosonfirst_output_enpublicify(&$rows, $more=array()){

		$count = count($rows);

		# TO DO: https://github.com/whosonfirst/whosonfirst-www-api/issues/11

		for ($i=0; $i < $count; $i++){

			$rows[$i] = api_whosonfirst_output_enpublicify_single($rows[$i], $more);
		}
	}

	########################################################################

	function api_whosonfirst_output_enpublicify_single($row, $more=array()){

		$defaults = array(
			"extras" => "",
			"is_tile38" => 0,
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

			# See above inre: issue #11 / translation: this should be happening further up the stack)
			# (20161031/thisisaaronland)

			if ($more["is_tile38"]){

				$rsp = whosonfirst_places_get_by_id($row['wof:id']);
				$es_row = $rsp['rows'][0];

				$row = $es_row;
			}

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