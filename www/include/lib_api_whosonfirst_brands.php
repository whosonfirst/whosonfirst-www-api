<?php

	loadlib("whosonfirst_brands");
	loadlib("whosonfirst_brands_sizes");

	########################################################################

	function api_whosonfirst_brands_search(){

		$q = request_str("q");

		if (! $q){
			api_output_error(400);
		}

		$sz = api_whosonfirst_brands_ensure_brand_sizes();

		$args = array();
		api_utils_ensure_pagination_args($args);

		$rsp = whosonfirst_brands_search($q, $sz, $args);

		if (! $rsp["ok"]){
			api_output_error(500);
		}

		$rows = $rsp["rows"];
		$pagination = $rsp["pagination"];

		$out = array(
			'brands' => $rows,
		);

		api_utils_ensure_pagination_results($out, $pagination);

		$more = array(
			'key' => 'brands',
		);

		api_output_ok($out, $more);
	}

	########################################################################

	function api_whosonfirst_brands_getInfo(){

		$id = request_int64("id");

		if (! $id){
			api_output_error(432);
		}

		$brand = whosonfirst_brands_get_by_id($id);

		if (! $brand){
			api_output_error(513);
		}

		$out = array(
			'brand' => $brand 
		);

		$more = array(
			'key' => 'brand',
			'is_singleton' => 1
		);

		api_output_ok($out, $more);
	}

	########################################################################


	function api_whosonfirst_brands_getList(){

		$args = array();
		api_utils_ensure_pagination_args($args);

		$sz = api_whosonfirst_brands_ensure_brand_sizes();

		$rsp = whosonfirst_brands_get_brands($sz, $args);

		if (! $rsp["ok"]){
			api_output_error(500);
		}

		$rows = $rsp["rows"];
		$pagination = $rsp["pagination"];

		$out = array(
			'brands' => $rows,
		);

		api_utils_ensure_pagination_results($out, $pagination);

		$more = array(
			'key' => 'brands',
		);

		api_output_ok($out, $more);
	}

	########################################################################

	function api_whosonfirst_brands_ensure_brand_sizes(){

		$sz = request_str("brand_size");
		$sz = trim($sz);

		if (! preg_match("/^(?:(>|<)(=)?)?(?:\s*)?([A-Z]+)$/i", $sz, $m)){
			api_output_error(432);
		}

		$sizes = array();

		$condition = $m[1];
		$inclusive = $m[2];
		$sz = $m[3];

		if (! whosonfirst_brands_sizes_is_valid_size($sz)){
			api_output_error(432);
		}

		if ($condition == "<"){
			$sizes = whosonfirst_brands_sizes_lt($sz);
		}

		else if ($condition == ">"){
			$sizes = whosonfirst_brands_sizes_gt($sz);
		}

		else {}

		if ((! $condition) || ($inclusive)){
			$sizes[] = $sz;
		}

		return $sizes;
	}

	########################################################################

	# the end