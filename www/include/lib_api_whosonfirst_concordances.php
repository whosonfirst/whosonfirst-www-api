<?php

	loadlib("whosonfirst_concordances");
	loadlib("whosonfirst_sources");

	loadlib("api_whosonfirst_output");

	########################################################################

	function api_whosonfirst_concordances_getById(){

		$id = request_str("id");

		if (! $id){
			api_output_error(400, "Missing 'id' parameter");
		}

		$source = request_str("source");

		if (! $source){
			api_output_error(400, "Missing 'source' parameter");
		}

		# TO DO - ensure valid source here 

		$args = array();
		api_utils_ensure_pagination_args($args);

		$rsp = whosonfirst_concordances_get_by_id($source, $id, $args);

		if (! $rsp['ok']){
			api_output_error(500, $rsp['error']);
		}

		$rows = $rsp['rows'];
		$pagination = $rsp['pagination'];

		$out = array(
			'results' => $rows,
		);

		api_utils_ensure_pagination_results($out, $pagination);
		api_output_ok($out);
	}

	########################################################################
	
	# the end