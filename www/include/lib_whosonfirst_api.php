<?php

	$GLOBALS['whosonfirst_api_endpoint'] = "https://whosonfirst-api.dev.mapzen.com";

	########################################################################

	loadlib("http");

	########################################################################

	function whosonfirst_api_call($method, $args=array()){

		$rsp = whosonfirst_api_execute_method($method, $args);

		if (! $rsp['ok']){
			return $rsp;
		}

		$data = json_decode($rsp["body"], "as hash");

		if (! $data){
			return array("ok" => 0, "error" => "Failed to parse response");
		}

		return array("ok" => 1, "data" => $data);
	}

	########################################################################

	function whosonfirst_api_execute_method($method, $args=array()){

		$url = $GLOBALS['whosonfirst_api_endpoint'];
		$args["method"] = $method;

		$headers = array();

		return http_post($url, $args, $headers);
	}
	
	########################################################################

	# the end
	