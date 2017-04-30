<?php

	loadlib("http");

	$GLOBALS["chicken_api"]["endpoint"] = "http://localhost:8080";
	
	########################################################################

	function chicken_api_call($body, $more=array()){

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
