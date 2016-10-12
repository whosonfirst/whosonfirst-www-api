<?php

	########################################################################

	function api_whosonfirst_output_enpublicify(&$rows, $more=array()){

		$count = count($rows);

		for ($i=0; $i < $count; $i++){

			$rows[$i] = api_whosonfirst_output_enpublicify_single($rows[$i], $more);
		}
	}

	########################################################################

	function api_whosonfirst_output_enpublicify_single($row, $more=array()){

		$defaults = array(
			"extras" => ""
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

			$extras = explode(",", $extras);

			foreach ($extras as $k){

				$k = trim($k);

				if (! isset($row[$k])){

					$public[$k] = "";
					continue;
				}

				$public[$k] = $row[$k];
			}
		}

		return $public;
	}

	########################################################################

	# the end