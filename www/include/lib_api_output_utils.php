<?php

	loadlib("http_codes");

	#################################################################

	function api_output_utils_start_headers($rsp, $more=array()){

		$defaults = array(
			'is_error' => 0
		);

		$more = array_merge($defaults, $more);

		$codes = http_codes();

		$status_code = 200;
		$status_msg = $codes[ $status_code ];

		if ((isset($more['is_error'])) && ($more['is_error'])){

			$code = $rsp['error']['code'];

			if (http_codes_is_assigned($code)){

				$status_code = $code;
				$status_msg = $codes[ $status_code ];
			}

			else if (isset($GLOBALS['api_errors'][$code])){

				$status_code = $code;
				$status_msg = $GLOBALS['api_errors'][$code]['message'];
			}

			else {

				# genetic OMGWTF error code defined in config_api_errors_common.php

				$status_code = 450;
				$status_msg = $GLOBALS['api_errors'][$code]['message'];
			}
		}

		else if (isset($more['created'])){
			$status_code = 201;
			$status_msg = $codes[ $status_code ];
		}

		else {}

		$status = "{$status_code} {$status_msg}";
		$enc_status = htmlspecialchars($status);

		utf8_headers();

		header("HTTP/1.1 {$enc_status}");
		header("Status: {$enc_status}");

		if ((isset($more['is_error'])) && ($more['is_error'])){

			if (! is_array($rsp['error']['code'])){
				header("X-api-error-code: " . htmlspecialchars($rsp['error']['code']));
			}

			if (! is_array($rsp['error']['message'])){
				header("X-api-error-message: " . htmlspecialchars($rsp['error']['message']));
			}
		}
	}

	#################################################################

	# the end
