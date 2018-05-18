<?php

	loadlib("brooklyn_integers_api");

	########################################################################

	function brooklyn_integers_get_int(){

		$rsp = brooklyn_integers_api_post("brooklyn.integers.create");

		if (! $rsp["ok"]){
			return null;
		}

		$ints = $rsp["response"]["integers"];
		return $ints[0]["integer"];
	}

	########################################################################
	
	# the end	