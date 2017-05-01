<?php

	loadlib("http");

	$GLOBALS["chicken_api"]["endpoint"] = "http://localhost:1280";
	
	########################################################################

	function chicken_api_call($body, $more=array()){

		$defaults = array(
			'endpoint' => $GLOBALS['chicken_api']['endpoint'],
		);

		$more = array_merge($defaults, $more);

		$url = $GLOBALS["chicken_api"]["endpoint"];
		$query = array();

		if (count($query)){
			$query = http_build_query($query);
			       $url = $url . "?" . $query;
		}
		
		$rsp = http_post($url, $body);
		return $rsp;		     
	}
	
	########################################################################

	# the end
