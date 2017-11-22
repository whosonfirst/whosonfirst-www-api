<?php

	loadlib("whosonfirst_brands");

	########################################################################

	function api_whosonfirst_brands_search(){

		$q = request_str("q");

		if (! $q){
			api_output_error(400);
		}

		$args = array();
		api_utils_ensure_pagination_args($args);

		$rsp = whosonfirst_brands_search($q, $args);

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

		$rsp = whosonfirst_brands_get_brands($args);

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

	# the end