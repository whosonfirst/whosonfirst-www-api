<?php

	########################################################################

	function whosonfirst_uri_id2relpath($id, $more=array()){

		$fname = whosonfirst_uri_id2fname($id, $more);
		$tree = whosonfirst_uri_id2tree($id);

		return implode(DIRECTORY_SEPARATOR, array($tree, $fname));
	}

	########################################################################

	function whosonfirst_uri_id2abspath($root, $id, $more=array()){

		$rel = whosonfirst_uri_id2relpath($id, $more);

		# Check $root for a trailing slash, so we don't get two slashes

		if (substr($root, -1, 1) == DIRECTORY_SEPARATOR) {
			$root = substr($root, 0, -1);
		}
		
		return implode(DIRECTORY_SEPARATOR, array($root, $rel));
	}

	########################################################################

	function whosonfirst_uri_id2fname($id, $more=array()){

		 # PLEASE WRITE: all the alt/display name stuff

		 return "{$id}.geojson";
	}

	########################################################################

	function whosonfirst_uri_id2tree($id){

		$tree = array();
		$tmp = $id;

		while (strlen($tmp)){

			$slice = substr($tmp, 0, 3);
			array_push($tree, $slice);

			$tmp = substr($tmp, 3);
		}

		return implode(DIRECTORY_SEPARATOR, $tree);
	}

	########################################################################

	# the end
