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
			"message" => "Unknown error",
		),

		# query

		"452" => array(
			"message" => "Insufficient parameters",
		),

		"453" => array(
			"message" => "Missing parameter",
		),

		"454" => array(
			"message" => "Invalid parameter",
		),

		# uploads

		"455" => array(
			"message" => "Invalid upload response"
		),

		"456" => array(
			"message" => "Missing upload body"
		),

		"457" => array(
			"message" => "Upload exceeded maximum filesize"
		),

		"458" => array(
			"message" => "Invalid mime-type"
		),

		# users

		"460" => array(
			"message" => "Invalid user",
		),

		"461" => array(
			"message" => "User is disabled",
		),

		"462" => array(
			"message" => "User is deleted",
		),

		# API keys

		"478" => array(
			"message" => "Insufficient permissions for this API key",
		),

		"479" => array(
			"message" => "Invalid access token for this API key",
		),

		"481" => array(
			"message" => "Unauthorized host for this API key",
		),

		"482" => array(
			"message" => "API key not configured for use with this method",
		),

		"483" => array(
			"message" => "Invalid API key",
		),

		"484" => array(
			"message" => "API key missing",
		),

		# access tokens

		"490" => array(
			"message" => "Access token has insuffient permissions",
		),

		"491" => array(
			"message" => "Access token is expired",
		),

		"492" => array(
			"message" => "Access token is disabled",
		),

		"493" => array(
			"message" => "Invalid access token",
		),

		"494" => array(
			"message" => "Access token missing",
		),

		# API methods

		"498" => array(
			"message" => "API method is disabled"
		),

		"499" => array(
			"message" => "API method not found"
		),

		"512" => array(
			"message" => "Something we tried to do didn't work. This is our fault, not yours."
		),

	);

	########################################################################

	# the end
