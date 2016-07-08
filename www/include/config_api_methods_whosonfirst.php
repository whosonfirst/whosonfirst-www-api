<?php

	########################################################################

	$GLOBALS['cfg']['api']['methods'] = array_merge(array(

		'whosonfirst.spelunker.search' => array(
			"description" => "",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"library" => "api_whosonfirst_spelunker",
                        "parameters" => array(
                                array("name" => "q", "description" => "", "documented" => 1, "required" => 0),
                                array("name" => "name", "description" => "", "documented" => 1, "required" => 0),
                                array("name" => "names", "description" => "", "documented" => 1, "required" => 0),
                                array("name" => "alt", "description" => "", "documented" => 1, "required" => 0),
                                array("name" => "preferred", "description" => "", "documented" => 1, "required" => 0),
                                array("name" => "variant", "description" => "", "documented" => 1, "required" => 0),
                        ),
		),

	), $GLOBALS['cfg']['api']['methods']);

	########################################################################

	# the end