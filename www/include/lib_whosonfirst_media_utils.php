<?php

	########################################################################

	function whosonfirst_media_utils_sort_sizes(&$sizes){

		function cmp($a, $b){

			$a = $a["height"] * $a["width"];
			$b = $b["height"] * $b["width"];

			if ($a == $b) {
				return 0;
			}

			return ($a > $b) ? -1 : 1;
		}

		$sorted = array();

		foreach ($sizes as $label => $details){
			$details["label"] = $label;
			$sorted[] = $details;
		}		

		usort($sorted, "cmp");
		return $sorted;
	}

	########################################################################
	
	# the end