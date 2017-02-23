<?php

	loadlib("http_codes");

	#################################################################

	function api_errors_build_error($code, $msg, $more=array()){

		$defaults = array(
			"method" => apache_getenv("API_METHOD"),				# this is set lib_api.php
		);

		$more = array_merge($defaults, $more);

		$method = $more["method"];
		$method_row = $GLOBALS['cfg']['api']['methods'][$method];

		$code = intval($code);

		$is_http_error = (http_codes_is_assigned($code)) ? 1 : 0;
		$is_method_error = (($code >= 432) && ($code <= 449)) ? 1 : 0;
		$is_api_error = (($code >= 450) && ($code <= 499)) ? 1 : 0;

		# dumper("http: {$is_http_error} method: {$is_method_error} api: ${is_api_error}");
		# dumper("code ${code}");

		if ($is_http_error){

			$status_code = $code;
			$status_msg = $codes[ $status_code ];
		}

		else if (($is_method_error) && (isset($method_row["errors"])) && (isset($method_row["errors"][$code]))){

			$status_code = $code;
			$status_msg = $method_row["errors"][$code]['message'];
		}

		else if (($is_api_error) && (isset($GLOBALS['cfg']['api']['errors'][$code]))){
			$status_code = $code;
			$status_msg = $GLOBALS['cfg']['api']['errors'][$code]['message'];
		}

		# generic OMGWTF error code defined in config_api_errors_common.php

		else {

			$status_code = 450;
			$status_msg = $GLOBALS['cfg']['api']['errors'][$code]['message'];
		}

		return array(
			"code" => $status_code,
			"message" => $status_msg,
		);
	}

	#################################################################

	# the end