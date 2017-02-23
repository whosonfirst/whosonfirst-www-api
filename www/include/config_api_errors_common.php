<?php

	# API errors that are common to all API method so things that are
	# typically auth and dispatch related

	# Don't conflict with this:
	# https://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml

	# See also : lib_http_codes.php which this probably will conflict with...

	########################################################################

	# THIS IS INCOMPLETE AND WORK IN PROGRESS (20170222/thisisaaronland)

	# API methods
	# API keys
	# Access tokens
	# Users
	# Query parameters (incl. crumbs)
	
	$GLOBALS['cfg']['api']['errors'] = array_merge(array(

		"450" => array(
			"message" => "Unknown error",
		),

		"452" => array(
			"message" => "Insufficient parameters",
		),

		"453" => array(
			"message" => "Missing parameter",
		),

		"454" => array(
			"message" => "Invalid parameter",
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
			"message" => "Missing or invalid crumb",		# accounted for by 453/454 ?
		),

		"492" => array(
			"message" => "Invalid user",
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
			"message" => "API method is disabled"
		),

		"499" => array(
			"message" => "API method not found"
		),

	), $GLOBALS['cfg']['api']['errors']);

	########################################################################

	# the end
