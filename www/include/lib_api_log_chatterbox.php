<?php

	loadlib("chatterbox");

	$GLOBALS['api_log_hooks']['dispatch'] = 'api_log_chatterbox_dispatch';

	########################################################################

	# untested (20171017/thisisaaronland)

	function api_log_chatterbox_dispatch($data){

		$status = "ok";
		$status_code = 200;

		if ($data["stat"] != "ok"){

			$status = $data["stat"];
			$status_code = $data["error"]["code"];
		}

		$more = array(
			"context" => "api",
			"status" => $status,
			"status_code" => $status_code,
		);

		return chatterbox_publish($data, $more);
	}

	########################################################################

	# the end