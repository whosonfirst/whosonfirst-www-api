<?php

	loadlib("http");

	# see also:
	# https://github.com/whosonfirst/go-whosonfirst-pip-v2

	########################################################################

	function whosonfirst_pip_get_by_latlon($lat, $lon, $more=array()){

		 $query = array(
		 	"latitude" => $lat,
		 	"longitude" => $lon,
		 );

		 $query = array_merge($query, $more);
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

		 $rows = $data["places"];

		 return array("ok" => 1, "rows" => $rows);
	}

	########################################################################

	function whosonfirst_pip_get_by_polyline($polyline, $more=array()){

		 $query = array(
		 	"polyline" => $polyline,
		 );

		 $query = array_merge($query, $more);
		 $query = http_build_query($query);

		 $endpoint = whosonfirst_pip_endpoint();
		 $url = $endpoint . "/polyline?" . $query;

		 $rsp = http_get($url);

		 if (! $rsp["ok"]){
			 return $rsp;		    
		 }

		 $data = json_decode($rsp["body"], "as hash");

		 # because an empty array is "false" in php... (20170127/thisisaaronland)

		 if ((! $data) && (! is_array($data))){
		 	return array("ok" => 0, "error" => "Failed to parse response");			
		 }

		 $rows = $data["places"];
		 $pagination = $data["pagination"];

		 return array("ok" => 1, "rows" => $rows, "pagination" => $pagination);
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