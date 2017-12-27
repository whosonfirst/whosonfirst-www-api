<?php

	loadlib("whosonfirst_brands");
	loadlib("whosonfirst_places");
	loadlib("api_whosonfirst_utils");
	loadlib("api_whosonfirst_output");

	########################################################################

	function api_whosonfirst_brands_venues_getList(){

		$brand_id = request_int64("brand_id");

		if (! $brand_id){
			api_output_error(434);
		}

		$args = array();
		api_utils_ensure_pagination_args($args);

		$brand = whosonfirst_brands_get_by_id($brand_id);

		if (! $brand){
			api_output_error(435);
		}

		# this is now a bit of misnomer since we're using it for brands...
		# (201711127/thisisaaronland)

		$filters = api_whosonfirst_utils_search_filters();

		$rsp = whosonfirst_places_get_by_brand($brand, $filters, $args);

		if (! $rsp['ok']){
			api_output_error(513);
		}

		$more = array();

		if ($extras = api_whosonfirst_utils_get_extras()){
			$more["extras"] = $extras;
		}

		api_whosonfirst_output_enpublicify($rsp['rows'], $more);
		$pagination = $rsp['pagination'];

		$out = array(
			'places' => $rsp['rows'],
		);

		if ($GLOBALS['cfg']['environment'] == 'dev'){
			$out['_query'] = $rsp['_query'];
		}

		api_utils_ensure_pagination_results($out, $pagination);

		$more = array(
			'key' => 'places',
		);

		api_output_ok($out, $more);
	}

	########################################################################

	# the end 

	