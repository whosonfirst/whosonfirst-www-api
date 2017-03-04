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

		$is_http_error   = api_errors_is_http_error($code);
		$is_method_error = api_errors_is_method_error($code);
		$is_api_error    = api_errors_is_api_error($code);

		# error_log("http: {$is_http_error} method: {$is_method_error} api: ${is_api_error}");
		# dumper("code ${code}");
		# dumper($method_row["errors"]);

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

			$status_code = ($code < 500) ? 450 : 512;
			$status_msg = $GLOBALS['cfg']['api']['errors'][$code]['message'];
		}

		return array(
			"code" => $status_code,
			"message" => $status_msg,
		);
	}

	#################################################################

	function api_errors_is_http_error($code){

		$code = intval($code);

		return http_codes_is_assigned($code);
	}

	#################################################################

	function api_errors_is_method_error($code){

		$code = intval($code);

		if (($code >= 432) && ($code <= 449)){
			return 1;
		}

		if (($code >= 513) && ($code <= 599)){
			return 1;
		}

		return 0;
	}

	#################################################################

	function api_errors_is_api_error($code){

		$code = intval($code);

		if (($code >= 450) && ($code <= 499)){
			return 1;
		}

		return 0;
	}
	#################################################################

	# the end