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

		# TO DO: wildcard matching... (20160708/thisisaaronland)

		if (preg_match("/^([a-z_\-]+)\:([a-z_\-]+)=(.*)$/", $tag, $m)){

			return array(
				'ok' => 1,
				'namespace' => $m[1],
				'predicate' => $m[2],
				'value' => $m[3],
				'is_wildcard' => 0,
			);
		}

		return array('ok' => 0);
	}

	########################################################################

	# the end
