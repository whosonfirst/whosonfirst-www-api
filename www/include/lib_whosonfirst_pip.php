<?php

	loadlib("http");

	########################################################################

	function whosonfirst_pip_get_by_latlon($lat, $lon, $more=array()){

		 $defaults = array(
		 	"placetype" => null,
		 );

		 $more = array_merge($defaults, $more);

		 $query = array(
		 	"latitude" => $lat,
		 	"longitude" => $lon,
		 );

		 if (features_is_enabled("pip_v1")){
		 	$query["v1"] = "1";
		 }

		 # 'filter_parameters_spatial'

		 if ($pt = $more["placetype"]){
		 	$query["placetype"] = $pt;
		 }

		 $query = http_build_query($query);

		 $endpoint = whosonfirst_pip_endpoint();
		 $url = $endpoint . "?" . $query;

		 $rsp = http_get($url);

		 if (! $rsp["ok"]){
			 return $rsp;		    
		 }

		 $data = json_decode($rsp["body"], "as hash");

		 # because an empty array is "false" in php... (20170127/thisisaaronland)

		 if ((! $data) && (! is_array($data))){
		 	return array("ok" => 0, "error" => "Failed to parse response");			
		 }

		 return array("ok" => 1, "rows" => $data, "_query" => $query);
	}

	########################################################################

	function whosonfirst_pip_endpoint(){

		# deprecated

		if (! isset($GLOBALS["cfg"]["whosonfirst_pip_endpoints"])){
			return $GLOBALS["cfg"]["whosonfirst_pip_endpoint"];
		}

		$possible = $GLOBALS["cfg"]["whosonfirst_pip_endpoints"];
		shuffle($possible);
		shuffle($possible);

		return $possible[0];
	}

	########################################################################

	# the end