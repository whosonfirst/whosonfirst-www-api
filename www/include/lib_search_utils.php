<?php

	function search_utils_ensure_pagination($q, &$out, &$pagination) {

		$prev_args = array(
			'q' => $q,
			'page' => $pagination['page'] - 1
		);
		$next_args = array(
			'q' => $q,
			'page' => $pagination['page'] + 1
		);

		$args = explode('&', $out['next_query']);
		foreach ($args as $arg) {
			$arg = explode('=', $arg);
			$key = rawurlencode($arg[0]);
			$val = rawurlencode($arg[1]);
			$prev_args[$key] = $val;
			$next_args[$key] = $val;
		}

		$pagination['has_next'] = $pagination['page'] < $pagination['page_count'];
		if ($pagination['has_next']) {
			$pagination['next_url'] = '/search/' . http_build_query($next_args);
		}

		$pagination['has_prev'] = $pagination['page'] > 1;
		if ($pagination['has_prev']) {
			$pagination['prev_url'] = '/search/' . http_build_query($next_args);
		}

	}
