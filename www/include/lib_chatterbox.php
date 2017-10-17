<?php

	########################################################################

	function chatterbox_dispatch($msg, $more=array()){

		$defaults = array(
			"host": gethostname(),
			"application": $GLOBALS["cfg"]["site_name"],
			"context": $GLOBALS["cfg"]["environment"],
			"status" => "ok",
			"status_code" => 1,
		);

		$data = array_merge($more, $defaults);
		$data["details"] = $msg;

		$channel = $GLOBALS["cfg"]["chatterbox_channel"];
		$destination = $GLOBALS["cfg"]["chatterbox_destination"];

		return array("ok" => 0, "error" => "please implement me");
	}

	########################################################################

	# the end