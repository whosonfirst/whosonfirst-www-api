<?php

	$GLOBALS['api_methods_whosonfirst'] = array(
		'valid_extras' => array(
			# please write me
		),
		'filter_parameters' => array(
			array("name" => "name", "description" => "Query for this value in the wof:name field.", "documented" => 1, "required" => 0),
				array("name" => "names", "description" => "Query for this value across all name related fields.", "documented" => 1, "required" => 0),
				array("name" => "alt", "description" => "Query for this value across all alternate name related fields (variant, colloquial, unknown).", "documented" => 1, "required" => 0),
				array("name" => "preferred", "description" => "Query for this value across all preferred name related fields.", "documented" => 1, "required" => 0),
				array("name" => "variant", "description" => "Query for this value across all variant name related fields.", "documented" => 1, "required" => 0),
				array("name" => "placetype", "description" => "Ensure records match this placetype.", "documented" => 1, "required" => 0),

   				array("name" => "tags", "description" => "Query for places with one or more of these tags.", "documented" => 1, "required" => 0),
				array("name" => "category", "description" => "Query for places with one or more of these categories.", "documented" => $GLOBALS['cfg']['enable_feature_categories'], "required" => 0),

				array("name" => "iso", "description" => "Ensure places belong to this (ISO) country code.", "documented" => 1, "required" => 0),
				array("name" => "country_id", "description" => "Ensure places belong to this country Who's On First ID.", "documented" => 1, "required" => 0),
				array("name" => "region_id", "description" => "Ensure places belong to this region Who's On First ID.", "documented" => 1, "required" => 0),
				array("name" => "locality_id", "description" => "Ensure places belong to this locality Who's On First ID.", "documented" => 1, "required" => 0),
				array("name" => "neighbourhood_id", "description" => "Ensure places belong to this neighbourhood Who's On First ID.", "documented" => 1, "required" => 0),
				array("name" => "concordance", "description" => "Query for places that have been concordified with this source.", "documented" => 1, "required" => 0),
				array("name" => "exclude", "description" => "Exclude places matching these criteria.", "documented" => 1, "required" => 0),
				array("name" => "include", "description" => "Include places matching these criteria.", "documented" => 1, "required" => 0),
		),
	);

	########################################################################

	$GLOBALS['cfg']['api']['methods'] = array_merge(array(

		'whosonfirst.categories.getNamespaces' => array(
			"description" => "Return the list of unique namespaces for all the categories in Who's On First.",
			"documented" => 1,
			"enabled" => $GLOBALS['cfg']['enable_feature_categories'],
			"paginated" => 1,
			"library" => "api_whosonfirst_categories",
                        "parameters" => array(
				array("name" => "source", "description" => "Limit results to categories from this source.", "documented" => 1, "required" => 0),
				array("name" => "predicate", "description" => "Limit results to categories with this predicate.", "documented" => 1, "required" => 0),
				array("name" => "value", "description" => "Limit results to categories with this value.", "documented" => 1, "required" => 0),
			),
		),

		'whosonfirst.categories.getPredicates' => array(
			"description" => "Return the list of unique predicates for all the the categories in Who's On First.",
			"documented" => 1,
			"enabled" => $GLOBALS['cfg']['enable_feature_categories'],
			"paginated" => 1,
			"library" => "api_whosonfirst_categories",
                        "parameters" => array(
				array("name" => "source", "description" => "Limit results to categories from this source.", "documented" => 1, "required" => 0),
				array("name" => "namespace", "description" => "Limit results to categories with this namespace.", "documented" => 1, "required" => 0),
				array("name" => "value", "description" => "Limit results to categories with this value.", "documented" => 1, "required" => 0),
			),
		),

		'whosonfirst.categories.getValues' => array(
			"description" => "Return the list of unique values for all the categories in Who's On First.",
			"documented" => 1,
			"enabled" => $GLOBALS['cfg']['enable_feature_categories'],
			"paginated" => 1,
			"library" => "api_whosonfirst_categories",
                        "parameters" => array(
				array("name" => "source", "description" => "Limit results to categories from this source.", "documented" => 1, "required" => 0),
				array("name" => "namespace", "description" => "Limit results to categories with this namespace.", "documented" => 1, "required" => 0),
				array("name" => "predicate", "description" => "Limit results to categories with this predicate.", "documented" => 1, "required" => 0),
			),
		),

		'whosonfirst.categories.getSources' => array(
			"description" => "Return the list of sources for all the categories in Who's On First.",
			"documented" => 1,
			"enabled" => $GLOBALS['cfg']['enable_feature_categories'],
			"paginated" => 0,
			"library" => "api_whosonfirst_categories",
                        "parameters" => array(
			),
		),

		'whosonfirst.concordances.getById' => array(
			"description" => "Lookup a Who's On First record (and all its concordances) by another source identifier.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"library" => "api_whosonfirst_concordances",
                        "parameters" => array(
				array("name" => "id", "description" => "The ID of concordance you are looking for", "documented" => 1, "required" => 1),
				array("name" => "source", "description" => "The source prefix of the concordance you are looking for", "documented" => 1, "required" => 1),
			),
		),

		'whosonfirst.concordances.getSources' => array(
			"description" => "List all the sources that Who's On First holds hands with.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"library" => "api_whosonfirst_concordances",
                        "parameters" => array(
			),
		),

		'whosonfirst.machinetags.getNamespaces' => array(
			"description" => "Return the list of unique namespaces for all the machinetags in Who's On First.",
			"documented" => 1,
			"enabled" => $GLOBALS['cfg']['enable_feature_machinetags'],
			"paginated" => 1,
			"library" => "api_whosonfirst_machinetags",
                        "parameters" => array(
				array("name" => "predicate", "description" => "Limit results to machinetags with this predicate.", "documented" => 1, "required" => 0),
				array("name" => "value", "description" => "Limit results to machinetags with this value.", "documented" => 1, "required" => 0),
			),
		),

		'whosonfirst.machinetags.getPredicates' => array(
			"description" => "Return the list of unique predicates for all the the machinetags in Who's On First",
			"documented" => 1,
			"enabled" => $GLOBALS['cfg']['enable_feature_machinetags'],
			"paginated" => 1,
			"library" => "api_whosonfirst_machinetags",
                        "parameters" => array(
				array("name" => "namespace", "description" => "Limit results to machinetags with this namespace.", "documented" => 1, "required" => 0),
				array("name" => "value", "description" => "Limit results to machinetags with this value.", "documented" => 1, "required" => 0),
			),
		),

		'whosonfirst.machinetags.getValues' => array(
			"description" => "Return the list of unique values for all the machinetags in Who's On First.",
			"documented" => 1,
			"enabled" => $GLOBALS['cfg']['enable_feature_machinetags'],
			"paginated" => 1,
			"library" => "api_whosonfirst_machinetags",
                        "parameters" => array(
				array("name" => "namespace", "description" => "Limit results to machinetags with this namespace.", "documented" => 1, "required" => 0),
				array("name" => "predicate", "description" => "Limit results to machinetags with this predicate.", "documented" => 1, "required" => 0),
			),
		),

		'whosonfirst.places.getByLatLon' => array(
			"description" => "Lookup Who's On First places intersecting a latitude and longitude",
			"documented" => 1,
			"enabled" => $GLOBALS['cfg']['enable_feature_pip'],
			"paginated" => 0,
			"extras" => 1,
			"library" => "api_whosonfirst_places",
                        "parameters" => array(
				array("name" => "latitude", "description" => "A valid latitude coordinate.", "documented" => 1, "required" => 1),
				array("name" => "longitude", "description" => "A valid longitude coordinate.", "documented" => 1, "required" => 1),
				array("name" => "placetype", "description" => "A valid Who's On First placetype to limit the query by.", "documented" => 1, "required" => 0),
			),
		),

		'whosonfirst.places.getInfo' => array(
			"description" => "Lookup a Who's On First record by ID.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 0,
			"extras" => 1,
			"library" => "api_whosonfirst_places",
                        "parameters" => array(
				array("name" => "id", "description" => "A valid Who's On First ID.", "documented" => 1, "required" => 1),
			),
		),

		'whosonfirst.places.getDescendants' => array(
			"description" => "Lookup all the descendants for a Who's On First ID.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"extras" => 1,
			"library" => "api_whosonfirst_places",
                        "parameters" => array_merge(array(
				array("name" => "id", "description" => "A valid Who's On First ID", "documented" => 1, "required" => 1),
			), $GLOBALS['api_methods_whosonfirst']['filter_parameters'])
		),

		'whosonfirst.places.getIntersects' => array(
			"description" => "Lookup all the Who's On First places intersecting a bounding box.",
			"documented" => $GLOBALS['cfg']['enable_feature_spatial_api_docs'],
			"enabled" => (($GLOBALS['cfg']['enable_feature_spatial']) && ($GLOBALS['cfg']['enable_feature_spatial_intersects'])),
			"paginated" => 1,
			"paginated_cursor" => 1,
			"extras" => 1,
			"library" => "api_whosonfirst_places",
                        "parameters" => array(
				array("name" => "min_latitude", "description" => "A valid latitude coordinate, representing the bottom (Southern) edge of the bounding box.", "documented" => 1, "required" => 1),
				array("name" => "min_longitude", "description" => "A valid longitude coordinate, representing the left (Western) edge of the bounding box.", "documented" => 1, "required" => 1),
				array("name" => "max_latitude", "description" => "A valid latitude coordinate, representing the top (Northern) edge of the bounding box.", "documented" => 1, "required" => 1),
				array("name" => "max_longitude", "description" => "A valid longitude coordinate, representing the right (Eastern) edge of the bounding box.", "documented" => 1, "required" => 1),
				array("name" => "placetype", "description" => "A valid Who's On First placetype to limit the query by.", "documented" => 1, "required" => 0),
			),
			"notes" => array(
			),
		),	

		'whosonfirst.places.getNearby' => array(
			"description" => "Lookup all the Who's On First records near a point.",
			"documented" => $GLOBALS['cfg']['enable_feature_spatial_api_docs'],
			"enabled" => (($GLOBALS['cfg']['enable_feature_spatial']) && ($GLOBALS['cfg']['enable_feature_spatial_nearby'])),
			"paginated" => 1,
			"paginated_cursor" => 1,
			"extras" => 1,
			"library" => "api_whosonfirst_places",
                        "parameters" => array(
				array("name" => "latitude", "description" => "A valid latitude coordinate.", "documented" => 1, "required" => 1),
				array("name" => "longitude", "description" => "A valid longitude coordinate.", "documented" => 1, "required" => 1),
				array("name" => "placetype", "description" => "A valid Who's On First placetype to limit the query by.", "documented" => 1, "required" => 0),
			),
			"notes" => array(
				"Pagination for this method is not supported yet.",
			),
		),	

		'whosonfirst.places.getRandom' => array(
			"description" => "Return a random Who's On First record.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 0,
			"extras" => 1,				    
			"library" => "api_whosonfirst_places",
                        "parameters" => array(
			),
		),

		'whosonfirst.places.search' => array(
			"description" => "Query for Who's On First records.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"extras" => 1,
			"library" => "api_whosonfirst_places",
                        "parameters" => array_merge(array(
                               	array("name" => "q", "description" => "Query for this value across all fields.", "documented" => 1, "required" => 0),
                       	), $GLOBALS['api_methods_whosonfirst']['filter_parameters']),
		),

		'whosonfirst.placetypes.getInfo' => array(
			"description" => "Return details for a Who's On First placetype.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 0,
			"library" => "api_whosonfirst_placetypes",
                        "parameters" => array(
                               	array("name" => "id", "description" => "A valid Who's On First placetype ID.", "documented" => 1, "required" => 0),
                               	array("name" => "name", "description" => "A valid Who's On First placetype name.", "documented" => 1, "required" => 0),
			),
			"notes" => array(
				"Although the \"id\" and \"name\" parameters are each marked as optional, you need to pass at least one of them. The order of precedence is \"id\" followed by \"name\"."
			),
		),

		'whosonfirst.placetypes.getList' => array(
			"description" => "Return a list of Who's On First placetypes.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 0,
			"library" => "api_whosonfirst_placetypes",
                        "parameters" => array(
                               	array("name" => "role", "description" => "Only return placetypes that are part of this role.", "documented" => 1, "required" => 0),
			),
		),

		'whosonfirst.placetypes.getRoles' => array(
			"description" => "Return a list of Who's On First placetype roles.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 0,
			"library" => "api_whosonfirst_placetypes",
                        "parameters" => array(
			),
		),

		'whosonfirst.tags.getTags' => array(
			"description" => "Return the list of unique tags n Who's On First.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"library" => "api_whosonfirst_tags",
                        "parameters" => array(
				array("name" => "source", "description" => "Limit results to categories from this source.", "documented" => 1, "required" => 0),
			),
		),

		'whosonfirst.tags.getSources' => array(
			"description" => "Return the list of sources for all the tags in Who's On First.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 0,
			"library" => "api_whosonfirst_tags",
                        "parameters" => array(
			),
		),

		'whosonfirst.sources.getInfo' => array(
			"description" => "Return details for a Who's On First source.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 0,
			"library" => "api_whosonfirst_sources",
                        "parameters" => array(
                               	array("name" => "id", "description" => "A valid Who's On First source ID.", "documented" => 1, "required" => 0),
                               	array("name" => "prefix", "description" => "A valid Who's On First source prefix.", "documented" => 1, "required" => 0),
			),
			"notes" => array(
				"Although the \"id\" and \"prefix\" parameters are each marked as optional, you need to pass at least one of them. The order of precedence is \"id\" followed by \"prefix\"."
			),
		),

		'whosonfirst.sources.getList' => array(
			"description" => "Return the list of Who's On First sources.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 0,
			"library" => "api_whosonfirst_sources",
                        "parameters" => array(
			),
		),

		'whosonfirst.sources.getPrefixes' => array(
			"description" => "Return the list of prefixes for all Who's On First sources.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 0,
			"library" => "api_whosonfirst_sources",
                        "parameters" => array(
			),
		),

	), $GLOBALS['cfg']['api']['methods']);

	########################################################################

	# the end
