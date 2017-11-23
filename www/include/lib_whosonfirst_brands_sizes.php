<?php

	########################################################################

	function whosonfirst_brands_sizes_is_valid_size($sz){
	
		# in advance of code that uses the data in whosonfirst-brands-sizes
		# (20171123/thisisaaronland)

		$valid = array(
			"O",
			"XXXS", "XXS", "XS",
			"S", "M", "L",
			"XL", "XXL", "XXXL"
		);

		return in_array($sz, $valid);
	}

	########################################################################

	# the end