<?php

	loadlib("machinetags");
	loadlib("machinetags_elasticsearch_wildcard");
	loadlib("whosonfirst_placetypes");

	########################################################################

	function api_whosonfirst_utils_validate_search_filters(){

		$placetype = request_str("placetype");
		$exclude = request_str("exclude_placetype");

		if ($placetype){
			api_whosonfirst_utils_ensure_valid_placetypes($placetype, 435);
		}

		if ($exclude){
			api_whosonfirst_utils_ensure_valid_placetypes($exclude, 435);
		}

		$min_lastmod = request_int32("min_lastmod");
		$max_lastmod = request_int32("max_lastmod");

		if (($min_lastmod) && ($min_lastmod < 0)){
			api_output_error(432);
		}

		if (($max_lastmod) && ($max_lastmod < 0)){
			api_output_error(433);
		}

		if (($min_lastmod) && ($max_lastmod)){

			if ($min_lastmod > $max_lastmod){
				api_output_error(434);
			}
		}

		if (request_isset("is_current")){

			# because request_int32 will only return an
			# unsigned integer (20170720/thisisaaronland)

			$c = request_str("is_current");

			if (! in_array($c, array("-1", "0", "1"))){
				api_output_error(400);
			}
		}

	}

	########################################################################

	function api_whosonfirst_utils_search_filters(){

		api_whosonfirst_utils_validate_search_filters();

		# it is assumed that these have been validated by now
		# see above

		$placetype = request_str("placetype");
		$exclude_placetype = request_str("exclude_placetype");

		$iso = request_str("iso");

		$is_current = request_str("is_current");

		$is_deprecated = request_str("is_deprecated");
		$is_ceased = request_str("is_ceased");

		$is_superseded = request_str("is_superseded");
		$is_superseder = request_str("is_superseder");

		$tags = request_str("tags");

		# $machinetag = request_str("mt");
		# $category = request_str("category");

		$name = request_str("name");			# wof:name
		$names = request_str("names");			# names_all

		$preferred = request_str("preferred");		# names_preferred
		$alt = request_str("alt");			# names_colloquial; names_variant

		$colloquial = request_str("colloquial");	# names_colloquial
		$variant = request_str("variant");		# names_variant

		$concordance = request_str("concordance");
		
		$country = request_int64("country_id");
		$region = request_int64("region_id");
		$locality = request_int64("locality_id");
		$neighbourhood = request_int64("neighbourhood_id");

		$exclude = request_str("exclude");
		$include = request_str("include");

		$min_lastmod = request_int32("min_lastmod");
		$max_lastmod = request_int32("max_lastmod");

		# it is assumed that these have all been validate by now
		
		$swlat = request_float("min_latitude");
		$swlon = request_float("min_longitude");
		$nelat = request_float("max_latitude");
		$nelon = request_float("max_longitude");
		
		$swlat = trim($swlat);		
		$swlon = trim($swlon);
		$nelat = trim($nelat);
		$nelon = trim($nelon);

		$nullisland = true;
		$deprecated = false;
		
		$filters = array();
		$must_not = array();

		$is_existential = false;

		foreach (array("is_current", "is_deprecated", "is_ceased") as $p){

			if (request_isset($p)){
				$is_existential = true;
				break;
			}
		}

		# TBD... (20170722/thisisaaronland)
		# if (! $is_existential){

		if ($exclude){

			$exclude = api_whosonfirst_utils_ensure_array($exclude);

			if (in_array("nullisland", $exclude)){
				$nullisland = false;
			}
		}

		if ($include){

			$include = api_whosonfirst_utils_ensure_array($include);

			if (in_array("deprecated", $include)){
				$deprecated = true;
			}
		}

		if (! $nullisland){

			$must_not[] = array('term' => array('geom:latitude' => 0.0));
			$must_not[] = array('term' => array('geom:longitude' => 0.0));	
		}

		if (! $deprecated){

			$must_not[] = array('exists' => array('field' => 'edtf:deprecated'));
		}
			
		# end of TBD... (20170722/thisisaaronland)
		# }

		if ($iso){

			$iso = api_whosonfirst_utils_ensure_array($iso);
			$iso = api_whosonfirst_utils_ensure_lower($iso);

			# this gets handled below
		}

		# is_current

		if ($is_current == "-1"){
			$filters[] = array('term' => array('mz:is_current' => -1));
		}

		else if ($is_current == "0"){
			$filters[] = array('term' => array('mz:is_current' => 0));
		} 

		else if ($is_current == "1"){
			$filters[] = array('term' => array('mz:is_current' => 1));
		}

		else {}

		# is_deprecated

		if ($is_deprecated == "0"){

			# this WILL fail - blocked on:
			# https://github.com/whosonfirst/whosonfirst-www-api/issues/60#issuecomment-317021588
			# https://github.com/whosonfirst/es-whosonfirst-schema/issues/17

			$must = array(
				array("terms" => array("edtf:deprecated" => array ("", "u", "uuuu" ) ))
			);			     

			$must_not = array();

			$filter = array('bool' => array(
				'must' => $must,
				'must_not' => $must_not,
			));

			$filters[] = $filter;
		}

		else if ($is_deprecated == "1"){

			# this WILL fail - blocked on:
			# https://github.com/whosonfirst/whosonfirst-www-api/issues/60#issuecomment-317021588
			# https://github.com/whosonfirst/es-whosonfirst-schema/issues/17

			$must = array(
			      'exists' => array( 'field' => 'edtf:deprecated' )
			);			     

			$must_not = array(
			  	array("terms" => array("edtf:deprecated" => array ("", "u", "uuuu" ) ))
			);

			$filter = array('bool' => array(
				'must' => $must,
				'must_not' => $must_not,
			));

			$filters[] = $filter;
		}

		else {}

		# is_ceased

		if ($is_ceased == "0"){

			$must = array(
				array("terms" => array("edtf:cessation" => array ("", "u", "uuuu" ) ))
			);			     

			$must_not = array();

			$filter = array('bool' => array(
				'must' => $must,
				'must_not' => $must_not,
			));

			$filters[] = $filter;
		}

		else if ($is_ceased == "1"){

			$must = array(
			      'exists' => array( 'field' => 'edtf:cessation' )
			);			     

			$must_not = array(
			  	array("terms" => array("edtf:cessation" => array ("", "u", "uuuu" ) ))
			);

			$filter = array('bool' => array(
				'must' => $must,
				'must_not' => $must_not,
			));

			$filters[] = $filter;
		}

		else {}

		# is_superseded
		# wof:superseded_by is not empty

		# is_superseder - PLEASE RENAME ME...
		# wof:supersedes is not empty

		#

		if ($placetype){

			$placetype = api_whosonfirst_utils_ensure_array($placetype);
			$count = count($placetype);

			if ($count == 1){

				$placetype = $placetype[0];
				$esc_placetype = elasticsearch_escape($placetype);
				$filters[] = array('terms' => array('wof:placetype' => array($esc_placetype)));
			}

			else {

				$esc_placetypes = array();

				foreach ($placetypes as $p){
					$esc_placetypes[] = elasticsearch_escape($p);
				}

				if (count($esc_placetypes)){
					$filters[] = array('terms' => array('wof:placetype' => $esc_placetypes));
				}
			}
		}

		if ($exclude_placetype){

			$to_exclude = api_whosonfirst_utils_ensure_array($exclude_placetype);

			$count = count($to_exclude);

			if ($count == 1){

				$to_exclude = $to_exclude[0];

				if (whosonfirst_placetypes_is_valid_placetype($to_exclude)){

					$esc_placetype = elasticsearch_escape($to_exclude);
					$must_not[] = array('terms' => array('wof:placetype' => array($esc_placetype)));
				}
			}

			else {

				$esc_placetypes = array();

				foreach ($to_exclude as $p){

					if (whosonfirst_placetypes_is_valid_placetype($p)){
						$esc_placetypes[] = elasticsearch_escape($p);
					}
				}

				if (count($esc_placetypes)){
					$must_not[] = array('terms' => array('wof:placetype' => $esc_placetypes));
				}
			}
		}

		# lastmod stuff
		# see also: https://www.elastic.co/guide/en/elasticsearch/reference/2.4/query-dsl-range-query.html

		if (($min_lastmod) && ($max_lastmod)){

			$filters[] = array("range" => array(
				"wof:lastmodified" => array("gte" => $min_lastmod, "lte" => $max_lastmod)
			));
		}

		else if ($min_lastmod){

			$now = time();

			$filters[] = array("range" => array(
				"wof:lastmodified" => array("gte" => $min_lastmod, "lte" => $now)
			));
		}

		else if ($max_lastmod){

			$now = time();

			$filters[] = array("range" => array(
				"wof:lastmodified" => array("gte" => $now, "lte" => $max_lastmod)
			));
		}

		else {}

		# TO DO: handle plain-old-tags and machinetags in one place (like here)
		# (20160708/thisisaaronland)

		$plaintags = array();
		$machinetags = array();

		if ($tags){

			$tags = api_whosonfirst_utils_ensure_array($tags);

			foreach ($tags as $t){

				$rsp = machinetags_parse_machinetag($t);

				if ($rsp['ok']){
					$machinetags[] = $rsp;
					continue;
				}

				$plaintags[] = $t;
			}
		}

		$count_plaintags = count($plaintags);
		$count_machinetags = count($plain_machinetags);

		if ($count_plaintags){

			if ($count_plaintags == 1){

				$tag = $plaintags[0];
				$esc_tag = elasticsearch_escape($tag);

				$filters[] = array('term' => array(
					'tags_all' => $esc_tag,
				));
			}

			else {

				$must = array();

				foreach ($plaintags as $t){
					$esc_t = elasticsearch_escape($t);
					$must[] = array('term' => array('tags_all' => $esc_t));
				}

				$filters[] = array('bool' => array('must' => $must));
			}
		}

		if ($count_machinetags){

			if ($count_machinetags == 1){

				$mt = $machinetags[0];

				$mt_filter = machinetags_elasticsearch_wildcard_query_filter_from_machinetag($mt);

				$filters[] = array('regexp' => array(
					'machinetags_all' => $mt_filter
				));
			}

			else {
				# PLEASE WRITE ME
			}
		}

		if (($swlat) && ($swlon) && ($nelat) && ($nelon)){

			# PLEASE WRITE ME... need to index geom:bbox I think?
			# https://github.com/whosonfirst/whosonfirst-www-api/issues/33		
			# https://github.com/whosonfirst/whosonfirst-www-api/issues/34
		}

		# TO DO: categories (20160708/thisisaaronland)

		$simple = array(
			"iso:country" => $iso,
			"names_all" => $names,
			"names_preferred" => $preferred,
			"names_alt" => $alt,
			"names_colloquial" => $colloquial,
			"names_variant" => $variant,
			"wof:name" => $name,
			"wof:hierarchy.country_id" => $country,
			"wof:hierarchy.region_id" => $region,
			"wof:hierarchy.locality_id" => $locality,
			"wof:hierarchy.neighbourhood_id" => $neighbourhood,
			"wof:concordances_sources" => $concordance,
		);

		foreach ($simple as $field => $input){

			if ($input){

				$input = api_whosonfirst_utils_ensure_array($input);
				$filters[] = api_whosonfirst_utils_enfilterify_simple($field, $input);
			}
		}
		
		if (count($must_not)){
			$filters[] = array('bool' => array('must_not' => $must_not));
		}

		return $filters;
	}
	
	########################################################################

	function api_whosonfirst_utils_enfilterify_simple($field, $terms){

		$more = array(
			"to_allow" => array()
		);

		# so that "gp:id" doesn't become "gp{:}id"

		if ($field == "wof:concordances_sources"){
			$more["to_allow"] = array(":");
		}

		if (count($terms) == 1){

			$term = $terms[0];
			$esc_term = elasticsearch_escape($term, $more);

			return array('query' => array(
				'match' => array($field => array(
					'query' => $esc_term, 'operator' => 'and'
				)
			)));
		}

		$must = array();
		
		foreach ($terms as $term){

			$esc_term = elasticsearch_escape($term, $more);
			
			$must[] = array('query' => array(
				'match' => array($field => array(
					'query' => $esc_term, 'operator' => 'and'
				)
			)));
		}

		return array('bool' => array(
			'must' => $must
		));
	}
	
	########################################################################
	
	function api_whosonfirst_utils_ensure_array($thing){

		if (! is_array($thing)){
			$thing = mb_split(";", $thing);		# maybe ?
		}

		return $thing;
	}

	########################################################################

	function api_whosonfirst_utils_ensure_lower($things){

		$count = count($things);

		for ($i = 0; $i < $count; $i++){
			$things[$i] = strtolower($things[$i]);
		}

		return $things;
	}

	########################################################################

	function api_whosonfirst_utils_get_extras(){

		$format = request_str("format");
		$extras = request_str("extras");

		if ($format == "geojson"){

			$extras = api_whosonfirst_utils_ensure_geojson_extras($extras);
		}

		return $extras;		
	}

	########################################################################

	function api_whosonfirst_utils_ensure_geojson_extras($extras){

		$extras = explode(",", $extras);

		# these are required in order to include coordinates
		# in lib_api_output_geojson
		
		$ensure_centroids = array(
			"geom:latitude", "geom:longitude",
			"lbl:latitude", "lbl:longitude",
		);

		foreach ($ensure_centroids as $ex){
		
			if (! in_array($ex, $extras)){
				$extras[] = $ex;
			}
		}

		$extras = implode(",", $extras);
		return $extras;
	}

	########################################################################

	function api_whosonfirst_utils_ensure_valid_placetypes($possible, $err_code=450){

		$possible = api_whosonfirst_utils_ensure_array($possible);

		if (count($possible) == 0){
			api_output_error($err_code);
		}

		if (count($possible) > 10){
			api_output_error($err_code);
		}

		foreach ($possible as $pt){

			if (! whosonfirst_placetypes_is_valid_placetype($pt)){
				api_output_error($err_code);
			}
		}

	}

	########################################################################

	# the end
