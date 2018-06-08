<?php

	loadlib("iiif_image_api");

	########################################################################

	function whosonfirst_media_iiif_process_image($source, $instructions, $args=array()){

		$processed = array();
		$colours = array();

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

		if (features_is_enabled("whosonfirst_media_iiif_colours")){

			$sz = $GLOBALS["cfg"]["iiif_colours_use_size"];

			if ($sz){
		
				$source = $processed[$sz];	# PLEASE CHECK FOR 'o'

				# DO NOT LIKE HAVING TO DO THIS... NOT SURE WHAT TO DO INSTEAD
				# (20180608/thisisaaronland)

				$palette_src = str_replace($GLOBALS["cfg"]["whosonfirst_uploads_pending_dir"], "", $source);
				$palette_src = ltrim($palette_src, "/");

				$rsp = whosonfirst_media_iiif_get_palette_service($palette_src);

				if ($rsp["ok"]){
					$service = $rsp["service"];
					$colours = $service["palette"];
				}
			}
		}

		return array("ok" => 1, "processed" => $processed, "colours" => $colours);	
	}

	########################################################################

	function whosonfirst_media_iiif_get_palette_service($source, $more=array()){

		$defaults = array(
			"profile" => "x-urn:service:go-iiif#palette"		// see also: go-iiif/service/palette.go
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
