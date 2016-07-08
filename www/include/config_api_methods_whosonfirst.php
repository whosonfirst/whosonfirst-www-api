<?php

	########################################################################

	$GLOBALS['cfg']['api']['methods'] = array_merge(array(

		'whosonfirst.spelunker.search' => array(
			"description" => "",
			"documented" => 1,
			"enabled" => 1,
			"library" => "api_whosonfirst_spelunker",
                        "parameters" => array(
                                array("name" => "q", "description" => "", "documented" => 1, "required" => 0),
                        ),
		),

	), $GLOBALS['cfg']['api']['methods']);

	########################################################################

	# the end