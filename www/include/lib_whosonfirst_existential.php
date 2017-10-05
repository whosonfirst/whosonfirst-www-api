<?php

	// This library is an adaptation of https://github.com/whosonfirst/go-whosonfirst-geojson-v2/blob/master/properties/whosonfirst/whosonfirst.go#L160-L265
	// It is designed to work with SPR results, not with full WOF feature
	// records. (20171004/dphiffer)

	########################################################################

	function whosonfirst_existential_is_current($place){

		if ($place['mz:is_current'] == 1 ||
		    $place['mz:is_current'] == 0){
			return $place['mz:is_current'];
		}
		else if (whosonfirst_existential_is_ceased($place) == 1 ||
		         whosonfirst_existential_is_superseded($place) == 1 ||
		         whosonfirst_existential_is_deprecated($place) == 1){
			return 0;
		}
		else {
			return -1;
		}
	}

	########################################################################

	function whosonfirst_existential_is_deprecated($place){

		if (empty($place['edtf:deprecated'])){
			return 0;
		}
		else if ($place['edtf:deprecated'] == 'u' ||
		         $place['edtf:deprecated'] == 'uuuu'){
			return -1;
		} else {
			return 1;
		}
	}

	########################################################################

	function whosonfirst_existential_is_ceased($place){

		if (! isset($place['edtf:cessation']) ||
		    $place['edtf:cessation'] == 'u' ||
		    $place['edtf:cessation'] == 'uuuu'){
			return -1;
		}
		else if (empty($place['edtf:cessation'])){
			return 0;
		} else {
			return 1;
		}
	}

	########################################################################

	function whosonfirst_existential_is_superseded($place){

		if (isset($place['wof:superseded_by']) &&
		    count($place['wof:superseded_by']) > 0){
			return 1;
		}
		else {
			return 0;
		}
	}

	########################################################################

	function whosonfirst_existential_is_superseding($place){

		if (isset($place['wof:supersedes']) &&
		    count($place['wof:supersedes']) > 0){
			return 1;
		}
		else {
			return 0;
		}
	}

	# the end
