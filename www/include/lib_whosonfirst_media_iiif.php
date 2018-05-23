<?php

	loadlib("iiif_image_api");

	########################################################################

	function whosonfirst_media_iiif_process_image($source, $instructions, $args=array()){

		$processed = array();

		$root = dirname($source);
		$fname = basename($source);

		if ($args["destination"]){
			$root = $args["destination"] . DIRECTORY_SEPARATOR . $root;
		}

		foreach ($instructions as $label => $args){

			$dest_fname = "{$fname}_{$label}.{$args['format']}";
			$dest_path = $root . DIRECTORY_SEPARATOR . $dest_fname;

			$rsp = iiif_image_api_convert($source, $dest_path, $args);
			
			if (! $rsp["ok"]){
				return $rsp;
			}

			$processed[$label] = $dest_path;
		}

		return array("ok" => 1, "processed" => $processed);	
	}

	########################################################################

	# the end	