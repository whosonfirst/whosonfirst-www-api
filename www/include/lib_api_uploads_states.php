<?php

	loadlib("uploads");

	########################################################################

	function api_uploads_states_getList() {

		api_utils_features_ensure_enabled(array(
			"uploads",
		));

		$map = uploads_status_map("string keys");

		$out = array(
			"states" => $map,
		);

		api_output_ok($out);
	}

	########################################################################

	# the end
