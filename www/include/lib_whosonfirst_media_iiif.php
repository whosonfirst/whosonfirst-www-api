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

			if ($args["format"] == ""){
				$ext = pathinfo($source, PATHINFO_EXTENSION);
				$args["format"] = $ext;
			}

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

	function whosonfirst_media_iiif_get_palette_service($source, $more=array()){

		$defaults = array(
			"profile" => "x-urn:service:palette"
		);

		$more = array_merge($defaults, $more);

		$rsp = iiif_image_api_info($source, $more);

		if (! $rsp["ok"]){
			return $rsp;
		}

		$profile = $more["profile"];
		$service = null;

		foreach ($rsp["info"]["service"] as $s){

			if ($s["profile"] == $profile){
				$service = $s;
				break;
			}
		}

		if (! $service){
			return array("ok" => 0, "error" => "Missing '{$profile}' profile");
		}

		return array("ok" => 1, "service" => $service);
	}

	########################################################################

	# the end	