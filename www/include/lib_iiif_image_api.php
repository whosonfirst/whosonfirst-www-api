<?php

	loadlib("http");

	########################################################################

	# http://iiif.io/api/image/2.1/#canonical-uri-syntax

	function iiif_image_api_request($uri, $args=array()){

		$defaults = array(
			"region" => "full",		# deprecated in 3.x
			"size" => "full",		# deprecated in 3.x
			"rotation" => "0",
			"quality" => "default",
			"format" => "jpg",
		);

		$args = array_merge($defaults, $args);

		$req = "{$uri}/{$args["region"]}/{$args["size"]}/{$args["rotation"]}/{$args["quality"]}.{$args["format"]}";

		return iiif_image_api_do($req, $args);
	}

	########################################################################

	function iiif_image_api_convert($source, $dest, $args){

		$fh = fopen($dest, "wb");

		if (! $fh){
			return array("ok" => 0, "error" => "Failed to open file for writing");
		}

		$rsp = iiif_image_api_request($source, $args);

		if (! $rsp["ok"]){

			fclose($fh);
			unlink($dest);

			return $rsp;
		}

		fwrite($fh, $rsp["body"]);
		fclose($fh);

		return array("ok" => 1);
	}

	########################################################################

	function iiif_image_api_info($uri, $args=array()){

		$req = "{$uri}/info.json";

		$rsp = iiif_image_api_do($req, $args);

		if (! $rsp["ok"]){
			return $rsp;
		}

		$info = json_decode($rsp["body"], "as hash");

		if (! $info){
			$rsp["ok"] = 0;
			$rsp["error"] = "Failed to parse response";
			return $rsp;
		}

		$rsp["info"] = $info;
		return $rsp;
	}

	########################################################################

	function iiif_image_api_uri_to_path($uri){

		$path = array();

		foreach (explode("/", $uri) as $p){
			$path[] = urlencode($p);
		}

		return implode("/", $path);
	}

	########################################################################

	function iiif_image_api_do($uri, $args=array()){

		$defaults = array();

		$args = array_merge($defaults, $args);

		$enc_path = iiif_image_api_uri_to_path($uri);

		$endpoint = $GLOBALS["cfg"]["iiif_api_endpoint"];
		$endpoint = rtrim($endpoint, "/");

		$req = "{$endpoint}/{$enc_path}";

		$rsp = http_get($req, $args);
		return $rsp;
	}

	########################################################################

	# the end