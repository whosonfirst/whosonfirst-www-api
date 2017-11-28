<?php

	loadlib("whosonfirst_brands_sizes");

	########################################################################

	function api_whosonfirst_brands_sizes_getInfo(){

		$sz = request_str("brand_size");
		$sz = trim($sz);

		if (! $sz){
			api_output_error(432);
		}

		$details = whosonfirst_brands_sizes_get_by_size($sz);

		if (! $details){
			api_output_error(404);
		}

		$out = array(
			'size' => $details,
		);

		$more = array(
			'is_singleton' => 1,
			'key' => 'size',
		);

		api_output_ok($out);
	}

	########################################################################

	function api_whosonfirst_brands_sizes_getList(){

		$sizes = array_values($GLOBALS['whosonfirst_brands_sizes']['brands_sizes']);
		usort($sizes, "whosonfirst_brands_sizes_sort");

		$out = array(
			'sizes' => $sizes,
		);

		$more = array(
			'key' => 'sizes',
		);

		api_output_ok($out);
	}

	########################################################################

	# the end