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

		$sizes = array();

		$min_sz = request_str("min_brand_size");
		$max_sz = request_str("max_brand_size");
		$sz = request_str("brand_size");

		$min_sz = trim($min_sz);
		$max_sz = trim($max_sz);
		$sz = trim($sz);

		if ($sz){

			if (! preg_match("/^(?:(>|<)(=)?)?(?:\s*)?([A-Z]+)$/i", $sz, $m)){
				api_output_error(432);
			}

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
		}

		if (($min_sz) && (! whosonfirst_brands_sizes_is_valid_size($min_sz))){
			api_output_error(432);
		}

		if (($max_sz) && (! whosonfirst_brands_sizes_is_valid_size($max_sz))){
			api_output_error(432);
		}

		if (($min_sz) && ($max_sz)){

			$min_details = whosonfirst_brands_sizes_get_by_size($min_sz);
			$max_details = whosonfirst_brands_sizes_get_by_size($max_sz);

			if ($min_details["max"] > $max_details["min"]){
				api_output_error(432);
			}
		}

		if ($min_sz){

			foreach (whosonfirst_brands_sizes_gt($min_sz) as $other_sz){

				# echo "compare {$max_sz} >? {$other_sz}\n";

				if (($max_sz) && (whosonfirst_brands_sizes_is_larger($max_sz, $other_sz))){
					continue;
				}

				if (! in_array($other_sz, $sizes)){
					$sizes[] = $other_sz;
				}
			}

			if (! in_array($min_sz, $sizes)){
				$sizes[] = $min_sz;
			}
		}

		if ($max_sz){

			foreach (whosonfirst_brands_sizes_lt($max_sz) as $other_sz){

				# echo "compare {$min_sz} <? {$other_sz}\n";

				if (($min_sz) && (whosonfirst_brands_sizes_is_smaller($min_sz, $other_sz))){
					continue;
				}

				if (! in_array($other_sz, $sizes)){
					$sizes[] = $other_sz;
				}
			}

			if (! in_array($max_sz, $sizes)){
				$sizes[] = $max_sz;
			}
		}

		return $sizes;
	}

	########################################################################

	# the end