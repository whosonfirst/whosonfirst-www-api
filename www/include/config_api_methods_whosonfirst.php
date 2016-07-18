<?php

	########################################################################

	$GLOBALS['cfg']['api']['methods'] = array_merge(array(

		'whosonfirst.concordances.getById' => array(
			"description" => "Lookup a Who's On First record (and all its concordances) by another source identifier",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"library" => "api_whosonfirst_concordances",
                        "parameters" => array(
				array("name" => "id", "description" => "", "documented" => 1, "required" => 1),
				array("name" => "source", "description" => "", "documented" => 1, "required" => 1),
			),
		),

		'whosonfirst.spelunker.search' => array(
			"description" => "Query for Who's On First records.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"library" => "api_whosonfirst_spelunker",
                        "parameters" => array(
                                array("name" => "q", "description" => "query for this value across all fields", "documented" => 1, "required" => 0),
                                array("name" => "name", "description" => "query for this value in the wof:name field", "documented" => 1, "required" => 0),
                                array("name" => "names", "description" => "query for this value across all name related fields", "documented" => 1, "required" => 0),
                                array("name" => "alt", "description" => "query for this value across all alternate name related fields (variant, colloquial, unknown)", "documented" => 1, "required" => 0),
                                array("name" => "preferred", "description" => "query for this value across all preferred name related fields", "documented" => 1, "required" => 0),
                                array("name" => "variant", "description" => "query for this value across all variant name related fields", "documented" => 1, "required" => 0),
                                array("name" => "placetype", "description" => "ensure records match this placetype", "documented" => 1, "required" => 0),

   				array("name" => "tags", "description" => "", "documented" => 1, "required" => 0),
                                # array("name" => "category", "description" => "", "documented" => 1, "required" => 0),

                                array("name" => "iso", "description" => "ensure records belong to this (ISO) country code", "documented" => 1, "required" => 0),
                                array("name" => "country_id", "description" => "ensure records belong to this country Who's On First ID", "documented" => 1, "required" => 0),
                                array("name" => "region_id", "description" => "ensure records belong to this region Who's On First ID", "documented" => 1, "required" => 0),
                                array("name" => "locality_id", "description" => "ensure records belong to this locality Who's On First ID", "documented" => 1, "required" => 0),
                                array("name" => "neighbourhood_id", "description" => "ensure records belong to this neighbourhood Who's On First ID", "documented" => 1, "required" => 0),
                                array("name" => "concordance", "description" => "query for records that have been concordified with this source", "documented" => 1, "required" => 0),
                                array("name" => "exclude", "description" => "exclude records matching these criteria", "documented" => 1, "required" => 0),
                                array("name" => "include", "description" => "include records matching these criteria", "documented" => 1, "required" => 0),
                        ),
		),

	), $GLOBALS['cfg']['api']['methods']);

	########################################################################

	# the end