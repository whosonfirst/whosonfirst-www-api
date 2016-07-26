<?php

	loadlib("machinetags");
	loadlib("machinetags_elasticsearch_wildcard");

	########################################################################

	function api_whosonfirst_utils_search_filters(){

		$placetype = request_str("placetype");
		$iso = request_str("iso");

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

		$nullisland = true;
		$deprecated = false;
		
		$filters = array();
		$must_not = array();

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

		if ($iso){

			$iso = api_whosonfirst_utils_ensure_array($iso);
			$iso = api_whosonfirst_utils_ensure_lower($iso);

			# this gets handled below
		}

		# TO DO: lib_whosonfirst_placetypes - and validate

		if ($placetype){

			$placetype = api_whosonfirst_utils_ensure_array($placetype);
			$count = count($placetype);

			if ($count == 1){

				$placetype = $placetype[0];
				$esc_placetype = elasticsearch_escape($placetype);

				$filters[] = array('term' => array('wof:placetype' => $esc_placetype));
			}

			else {

				$esc_placetypes = array();

				foreach ($placetypes as $p){
					$esc_placetypes[] = elasticsearch_escape($p);
				}

				$filters[] = array('terms' => array('wof:placetype' => $esc_placetypes));
			}
		}

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

		# TO DO: categories (20160708/thisisaaronland)

		$simple = array(
			"iso:country" => $iso,
			"names_all" => $names,
			"names_preferred" => $preferred,
			"names_alt" => $alt,
			"names_colloquial" => $colloquial,
			"names_variant" => $variant,
			"wof:name" => $name,
			"country_id" => $country,
			"region_id" => $region,
			"locality_id" => $locality,
			"neighbourhood_id" => $neighbourhood,
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

		if (count($terms) == 1){

			$term = $terms[0];
			$esc_term = elasticsearch_escape($term);

			return array('query' => array(
				'match' => array($field => array(
					'query' => $esc_term, 'operator' => 'and'
				)
			)));
		}

		$must = array();
		
		foreach ($terms as $term){

			$esc_term = elasticsearch_escape($term);
			
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

	# the end