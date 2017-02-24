<?php

	loadlib("whosonfirst_tags");

	########################################################################

	function api_whosonfirst_tags_getTags(){

		$args = array();
		api_utils_ensure_pagination_args($args);

		$source = api_whosonfirst_tags_ensure_source(array("error_code" => 432));
		$rsp = whosonfirst_tags_get_tags($source, $args);

		if (! $rsp['ok']){
			api_output_error(513);
		}

		$pagination = $rsp['pagination'];

		$out = array(
			'tags' => $rsp['rows']
		);

		api_utils_ensure_pagination_results($out, $pagination);
		api_output_ok($out);
	}

	########################################################################

	function api_whosonfirst_tags_getSources(){

		$sources = whosonfirst_tags_sources();
		$out = array('sources' => $sources);
		
		api_output_ok($out);
	}

	########################################################################

	function api_whosonfirst_tags_ensure_source($more=array()){
	
		$defaults = array(
			"error_code" => 454
		);

		$more = array_merge($defaults, $more);

		if ($source = request_str("source")){

			if (! whosonfirst_tags_is_valid_source($source)){
				api_output_error($more["error_code"]);
			}

			return "{$source}:tags";
		}

		return "tags_all";
	}

	########################################################################

	# the end