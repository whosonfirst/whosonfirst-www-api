<?php

	$GLOBALS['api_methods_whosonfirst'] = array(
		'filter_parameters' => array(
			array(
				"name" => "name",
				"description" => "Query for this value in the wof:name field.",
				"documented" => 1,
				"required" => 0,
				"example" => "Gowanus Heights"
			),
			array(
				"name" => "names",
				"description" => "Query for this value across all name related fields.",
				"documented" => 1,
				"required" => 0,
				"example" => "SF"
			),
			array(
				"name" => "alt",
				"description" => "Query for this value across all alternate name related fields (variant, colloquial, unknown).",
				"documented" => 1,
				"required" => 0,
				"example" => "Paris"
			),
			array(
				"name" => "preferred",
				"description" => "Query for this value across all preferred name related fields.",
				"documented" => 1,
				"required" => 0,
				"example" => "বেইজিং"
			),
			array(
				"name" => "variant",
				"description" => "Query for this value across all variant name related fields.",
				"documented" => 1,
				"required" => 0,
				"example" => "💩"
			),
			array(
				"name" => "placetype",
				"description" => "Ensure records match this placetype.",
				"documented" => 1,
				"required" => 0,
				"example" => "microhood",
				"notes" => "You may ensure that records include multiple placetypes by passing a ';' separated list of up to 10 placetypes, for example 'venue;neighbourhood'."
			),
			array(
				"name" => "exclude_placetype",
				"description" => "Ensure records exclude this placetype.",
				"documented" => 1,
				"required" => 0,
				"example" => "venue",
				"notes" => "You may ensure that records exclude multiple placetypes by passing a ';' separated list of up to 10 placetypes, for example 'venue;neighbourhood'."
			),
   			array(
				"name" => "tags",
				"description" => "Query for places with one or more of these tags.",
				"documented" => 1,
				"required" => 0,
				"example" => "diner"
			),
			array(
				"name" => "category",
				"description" => "Query for places with one or more of these categories.",
				"documented" => ($GLOBALS['cfg']['enable_feature_categories'] &&$GLOBALS['cfg']['environment'] == 'dev') ? 1 : 0,
				"required" => 0
			),
			array(
				"name" => "iso",
				"description" => "Ensure places belong to this (ISO) country code.",
				"documented" => 1,
				"required" => 0,
				"example" => "CA"
			),
			array(
				"name" => "country_id",
				"description" => "Ensure places belong to this country Who's On First ID.",
				"documented" => 1,
				"required" => 0,
				"example" => "85633147"
			),
			array(
				"name" => "region_id",
				"description" => "Ensure places belong to this region Who's On First ID.",
				"documented" => 1,
				"required" => 0,
				"example" => "85669831"
			),
			array(
				"name" => "locality_id",
				"description" => "Ensure places belong to this locality Who's On First ID.",
				"documented" => 1,
				"required" => 0,
				"example" => "101736545"
			),
			array(
				"name" => "neighbourhood_id",
				"description" => "Ensure places belong to this neighbourhood Who's On First ID.",
				"documented" => 1,
				"required" => 0,
				"example" => "102112179"
			),
			array(
				"name" => "brand_id",
				"description" => "Ensure places belong to this Who's On First brand ID.",
				"documented" => 1,
				"required" => 0,
				"example" => "1126128733"
			),
			array(
				"name" => "concordance",
				"description" => "Query for places that have been concordified with this source.",
				"documented" => 1,
				"required" => 0,
				"example" => "loc:id"
			),
			array(
				"name" => "is_current",
				"description" => "Filter results by their 'mz:is_current' property.",
				"documented" => 1,
				"required" => 0,
				"example" => "1"
			),
			array(
				"name" => "is_ceased",
				"description" => "Filter results to include only those places that have a valid EDTF cessation date or not. Valid options are: 1, 0",
				"documented" => 1,
				"required" => 0,
				"example" => "1"
			),
			array(
				"name" => "exclude",
				"description" => "Exclude places matching these criteria.",
				"documented" => 1,
				"required" => 0,
				"example" => "nullisland"
			),
			array(
				"name" => "include",
				"description" => "Include places matching these criteria.",
				"documented" => 1,
				"required" => 0,
				"example" => "deprecated"
			),
			array(
				"name" => "min_lastmod",
				"description" => "Limit results to places that have been modified on or since this date (encoded as a Unix timestamp).",
				"documented" => 1,
				"required" => 0,
				"example" => 1493855252
			),
			array(
				"name" => "max_lastmod",
				"description" => "Limit results to places that have been modified on or before this date (encoded as a Unix timestamp).",
				"documented" => 1,
				"required" => 0,
				"example" => 1496783757
			),
		),
	);

	########################################################################

	$GLOBALS['cfg']['api']['methods'] = array_merge(array(

		'whosonfirst.categories.getNamespaces' => array(
			"description" => "Return the list of unique namespaces for all the categories in Who's On First.",
			"documented" => 1,
			"enabled" => ($GLOBALS['cfg']['enable_feature_categories'] && $GLOBALS['cfg']['environment'] == 'dev') ? 1 : 0,
			"paginated" => 1,
			"library" => "api_whosonfirst_categories",
                        "parameters" => array(
				array("name" => "source", "description" => "Limit results to categories from this source.", "documented" => 1, "required" => 0, "x-example" => ""),
				array("name" => "predicate", "description" => "Limit results to categories with this predicate.", "documented" => 1, "required" => 0, "x-example" => ""),
				array("name" => "value", "description" => "Limit results to categories with this value.", "documented" => 1, "required" => 0, "x-example" => ""),
			),
			"errors" => array(
				"432" => array("message" => "Invalid source"),
				"513" => array("message" => "Unable to retrieve namespaces"),				
			),
			"disallow_formats" => array( "geojson", "meta" ),
		),

		'whosonfirst.categories.getPredicates' => array(
			"description" => "Return the list of unique predicates for all the the categories in Who's On First.",
			"documented" => 1,
			"enabled" => ($GLOBALS['cfg']['enable_feature_categories'] && $GLOBALS['cfg']['environment'] == 'dev') ? 1 : 0,
			"paginated" => 1,
			"library" => "api_whosonfirst_categories",
                        "parameters" => array(
				array("name" => "source", "description" => "Limit results to categories from this source.", "documented" => 1, "required" => 0, "x-example" => ""),
				array("name" => "namespace", "description" => "Limit results to categories with this namespace.", "documented" => 1, "required" => 0, "x-example" => ""),
				array("name" => "value", "description" => "Limit results to categories with this value.", "documented" => 1, "required" => 0, "x-example" => ""),
			),
			"errors" => array(
				"432" => array("message" => "Invalid source"),
				"513" => array("message" => "Unable to retrieve predicates."),				
			),
			"disallow_formats" => array( "geojson", "meta" ),
		),

		'whosonfirst.categories.getValues' => array(
			"description" => "Return the list of unique values for all the categories in Who's On First.",
			"documented" => 1,
			"enabled" => ($GLOBALS['cfg']['enable_feature_categories'] && $GLOBALS['cfg']['environment'] == 'dev') ? 1 : 0,
			"paginated" => 1,
			"library" => "api_whosonfirst_categories",
                        "parameters" => array(
				array("name" => "source", "description" => "Limit results to categories from this source.", "documented" => 1, "required" => 0, "x-example" => ""),
				array("name" => "namespace", "description" => "Limit results to categories with this namespace.", "documented" => 1, "required" => 0, "x-example" => ""),
				array("name" => "predicate", "description" => "Limit results to categories with this predicate.", "documented" => 1, "required" => 0, "x-example" => ""),
			),
			"errors" => array(
				"432" => array("message" => "Invalid source"),
				"513" => array("message" => "Unable to retrieve values"),				
			),
			"disallow_formats" => array( "geojson", "meta" ),
		),

		'whosonfirst.categories.getSources' => array(
			"description" => "Return the list of sources for all the categories in Who's On First.",
			"documented" => 1,
			"enabled" => ($GLOBALS['cfg']['enable_feature_categories'] && $GLOBALS['cfg']['environment'] == 'dev') ? 1 : 0,
			"paginated" => 0,
			"library" => "api_whosonfirst_categories",
                        "parameters" => array(),
			"errors" => array(
				"513" => array("message" => "Failed to retrieve concordances"),
			),
			"disallow_formats" => array( "geojson", "meta" ),
		),

		'whosonfirst.concordances.getById' => array(
			"description" => "Return a Who's On First record (and all its concordances) by another source identifier.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"library" => "api_whosonfirst_concordances",
                        "parameters" => array(
				array("name" => "id", "description" => "The ID of concordance you are looking for", "documented" => 1, "required" => 1, "example" => "3534"),
				array("name" => "source", "description" => "The source prefix of the concordance you are looking for", "documented" => 1, "required" => 1, "example" => "gp:id"),
			),
			"errors" => array(
				"432" => array("message" => "Missing 'id' parameter"),
				"433" => array("message" => "Missing 'source' parameter"),
				"513" => array("message" => "Failed to retrieve concordance"),
			),
			"disallow_formats" => array( "geojson", "meta" ),
		),

		'whosonfirst.concordances.getSources' => array(
			"description" => "List all the sources that Who's On First holds hands with.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"library" => "api_whosonfirst_concordances",
                        "parameters" => array(),
                        # "errors" => array(),
			"disallow_formats" => array( "geojson", "meta" ),
		),

		'whosonfirst.machinetags.getNamespaces' => array(
			"description" => "Return the list of unique namespaces for all the machinetags in Who's On First.",
			"documented" => 1,
			"enabled" => ($GLOBALS['cfg']['enable_feature_machinetags'] && $GLOBALS['cfg']['environment'] == 'dev') ? 1 : 0,
			"paginated" => 1,
			"library" => "api_whosonfirst_machinetags",
                        "parameters" => array(
				array("name" => "predicate", "description" => "Limit results to machinetags with this predicate.", "documented" => 1, "required" => 0, "x-example" => ""),
				array("name" => "value", "description" => "Limit results to machinetags with this value.", "documented" => 1, "required" => 0, "x-example" => ""),
			),
			"errors" => array(
				"513" => "Failed to retrieve machinetag namespaces",
			),
			"disallow_formats" => array( "geojson", "meta" ),
		),

		'whosonfirst.machinetags.getPredicates' => array(
			"description" => "Return the list of unique predicates for all the the machinetags in Who's On First",
			"documented" => 1,
			"enabled" => ($GLOBALS['cfg']['enable_feature_machinetags'] && $GLOBALS['cfg']['environment'] == 'dev') ? 1 : 0,
			"paginated" => 1,
			"library" => "api_whosonfirst_machinetags",
                        "parameters" => array(
				array("name" => "namespace", "description" => "Limit results to machinetags with this namespace.", "documented" => 1, "required" => 0, "x-example" => ""),
				array("name" => "value", "description" => "Limit results to machinetags with this value.", "documented" => 1, "required" => 0, "x-example" => ""),
			),
			"errors" => array(
				"513" => "Failed to retrieve machinetag predicates",
			),
			"disallow_formats" => array( "geojson", "meta" ),
		),

		'whosonfirst.machinetags.getValues' => array(
			"description" => "Return the list of unique values for all the machinetags in Who's On First.",
			"documented" => 1,
			"enabled" => ($GLOBALS['cfg']['enable_feature_machinetags'] && $GLOBALS['cfg']['environment'] == 'dev') ? 1 : 0,
			"paginated" => 1,
			"library" => "api_whosonfirst_machinetags",
                        "parameters" => array(
				array("name" => "namespace", "description" => "Limit results to machinetags with this namespace.", "documented" => 1, "required" => 0, "x-example" => ""),
				array("name" => "predicate", "description" => "Limit results to machinetags with this predicate.", "documented" => 1, "required" => 0, "x-example" => ""),
			),
			"errors" => array(
				"513" => "Failed to retrieve machinetag values",
			),
			"disallow_formats" => array( "geojson", "meta" ),
		),

		'whosonfirst.pelias.autocomplete' => array(
			"description" => "Query Who's On First using the Pelias autocomplete API",
			"documented" => 0,
			"enabled" => 1,
			"paginated" => 0,
			"extras" => 1,
			"library" => "api_whosonfirst_pelias",
                        "parameters" => array(
				array("name" => "text", "description" => "A valid query string.", "documented" => 1, "required" => 1, "example" => "Gowanu"),
			),
			"notes" => array(
				"As of this writing this API method will return zero results by design. WOF does not currently support autocomplete and this method is necessary to keep the Mapzen.JS search widget happy."
			),
			"disallow_formats" => array( "csv", "meta" ),
		),

		'whosonfirst.pelias.search' => array(
			"description" => "Query Who's On First using the Pelias API",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"pagination" => "mixed",
			"extras" => 1,
			"library" => "api_whosonfirst_pelias",
                        "parameters" => array(
				array("name" => "text", "description" => "A valid query string. This is the equivalent of the WOF 'names' parameter.", "documented" => 1, "required" => 0, "example" => "JFK"),
				array("name" => "size", "description" => "The number of results per query. This is the equivalent of the WOF 'per_page' parameter.", "documented" => 1, "required" => 0, "example" => 10),
				array("name" => "layers", "description" => "Ensure records match this placetype. This is equivalent to the WOF 'placetype' parameter.", "documented" => 1, "required" => 0, "example" => "borough"),
				array("name" => "boundary.rect.min_lat", "description" => "...", "documented" => 0, "required" => 0, "example" => "25.84"),
				array("name" => "boundary.rect.min_lon", "description" => "...", "documented" => 0, "required" => 0, "example" => "-106.65"),
				array("name" => "boundary.rect.max_lat", "description" => "...", "documented" => 0, "required" => 0, "example" => "36.5"),
				array("name" => "boundary.rect.max_lon", "description" => "...", "documented" => 0, "required" => 0, "example" => "-93.51"),				
				array("name" => "boundary.country", "description" => "Ensure places belong to this ISO country code. This is equivalent to the WOF 'iso' parameter.", "documented" => 1, "required" => 0, "example" => "ch"),				
				array("name" => "q", "description" => "A valid query string. This is the equivalent of the Pelias 'text' parameter.", "documented" => 1, "required" => 0, "example" => "JFK"),
				array("name" => "placetype", "description" => "Ensure records match this placetype. This is equivalent to the Pelias 'layers' parameter.", "documented" => 1, "required" => 0, "example" => "neighbourhood"),
				array("name" => "iso", "description" => "Ensure places belong to this ISO country code. This is equivalent to the Pelias 'boundary.country' parameter.", "documented" => 1, "required" => 0, "example" => "fr"),
				array("name" => "min_latitude", "description" => "...", "documented" => 0, "required" => 0, "example" => "25.84"),
				array("name" => "min_longitude", "description" => "...", "documented" => 0, "required" => 0, "example" => "-106.65"),
				array("name" => "max_latitude", "description" => "...", "documented" => 0, "required" => 0, "example" => "36.5"),
				array("name" => "max_longitude", "description" => "...", "documented" => 0, "required" => 0, "example" => "-93.51"),
				array("name" => "query_field", "description" => "Scope the query alternate names (alt), variant names (variant), preferred names (preferred), wof:name values (name) or all the names (names). Valid options are: alt, name, names, preferred, variant. If left empty then the query will be performed across all WOF properties.", "documented" => 1, "required" => 0, "example" => "alt"),
			),
			"errors" => array(
				"432" => array("message" => "Unsupported Pelias API parameter"),
				"433" => array("message" => "Multiple placetypes not supported (yet)"),
				"434" => array("message" => "Invalid placetype"),				
				"435" => array("message" => "Invalid 'min_latitude' parameter"),
				"436" => array("message" => "Invalid 'max_longitude' parameter"),
				"437" => array("message" => "Invalid 'max_latitude' parameter"),
				"438" => array("message" => "Invalid 'max_longitude' parameter"),
				"439" => array("message" => "One or more missing parameters in bounding box query"),
				"440" => array("message" => "Invalid output format"),
				"441" => array("message" => "Invalid Pelias API version"),
				"442" => array("message" => "Invalid (WOF) query field"),
				"513" => array("message" => "Failed to perform lookup"),
			),
			"notes" => array(
				"Although neither the 'text' or 'q' parameters are required individually you must pass at least one of them.",
				"If both a Pelias API and its equivalent WOF parameter are passed the WOF parameter will take precendence. For example if you search for '?text=JFK&q=poutine' the API will only search for 'poutine'.",
				"The following Pelias API parameters are currently unsupported: boundary.circle.lat, boundary.circle.lon, boundary.circle.radius, boundary.rect.min_lat, boundary.rect.min_lon, boundary.rect.max_lat, boundary.rect.max_lon, focus.point.lat, focus.point.lon, sources",
			),
			"disallow_formats" => array( "csv", "meta" ),
		),
		
		'whosonfirst.places.getByLatLon' => array(
			"description" => "Return Who's On First places intersecting a latitude and longitude",
			"documented" => 1,
			"enabled" => $GLOBALS['cfg']['enable_feature_pip'],
			"paginated" => 0,
			"pagination" => "cursor",
			"extras" => 1,
			"library" => "api_whosonfirst_places",
                        "parameters" => array(
				array("name" => "latitude", "description" => "A valid latitude coordinate.", "documented" => 1, "required" => 1, "example" => "37.766633"),
				array("name" => "longitude", "description" => "A valid longitude coordinate.", "documented" => 1, "required" => 1, "example" => "-122.417693"),
				array("name" => "placetype", "description" => "A valid Who's On First placetype to limit the query by.", "documented" => 1, "required" => 0, "example" => "neighbourhood"),
			),
			"errors" => array(
				"432" => array("message" => "Missing 'latitude' parameter"),
				"433" => array("message" => "Missing 'longitude' parameter"),
				"434" => array("message" => "Invalid 'latitude' parameter"),
				"435" => array("message" => "Invalid 'longitude' parameter"),
				"436" => array("message" => "Invalid placetype"),
				"513" => array("message" => "Failed to perform lookup"),
			),
			"notes" => array(
				"This method differs from the whosonfirst.places.getAncestorsByLatLon method in two ways: 1. It returns a list of WOF places rather than hierarchies and 2. If a placetype filter is specified and no matching records are found no attempt will be made to find ancestors higher up the hierarchy. For example looking for an intersecting county or region if no locality is found."
			)
		),

		'whosonfirst.places.getHierarchiesByLatLon' => array(
			"description" => "Return the closest set of ancestors (hierarchies) for a latitude and longitude",
			"documented" => 1,
			"enabled" => $GLOBALS['cfg']['enable_feature_pip'],
			"paginated" => 0,
			"extras" => 1,
			"library" => "api_whosonfirst_places",
                        "parameters" => array(
				array("name" => "latitude", "description" => "A valid latitude coordinate.", "documented" => 1, "required" => 1, "example" => "37.777228"),
				array("name" => "longitude", "description" => "A valid longitude coordinate.", "documented" => 1, "required" => 1, "example" => "-122.470779"),
				array("name" => "placetype", "description" => "Skip descendants of this placetype.", "documented" => 1, "required" => 0, "example" => "region"),
				array("name" => "spr", "description" => "Format results as a standard place response (spr).", "documented" => 1, "required" => 0, "example" => 1),
			),
			"errors" => array(
				"432" => array("message" => "Missing 'latitude' parameter"),
				"433" => array("message" => "Missing 'longitude' parameter"),
				"434" => array("message" => "Invalid 'latitude' parameter"),
				"435" => array("message" => "Invalid 'longitude' parameter"),
				"436" => array("message" => "Invalid placetype"),
				"513" => array("message" => "Failed to perform lookup"),
				"514" => array("message" => "Failed to perform standard place response (spr) lookup"),
			),
			"notes" => array(
				"This method differs from whosonfirst.places.getByLatLon method in two ways: 1. It returns a list of hierarchies rather than a WOF place record and 2. It will travel up the hierarchy until an ancestor is found. For example even if there is no locality matching a given lat, lon the code will try again looking for a matching region, and so on.",
				"The 'extras' parameter is only honoured when the 'spr' parameter is present."
			),
			"disallow_formats" => array( "meta" ),
		),

		'whosonfirst.places.getParentByLatLon' => array(
			"description" => "Return Who's On First parent ID for a latitude and longitude and placetype",
			"documented" => 1,
			"enabled" => $GLOBALS['cfg']['enable_feature_pip'],
			"paginated" => 0,
			"experimental" => 1,
			"extras" => 0,
			"library" => "api_whosonfirst_places",
                        "parameters" => array(
				array("name" => "latitude", "description" => "A valid latitude coordinate.", "documented" => 1, "required" => 1, "example" => "35.655065"),
				array("name" => "longitude", "description" => "A valid longitude coordinate.", "documented" => 1, "required" => 1, "example" => "139.369640"),
				array("name" => "placetype", "description" => "A valid Who's On First placetype to limit the query by.", "documented" => 1, "required" => 1, "example" => "neighbourhood"),
			),
			"errors" => array(
				"432" => array("message" => "Missing 'latitude' parameter"),
				"433" => array("message" => "Missing 'longitude' parameter"),
				"434" => array("message" => "Invalid 'latitude' parameter"),
				"435" => array("message" => "Invalid 'longitude' parameter"),
				"436" => array("message" => "Missing 'placetype' parameter"),
				"437" => array("message" => "Invalid placetype"),
				"513" => array("message" => "Failed to perform lookup"),
			),
			"notes" => array(
				"The inability to locate (or to disambiguate) a parent ID for a lat, lon will not trigger an API error. The following parent IDs may be returned by this API method: '-1' which means that a parent ID could not be identified or that there are multiple choices; or '-3' which means that the parent is a neighbourhood and their are multiple possible choices and you should go out for a beer and argue over which is the correct parent.",
			),
			"disallow_formats" => array( "meta" ),
		),

		'whosonfirst.places.getInfo' => array(
			"description" => "Return a Who's On First record by ID.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 0,
			"extras" => 1,
			"library" => "api_whosonfirst_places",
                        "parameters" => array(
				array("name" => "id", "description" => "A valid Who's On First ID.", "documented" => 1, "required" => 1, "example" => "420561633"),
			),
			"errors" => array(
				"432" => array("message" => "Missing 'id' parameter"),
				"513" => array("message" => "Unable to retrieve place"),
			)
		),

		'whosonfirst.places.getInfoMulti' => array(
			"description" => "Return multiple Who's On First records by ID.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 0,
			"extras" => 1,
			"library" => "api_whosonfirst_places",
                        "parameters" => array(
				array("name" => "ids", "description" => "A comma separated list of valid Who's On First ID. A maximum of 20 WOF IDs may be specified.", "documented" => 1, "required" => 1, "example" => "101712565,101712563"),
			),
			"errors" => array(
				"432" => array("message" => "Missing 'ids' parameter"),
				"433" => array("message" => "Maximum number of WOF IDs exceeded"),
				"513" => array("message" => "Unable to retrieve places"),
			)
		),

		'whosonfirst.places.getDescendants' => array(
			"description" => "Return all the descendants for a Who's On First ID.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"pagination" => "mixed",
			"extras" => 1,
			"library" => "api_whosonfirst_places",
                        "parameters" => array_merge(array(
				array("name" => "id", "description" => "A valid Who's On First ID", "documented" => 1, "required" => 1, "example" => "420780703"),
			), $GLOBALS['api_methods_whosonfirst']['filter_parameters']),
			"errors" => array(
				"432" => array("message" => "Missing 'id' parameter"),
				"513" => array("message" => "Unable to retrieve descendants"),
			)
		),

		'whosonfirst.places.getIntersects' => array(
			"description" => "Return all the Who's On First places intersecting a bounding box.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"paginated_cursor" => 1,
			"pagination" => "cursor",
			"extras" => 1,
			"library" => "api_whosonfirst_places",
                        "parameters" => array(
				array("name" => "min_latitude", "description" => "A valid latitude coordinate, representing the bottom (Southern) edge of the bounding box.", "documented" => 1, "required" => 1, "example" => "37.78807088"),
				array("name" => "min_longitude", "description" => "A valid longitude coordinate, representing the left (Western) edge of the bounding box.", "documented" => 1, "required" => 1, "example" => "-122.34374508"),
				array("name" => "max_latitude", "description" => "A valid latitude coordinate, representing the top (Northern) edge of the bounding box.", "documented" => 1, "required" => 1, "example" => "37.85749665"),
				array("name" => "max_longitude", "description" => "A valid longitude coordinate, representing the right (Eastern) edge of the bounding box.", "documented" => 1, "required" => 1, "example" => "-122.25585446"),
				array("name" => "placetype", "description" => "A valid Who's On First placetype to limit the query by.", "documented" => 1, "required" => 0, "example" => "locality"),
			),
			"errors" => array(
				"432" => array("message" => "Missing 'min_latitude' parameter"),
				"433" => array("message" => "Missing 'min_longitude' parameter"),
				"434" => array("message" => "Missing 'max_latitude' parameter"),
				"435" => array("message" => "Missing 'max_longitude' parameter"),
				"436" => array("message" => "Invalid 'min_latitude' parameter"),
				"437" => array("message" => "Invalid 'min_longitude' parameter"),
				"438" => array("message" => "Invalid 'max_latitude' parameter"),
				"439" => array("message" => "Invalid 'max_longitude' parameter"),
				"513" => array("message" => "Failed to intersect"),

			),
			"notes" => array(),
		),	

		'whosonfirst.places.getNearby' => array(
			"description" => "Return all the Who's On First records near a point.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"pagination" => "cursor",
			"extras" => 1,
			"library" => "api_whosonfirst_places",
                        "parameters" => array(
				array("name" => "latitude", "description" => "A valid latitude coordinate.", "documented" => 1, "required" => 1, "example" => "40.784165"),
				array("name" => "longitude", "description" => "A valid longitude coordinate.", "documented" => 1, "required" => 1, "example" => "-73.958110"),
				array("name" => "placetype", "description" => "A valid Who's On First placetype to limit the query by.", "documented" => 1, "required" => 0, "example" => "venue"),
				array("name" => "radius", "description" => "A valid radius (in meters) to limit the query by. Default radius is 100. Maximum radius is 500.", "documented" => 1, "required" => 0, "example" => 25, "default" => 100, "max" => 500),
			),
			"errors" => array(
				"432" => array("message" => "Missing 'latitude' parameter"),
				"433" => array("message" => "Missing 'longitude' parameter"),
				"434" => array("message" => "Invalid 'latitude' parameter"),
				"435" => array("message" => "Invalid 'longitude' parameter"),
				"436" => array("message" => "Invalid radius"),
				"437" => array("message" => "Invalid placetype"),
				"513" => array("message" => "Failed to get nearby"),
			),
			"notes" => array(
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
			"errors" => array(
				"513" => array("message" => "Unable to retrieve random place."),
			),
		),

		'whosonfirst.places.search' => array(
			"description" => "Query for Who's On First records.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"pagination" => "mixed",
			"extras" => 1,
			"library" => "api_whosonfirst_places",
                        "parameters" => array_merge(array(
                               	array("name" => "q", "description" => "Query for this value across all fields.", "documented" => 1, "required" => 0, "example" => "poutine"),
                       	), $GLOBALS['api_methods_whosonfirst']['filter_parameters']),
			"errors" => array(
				"432" => array("message" => "Invalid minimum lastmodified date"),
				"433" => array("message" => "Invalid maximum lastmodified date"),
				"434" => array("message" => "Impossible date range"),
				"435" => array("message" => "Invalid placetype"),
				"513" => array("message" => "Unable to perform search"),
			)
		),

		'whosonfirst.placetypes.getInfo' => array(
			"description" => "Return details for a Who's On First placetype.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 0,
			"library" => "api_whosonfirst_placetypes",
                        "parameters" => array(
                               	array("name" => "id", "description" => "A valid Who's On First placetype ID.", "documented" => 1, "required" => 0, "example" => "102322043"),
                               	array("name" => "name", "description" => "A valid Who's On First placetype name.", "documented" => 1, "required" => 0, "example" => "disputed"),
			),
			"notes" => array(
				"Although the \"id\" and \"name\" parameters are each marked as optional, you need to pass at least one of them. The order of precedence is \"id\" followed by \"name\"."
			),
			"errors" => array(
				"432" => array("message" => "Invalid place ID"),
				"433" => array("message" => "Invalid place name"),
			),
			"disallow_formats" => array( "meta" ),
		),

		'whosonfirst.placetypes.getList' => array(
			"description" => "Return a list of Who's On First placetypes.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 0,
			"library" => "api_whosonfirst_placetypes",
                        "parameters" => array(
                               	array("name" => "role", "description" => "Only return placetypes that are part of this role.", "documented" => 1, "required" => 0, "example" => "common"),
			),
			"errors" => array(
				"432" => array("message" => "Invalid role"),
			),
			"disallow_formats" => array( "geojson", "meta" ),
		),

		'whosonfirst.placetypes.getRoles' => array(
			"description" => "Return a list of Who's On First placetype roles.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 0,
			"library" => "api_whosonfirst_placetypes",
                        "parameters" => array(),
			"errors" => array(),
			"notes" => array(),
			"disallow_formats" => array( "geojson", "meta" ),
		),

		'whosonfirst.repos.getByLatLon' => array(
			"description" => "Return a Who's On First repo name for a latitude and longitude.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 0,
			"library" => "api_whosonfirst_repos",
                        "parameters" => array(
				array("name" => "latitude", "description" => "A valid latitude coordinate.", "documented" => 1, "required" => 1, "example" => "37.766633"),
				array("name" => "longitude", "description" => "A valid longitude coordinate.", "documented" => 1, "required" => 1, "example" => "-122.417693"),
				array("name" => "placetype", "description" => "A valid Who's On First placetype to limit the query by.", "documented" => 1, "required" => 0, "example" => "venue"),
			),
			"errors" => array(
				"432" => array("message" => "Missing 'latitude' parameter"),
				"433" => array("message" => "Missing 'longitude' parameter"),
				"434" => array("message" => "Invalid 'latitude' parameter"),
				"435" => array("message" => "Invalid 'longitude' parameter"),
				"436" => array("message" => "Missing 'placetype' parameter"),
				"437" => array("message" => "Invalid placetype"),
				"513" => array("message" => "Failed to perform point-in-polygon lookup"),
				"514" => array("message" => "Failed to locate any places"),
				"515" => array("message" => "Too many places to choose from."),
				"516" => array("message" => "Missing iso:country property!"),
				"517" => array("message" => "Missing unlc:subdivision property!"),
				"518" => array("message" => "Invalid unlc:subdivision property."),
			),
			"notes" => array(
			),
			"disallow_formats" => array( "geojson", "meta" ),
		),

		'whosonfirst.sources.getInfo' => array(
			"description" => "Return details for a Who's On First source.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 0,
			"library" => "api_whosonfirst_sources",
                        "parameters" => array(
                               	array("name" => "id", "description" => "A valid Who's On First source ID.", "documented" => 1, "required" => 0, "example" => "840464301"),
                               	array("name" => "prefix", "description" => "A valid Who's On First source prefix.", "documented" => 1, "required" => 0, "example" => "loc"),
			),
			"errors" => array(
				"432" => array("message" => "Invalid source ID"),
				"433" => array("message" => "Invalid source prefix"),
			),
			"notes" => array(
				"Although the \"id\" and \"prefix\" parameters are each marked as optional, you need to pass at least one of them. The order of precedence is \"id\" followed by \"prefix\"."
			),
			"disallow_formats" => array( "geojson", "meta" ),
		),

		'whosonfirst.sources.getList' => array(
			"description" => "Return the list of Who's On First sources.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 0,
			"library" => "api_whosonfirst_sources",
                        "parameters" => array(),
                        "errors" => array(),
                        "notes" => array(),
			"disallow_formats" => array( "geojson", "meta" ),
		),

		'whosonfirst.sources.getPrefixes' => array(
			"description" => "Return the list of prefixes for all Who's On First sources.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 0,
			"library" => "api_whosonfirst_sources",
                        "parameters" => array(),
                        "errors" => array(),
                        "notes" => array(),
			"disallow_formats" => array( "geojson", "meta" ),
		),

		'whosonfirst.tags.getTags' => array(
			"description" => "Return the list of unique tags n Who's On First.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 1,
			"library" => "api_whosonfirst_tags",
                        "parameters" => array(
				array("name" => "source", "description" => "Limit results to categories from this source.", "documented" => 1, "required" => 0, "example" => "wof"),
			),
                        "errors" => array(
				"432" => array("message" => "Invalid source"),
				"513" => array("message" => "Unable to retrieve tags"),
			),
                        "notes" => array(),
			"disallow_formats" => array( "geojson", "meta" ),
		),

		'whosonfirst.tags.getSources' => array(
			"description" => "Return the list of sources for all the tags in Who's On First.",
			"documented" => 1,
			"enabled" => 1,
			"paginated" => 0,
			"library" => "api_whosonfirst_tags",
                        "parameters" => array(),
                        "errors" => array(),
                        "notes" => array(),
			"disallow_formats" => array( "geojson", "meta" ),
		),

	), $GLOBALS['cfg']['api']['methods']);

	########################################################################

	# the end
