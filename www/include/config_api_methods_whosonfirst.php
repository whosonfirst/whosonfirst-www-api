<?php

	########################################################################

	$GLOBALS['cfg']['api']['methods'] = array_merge(array(

		'whosonfirst.spelunker.search' => array(
			"description" => "",
			"documented" => 1,
			"enabled" => 1,
			"library" => "api_whosonfirst_spelunker"
		),

	), $GLOBALS['cfg']['api']['methods']);

	########################################################################

	# the end