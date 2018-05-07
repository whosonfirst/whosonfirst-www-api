<?php

	########################################################################

	$GLOBALS['cfg']['api']['methods'] = array_merge(array(

		"uploads.getInfo" => array(
			"description" => "Get information about a specific upload.",
			"documented" => 1,
			"enabled" => features_is_enabled("uploads"),
			"extras" => 0,
			"paginated" => 0,
			"library" => "api_uploads",
                        "parameters" => array(),
                        "errors" => array(),
                        "notes" => array(),
			"disallow_formats" => array( "geojson", "meta" ),
		),

		"uploads.states.getList" => array(
			"description" => "Get information about a specific upload.",
			"documented" => 1,
			"enabled" => features_is_enabled("uploads")
			"extras" => 0,
			"paginated" => 0,
			"library" => "api_uploads_states",
                        "parameters" => array(),
                        "errors" => array(),
                        "notes" => array(),
			"disallow_formats" => array( "geojson", "meta" ),
		),

	########################################################################

	# the end