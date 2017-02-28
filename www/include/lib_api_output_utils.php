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

			$status_code = $rsp['error']['code'];
			$status_msg = $rsp['error']['message'];
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

		if ((isset($rsp['cursor'])) || (isset($rsp['total']))){

			header("X-api-pagination-total: " . htmlspecialchars($rsp['total']));
			header("X-api-pagination-per-page: " . htmlspecialchars($rsp['per_page']));
			header("X-api-pagination-pages: " . htmlspecialchars($rsp['pages']));
			header("X-api-pagination-page: " . htmlspecialchars($rsp['page']));
			header("X-api-pagination-cursor: " . htmlspecialchars($rsp['cursor']));
			header("X-api-pagination-next-query: " . htmlspecialchars($rsp['next_query']));
		}
	}

	#################################################################

	# the end
