<?php

	# API errors that are common to all API method so things that are
	# typically auth and dispatch related

	########################################################################

	$GLOBALS['cfg']['api']['errors'] = array_merge(array(

		"405" => array(
			"message" => "Method not allowed",
		),

		"487" => array(
			"message" => "Insufficient permissions for this API key",
		),

		"488" => array(
			"message" => "Invalid access token for this API key",
		),

		"489" => array(
			"message" => "Unauthorized host for this API key",
		),

		"490" => array(
			"message" => "API key not configured for use with this method",
		),

		"491" => array(
			"message" => "Missing or invalid crumb",
		),

		"492" => array(
			"message" => "Not a valid user",
		),

		"493" => array(
			"message" => "Access token has insuffient permissions",
		),

		"494" => array(
			"message" => "Access token is expired",
		),

		"495" => array(
			"message" => "Access token is disabled",
		),

		"496" => array(
			"message" => "Invalid access token",
		),

		"497" => array(
			"message" => "Access token missing",
		),

		"498" => array(
			"message" => "API key missing",
		),

		"499" => array(
			"message" => "API method not found"
		),

	), $GLOBALS['cfg']['api']['errors']);

	########################################################################

	# the end
