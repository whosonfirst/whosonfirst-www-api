<?php

	# this file was cloned from https://github.com/whosonfirst/flamework-whosonfirst/

	########################################################################
	
	loadlib("whosonfirst_brands_sizes_spec");

	########################################################################

	# Hey look! Running code!! (20171127/thisisaaronland)

	$GLOBALS['whosonfirst_brands_sizes']['spec'] = json_decode($GLOBALS['whosonfirst_brands_sizes']['__SPEC__'], "as hash");

	if (! $GLOBALS['whosonfirst_brands_sizes']['spec']){
		log_fatal("failed to parse brand sizes spec");
	}

	# Hey look! More running code!!! (20171127/thisisaaronland)
	
	$GLOBALS['whosonfirst_brands_sizes']['brands_sizes_by_id'] = array();
	$GLOBALS['whosonfirst_brands_sizes']['brands_sizes'] = array();

	foreach ($GLOBALS['whosonfirst_brands_sizes']['spec'] as $id => $details){

		$sz = $details['size'];

		$GLOBALS['whosonfirst_brands_sizes']['brands_sizes_by_id'][$id] = $sz;
		$GLOBALS['whosonfirst_brands_sizes']['brands_sizes'][$sz] = $details;
	}

	########################################################################

	function whosonfirst_brands_sizes_is_valid_size($sz){

		$sz = strtoupper($sz);
		return isset($GLOBALS['whosonfirst_brands_sizes']['brands_sizes'][$sz]);
	}

	########################################################################

	function whosonfirst_brands_sizes_get_by_size($sz){

		$sz = strtoupper($sz);

		if (! whosonfirst_brands_sizes_is_valid_size($sz)){
			return null;
		}

		return $GLOBALS['whosonfirst_brands_sizes']['brands_sizes'][$sz];
	}

	########################################################################

	function whosonfirst_brands_sizes_get_by_id($id){

		$sz = $GLOBALS['whosonfirst_brands_sizes']['brands_sizes_by_id'][$id];
		return whosonfirst_brands_sizes_get_by_size($sz);
	}

	########################################################################

	# is $other_sz > $sz

	function whosonfirst_brands_sizes_is_larger($sz, $other_sz){

		$sz_details = whosonfirst_brands_sizes_get_by_size($sz);
		$other_details = whosonfirst_brands_sizes_get_by_size($other_sz);

		if ($other_details["min"] > $sz_details["max"]){
			return 1;
		}

		return 0;
	}

	########################################################################

	# is $other_sz < $sz

	function whosonfirst_brands_sizes_is_smaller($sz, $other_sz){

		$sz_details = whosonfirst_brands_sizes_get_by_size($sz);
		$other_details = whosonfirst_brands_sizes_get_by_size($other_sz);

		if ($other_details["max"] < $sz_details["min"]){
			return 1;
		}

		return 0;
	}

	########################################################################

	function whosonfirst_brands_sizes_lt($sz){

		$sizes = array();

		$details = whosonfirst_brands_sizes_get_by_size($sz);

		if ($details){

			$min = $details["min"];

			foreach ($GLOBALS['whosonfirst_brands_sizes']['brands_sizes'] as $other_sz => $other_details){

				if ($other_details["max"] < $min){
					$sizes[] = $other_sz;
				}
			}
		}

		return $sizes;
	}

	########################################################################

	function whosonfirst_brands_sizes_gt($sz){

		$sizes = array();

		$details = whosonfirst_brands_sizes_get_by_size($sz);

		if ($details){

			$max = $details["max"];

			foreach ($GLOBALS['whosonfirst_brands_sizes']['brands_sizes'] as $other_sz => $other_details){

				if ($other["min"] > $max){
					$sizes[] = $other_sz;
				}
			}
		}

		return $sizes;
	}
	
	########################################################################

	function whosonfirst_brands_sizes_sort($a, $b){

		if ($a["min"] == $b["min"]){
		        return 0;
		}

		return ($a["min"] < $b["min"]) ? -1 : 1;
	}

	########################################################################

	# the end