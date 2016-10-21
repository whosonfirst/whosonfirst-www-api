<?php

	$GLOBALS['api_methods_whosonfirst'] = array(
		'filter_parameters' => array(
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
	);

	########################################################################

	$GLOBALS['cfg']['api']['methods'] = array_merge(array(

		'whosonfirst.categories.getNamespaces' => array(
			"description" => "Return the list of unique namespaces for all the categories in Who's On First",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"library" => "api_whosonfirst_categories",
                        "parameters" => array(
				array("name" => "source", "description" => "Limit results to categories from this source", "documented" => 1, "required" => 0),
				array("name" => "predicate", "description" => "Limit results to categories with this predicate", "documented" => 1, "required" => 0),
				array("name" => "value", "description" => "Limit results to categories with this value", "documented" => 1, "required" => 0),
			),
		),

		'whosonfirst.categories.getPredicates' => array(
			"description" => "Return the list of unique predicates for all the the categories in Who's On First",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"library" => "api_whosonfirst_categories",
                        "parameters" => array(
				array("name" => "source", "description" => "Limit results to categories from this source", "documented" => 1, "required" => 0),
				array("name" => "namespace", "description" => "Limit results to categories with this namespace", "documented" => 1, "required" => 0),
				array("name" => "value", "description" => "Limit results to categories with this value", "documented" => 1, "required" => 0),
			),
		),

		'whosonfirst.categories.getValues' => array(
			"description" => "Return the list of unique values for all the categories in Who's On First",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"library" => "api_whosonfirst_categories",
                        "parameters" => array(
				array("name" => "source", "description" => "Limit results to categories from this source", "documented" => 1, "required" => 0),
				array("name" => "namespace", "description" => "Limit results to categories with this namespace", "documented" => 1, "required" => 0),
				array("name" => "predicate", "description" => "Limit results to categories with this predicate", "documented" => 1, "required" => 0),
			),
		),

		'whosonfirst.categories.getSources' => array(
			"description" => "Return the list of sources for all the categories in Who's On First",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 0,
			"library" => "api_whosonfirst_categories",
                        "parameters" => array(
			),
		),

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

		'whosonfirst.concordances.getSources' => array(
			"description" => "List all the sources that Who's On First holds hands with",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"library" => "api_whosonfirst_concordances",
                        "parameters" => array(
			),
		),

		'whosonfirst.machinetags.getNamespaces' => array(
			"description" => "Return the list of unique namespaces for all the machinetags in Who's On First",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"library" => "api_whosonfirst_machinetags",
                        "parameters" => array(
				array("name" => "predicate", "description" => "Limit results to machinetags with this predicate", "documented" => 1, "required" => 0),
				array("name" => "value", "description" => "Limit results to machinetags with this value", "documented" => 1, "required" => 0),
			),
		),

		'whosonfirst.machinetags.getPredicates' => array(
			"description" => "Return the list of unique predicates for all the the machinetags in Who's On First",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"library" => "api_whosonfirst_machinetags",
                        "parameters" => array(
				array("name" => "namespace", "description" => "Limit results to machinetags with this namespace", "documented" => 1, "required" => 0),
				array("name" => "value", "description" => "Limit results to machinetags with this value", "documented" => 1, "required" => 0),
			),
		),

		'whosonfirst.machinetags.getValues' => array(
			"description" => "Return the list of unique values for all the machinetags in Who's On First",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"library" => "api_whosonfirst_machinetags",
                        "parameters" => array(
				array("name" => "namespace", "description" => "Limit results to machinetags with this namespace", "documented" => 1, "required" => 0),
				array("name" => "predicate", "description" => "Limit results to machinetags with this predicate", "documented" => 1, "required" => 0),
			),
		),

		'whosonfirst.places.getInfo' => array(
			"description" => "Lookup a Who's On First record",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 0,
			"library" => "api_whosonfirst_places",
                        "parameters" => array(
				array("name" => "id", "description" => "", "documented" => 1, "required" => 1),
                               	array("name" => "extras", "description" => "comma-separated list of additional fields to include in results", "documented" => 1, "required" => 0),
			),
		),

		'whosonfirst.places.getDescendants' => array(
			"description" => "Lookup all the descendants Who's On First record",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"library" => "api_whosonfirst_places",
                        "parameters" => array_merge(array(
				array("name" => "id", "description" => "", "documented" => 1, "required" => 1),
                               	array("name" => "extras", "description" => "comma-separated list of additional fields to include in results", "documented" => 1, "required" => 0),
			), $GLOBALS['api_methods_whosonfirst']['filter_parameters'])
		),

		'whosonfirst.places.getIntersects' => array(
			"description" => "Lookup all the Who's On First records intersecting a bounding box",
			"documented" => 1,
			"enabled" => (($GLOBALS['cfg']['enable_feature_spatial']) && ($GLOBALS['cfg']['enable_feature_spatial_intersects'])),
			"paginated" => 0,
			"library" => "api_whosonfirst_places",
                        "parameters" => array(
				array("name" => "min_latitude", "description" => "", "documented" => 1, "required" => 1),
				array("name" => "min_longitude", "description" => "", "documented" => 1, "required" => 1),
				array("name" => "max_latitude", "description" => "", "documented" => 1, "required" => 1),
				array("name" => "max_longitude", "description" => "", "documented" => 1, "required" => 1),
				array("name" => "placetype", "description" => "", "documented" => 1, "required" => 0),
				array("name" => "cursor", "description" => "", "documented" => 1, "required" => 0),
                               	array("name" => "extras", "description" => "comma-separated list of additional fields to include in results", "documented" => 1, "required" => 0),
			),
			"notes" => array(
				"Pagination is a cursor (because we can't have nice things).",
				"Extras are not fully supported for this method yet."
			),
		),	

		'whosonfirst.places.getNearby' => array(
			"description" => "Lookup all the Who's On First records near a point",
			"documented" => 1,
			"enabled" => (($GLOBALS['cfg']['enable_feature_spatial']) && ($GLOBALS['cfg']['enable_feature_spatial_nearby'])),
			"paginated" => 0,
			"library" => "api_whosonfirst_places",
                        "parameters" => array(
				array("name" => "latitude", "description" => "", "documented" => 1, "required" => 1),
				array("name" => "longitude", "description" => "", "documented" => 1, "required" => 1),
				array("name" => "placetype", "description" => "", "documented" => 1, "required" => 0),
				array("name" => "cursor", "description" => "", "documented" => 1, "required" => 0),
				array("name" => "extras", "description" => "comma-separated list of additional fields to include in results", "documented" => 1, "required" => 0),
			),
			"notes" => array(
				"Pagination for this method is not supported yet.",
				"Extras are not fully supported for this method yet."
			),
		),	

		'whosonfirst.places.getRandom' => array(
			"description" => "Return a random Who's On First record",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 0,
			"library" => "api_whosonfirst_places",
                        "parameters" => array(
                               	array("name" => "extras", "description" => "comma-separated list of additional fields to include in results", "documented" => 1, "required" => 0),
			),
		),

		'whosonfirst.places.search' => array(
			"description" => "Query for Who's On First records.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"library" => "api_whosonfirst_places",
                        "parameters" => array_merge(array(
                               	array("name" => "q", "description" => "query for this value across all fields", "documented" => 1, "required" => 0),
                               	array("name" => "extras", "description" => "comma-separated list of additional fields to include in results", "documented" => 1, "required" => 0),
                       	), $GLOBALS['api_methods_whosonfirst']['filter_parameters']),
		),

		'whosonfirst.tags.getTags' => array(
			"description" => "Return the list of unique tags n Who's On First",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"library" => "api_whosonfirst_tags",
                        "parameters" => array(
				array("name" => "source", "description" => "Limit results to categories from this source", "documented" => 1, "required" => 0),
			),
		),

		'whosonfirst.tags.getSources' => array(
			"description" => "Return the list of sources for all the tags in Who's On First",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 0,
			"library" => "api_whosonfirst_tags",
                        "parameters" => array(
			),
		),

	), $GLOBALS['cfg']['api']['methods']);

	########################################################################

	# the end
