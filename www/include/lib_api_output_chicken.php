<?php

	########################################################################

	loadlib("http_codes");
	loadlib("chicken_api");
	
	#################################################################

	function api_output_ok($rsp=array(), $more=array()){

		$rsp = api_output_chicken($rsp);
		
		if (! $rsp["ok"]){
			
			$err = api_errors_build_error($code);
			$out = array('error' => $err, 'chicken' => $rsp["body"]);
			
			api_output_send($out, $more);
		}

		$out = array("chicken" => $rsp["body"]);
		api_output_send($out, $more);
	}

	#################################################################

	function api_output_error($code=450, $msg='', $more=array()){

		$more['is_error'] = 1;

		$err = api_errors_build_error($code, $msg);
		$out = array('error' => $err);

		api_log($out);

		$rsp = api_output_chicken($out);
		$out["chicken"] = $rsp["body"];

		api_output_send($out, $more);
	}

	#################################################################

	function api_output_send($rsp, $more=array()){
		
		$stat = (isset($more['is_error'])) ? 'error' : 'ok';
		api_log(array('stat' => $stat), 'write');

		api_output_utils_start_headers($rsp, $more);

		if (features_is_enabled("api_cors")){

			if ($origin = $GLOBALS['cfg']['api_cors_allow_origin']){
				header("Access-Control-Allow-Origin: " . htmlspecialchars($origin));
			}
		}

		if (! request_isset("inline")){
			header("Content-Type: text/chicken");
		}

		$chicken = $rsp["chicken"];
		header("Content-Length: " . strlen($chicken));

		echo $chicken;
		exit();
	}

	#################################################################

	function api_output_chicken($rsp){

		$json = json_encode($rsp, JSON_PRETTY_PRINT);
		$rsp = chicken_api_call($json);

		if (! $rsp["ok"]){
			$rsp["body"] = "🍗";
		}

		return $rsp;
	}
	
	#################################################################
	
	# the end
