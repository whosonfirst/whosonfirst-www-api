<?php

	# API errors that are common to all API method so things that are
	# typically auth and dispatch related

	# Don't conflict with this:
	# https://www.iana.org/assignments/http-status-codes/http-status-codes.xhtml

	# See also : lib_http_codes.php which this probably will conflict with...

	########################################################################

	# 432-449	reserved for individual API methods

	# 450		general (OMGWTFBBQ)
	# 452-459	query (parameters, crumbs)
	# 460-469	users
	# 475-484	API keys
	# 485-494	Access tokens
	# 495-499	API methods

	# 509		our bad

	# See this: we're using the "+" to merge these arrays because they have numeric
	# keys and PHP's default array_merge does not do the right thing... because, 
	# computers right... (20170223/thisisaaronland)
	
	$GLOBALS['cfg']['api']['errors'] = $GLOBALS['cfg']['api']['errors'] + array(

		# general

		"450" => array(
			"message" => "Unknown error.",
			"documented" => 1,
		),

		# query

		"452" => array(
			"message" => "Insufficient parameters.",
			"documented" => 1,
		),

		"453" => array(
			"message" => "Missing parameter.",
			"documented" => 1,
		),

		"454" => array(
			"message" => "Invalid parameter.",
			"documented" => 1,
		),

		# uploads

		"455" => array(
			"message" => "Invalid upload response.",
			"documented" => 0,
		),

		"456" => array(
			"message" => "Missing upload body.",
			"documented" => 0,
		),

		"457" => array(
			"message" => "Upload exceeded maximum filesize.",
			"documented" => 0,
		),

		"458" => array(
			"message" => "Invalid mime-type.",
			"documented" => 0,
		),

		# users

		"460" => array(
			"message" => "Invalid user.",
			"documented" => 0,
		),

		"461" => array(
			"message" => "User is disabled.",
			"documented" => 0,
		),

		"462" => array(
			"message" => "User is deleted.",
			"documented" => 0,
		),

		# API keys

		"478" => array(
			"message" => "Insufficient permissions for this API key.",
			"documented" => 1,
		),

		"479" => array(
			"message" => "Invalid access token for this API key.",
			"documented" => 0,
		),

		"481" => array(
			"message" => "Unauthorized host for this API key.",
			"documented" => 1,
		),

		"482" => array(
			"message" => "API key not configured for use with this method.",
			"documented" => 1,
		),

		"483" => array(
			"message" => "Invalid API key.",
			"documented" => 1,
		),

		"484" => array(
			"message" => "API key missing.",
			"documented" => 1,
		),

		# access tokens

		"490" => array(
			"message" => "Access token has insuffient permissions.",
			"documented" => 0,
		),

		"491" => array(
			"message" => "Access token is expired.",
			"documented" => 0,
		),

		"492" => array(
			"message" => "Access token is disabled.",
			"documented" => 0,
		),

		"493" => array(
			"message" => "Invalid access token.",
			"documented" => 0,
		),

		"494" => array(
			"message" => "Access token missing.",
			"documented" => 0,
		),

		# API methods

		"497" => array(
			"message" => "Output format is disallowed for this API method.",
			"documented" => 1,
		),

		"498" => array(
			"message" => "API method is disabled.",
			"documented" => 1,
		),

		"499" => array(
			"message" => "API method not found.",
			"documented" => 1,
		),

		"512" => array(
			"message" => "Something we tried to do didn't work. This is our fault, not yours.",
			"documented" => 1,
		),

	);

	########################################################################

	# the end
