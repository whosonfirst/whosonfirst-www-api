<?php

	########################################################################

	$GLOBALS['cfg']['api']['methods'] = array_merge(array(

		"api.spec.methods" => array (
			"description" => "Return the list of available API response methods.",
			"documented" => 1,
			"enabled" => 1,
			"library" => "api_spec",
			"disallow_formats" => array( "csv", "geojson", "meta" ),
		),

		"api.spec.errors" => array (
			"description" => "Return the list of API error responses common to all methods.",
			"documented" => 1,
			"enabled" => 1,
			"library" => "api_spec",
			"disallow_formats" => array( "csv", "geojson", "meta" ),
		),

		"api.spec.formats" => array(
			"description" => "Return the list of valid API response formats, including the default format",
			"documented" => 1,
			"enabled" => 1,
			"library" => "api_spec",
			"disallow_formats" => array( "csv", "geojson", "meta" ),
		),

		"api.test.echo" => array(
			"description" => "A testing method which echo's all parameters back in the response.",
			"documented" => 1,
			"enabled" => 1,
			"library" => "api_test",
			"disallow_formats" => array( "csv", "geojson", "meta" ),
		),

		"api.test.error" => array(
			"description" => "Return a test error from the API",
			"documented" => 1,
			"enabled" => 1,
			"library" => "api_test",
			"disallow_formats" => array( "csv", "geojson", "meta" ),
		),

	), $GLOBALS['cfg']['api']['methods']);

	########################################################################

	# the end
