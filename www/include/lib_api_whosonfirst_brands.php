<?php

	loadlib("whosonfirst_brands");

	########################################################################

	function api_whosonfirst_places_brands(){
		# please write me...
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

	# the end