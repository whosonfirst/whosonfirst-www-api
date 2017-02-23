<?php

	# API errors that are common to all API method so things that are
	# typically auth and dispatch related

	########################################################################

	$GLOBALS['cfg']['api']['errors'] = array_merge(array(

		"499" => array(
			"message" => "API method not found"
		),

	), $GLOBALS['cfg']['api']['errors']);

	########################################################################

	# the end
