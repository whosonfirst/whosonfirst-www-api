<?php

	########################################################################

	function api_whosonfirst_output_enpublicify(&$rows){

		$count = count($rows);

		for ($i=0; $i < $count; $i++){

			$rows[$i] = api_whosonfirst_output_enpublicify_single($rows[$i]);
		}
	}

	########################################################################

	function api_whosonfirst_output_enpublicify_single($row){

		$public = array(
			'wof:id' => $row['wof:id'],
			'wof:parent_id' => $row['wof:parent_id'],
			'wof:name' => $row['wof:name'],
			'wof:placetype' => $row['wof:placetype'],
			'wof:country' => $row['wof:country'],
			'wof:repo' => $row['wof:repo'],
		);

		return $public;
	}

	########################################################################

	# the end