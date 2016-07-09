<?php

	########################################################################

	function machinetags_is_machinetag($tag){

		$rsp = machinetags_parse_machinetag($tag);
		return $rsp['ok'];
	}

	########################################################################

	function machinetags_parse_machinetag($tag, $more=array()){

		$defaults = array(
			'allow_wildcards' => 0
		);

		$more = array_merge($defaults, $more);

		if ($more['allow_wildcards']){

			if (! preg_match("/^((?:[a-z](?:[a-z_\-]+))|\*)\:((?:[a-z](?:[a-z_\-]+))|\*)=(.*)$/", $tag, $m)){
				return array('ok' => 0, 'error' => 'invalid machinetag', 'machinetag' => $tag);
			}

			$is_wildcard = 0;

			$ns = $m[1];
			$pred = $m[2];
			$value = $m[3];

			if ($ns == '*'){
				$ns = null;
			}

			if ($pred == '*'){
				$pred = null;
			}

			if (($value == '*') || ($value == '')){
				$value = null;
			}

			if ((! $ns) && (! $pred) && (! $value)){
				return array('ok' => 0, 'error' => 'invalid wildcard machinetag', 'machinetag' => $tag);
			}

			if ((! $ns) || (! $pred) || (! $value)){
				$is_wildcard = 1;
			}

			return array(
				'ok' => 1,
				'namespace' => $ns,
				'predicate' => $pred,
				'value' => $value,
				'machinetag' => $tag,
				'is_wildcard' => $is_wildcard,
			);
		}

		# fully qualified machinetags

		if (! preg_match("/^([a-z](?:[a-z_\-]+))\:([a-z](?:[a-z_\-]+))=(.+)$/", $tag, $m)){
			return array('ok' => 0, 'error' => 'invalid machinetag', 'machinetag' => $tag);
		}

		$ns = $m[1];
		$pred = $m[2];
		$value = $m[3];

		return array(
			'ok' => 1,
			'namespace' => $ns,
			'predicate' => $pred,
			'value' => $value,
			'machinetag' => $tag,
			'is_wildcard' => 0,
		);
	}

	########################################################################

	# the end
