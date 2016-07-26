<?php

	loadlib("machinetags");

	########################################################################

	function machinetags_elasticsearch_wildcard_query_filter_from_machinetag($tag){

		$rsp = machinetags_parse_machinetag($tag, array("allow_wildcards" => 1));

		if (! $rsp['ok']){
			return null;
		}

		$ns = $rsp['namespace'];
		$pred = $rsp['predicate'];
		$value = $rsp['value'];

		$esc_ns = null;
		$esc_pred = null;
		$esc_value = null;

		if ($ns){
			$esc_ns = elasticsearch_escape($ns);
		}

		if ($pred){
			$esc_pred = elasticsearch_escape($pred);
		}

		if ($value){
			$esc_ns = elasticsearch_escape($value);
		}

		# https://www.elastic.co/guide/en/elasticsearch/reference/1.7/query-dsl-regexp-query.html#regexp-syntax

		$query_filter = null;

		# is machine tag

		if (($ns != null) && ($pred != null) && ($value != null)){

			$query_filter = $esc_ns . '\/' + $esc_pred . '\/' + $esc_value;
		}

		# sg:*=

		else if (($ns != null) && ($pred == null) && ($value == null)){

			$query_filter = $esc_ns . '\/[^\/]+\/.*';
		}

		# sg:services=

		else if (($ns != null) && ($pred != null) && ($value == null)){

			$query_filter = $esc_ns . '\/' . $esc_pred . '\/.*';
		}

		# sg:*=personal

		else if (($ns != null) && ($pred == null) && ($value != null)){

			$query_filter = $esc_ns . '\/[^\/]+\/' . $esc_value;
		}

		# *:services=personal

		else if (($ns == null) && ($pred != null) && ($value != null)){

			$query_filter = '[^\/]+\.' . $esc_pred . '\/' . $esc_value;
		}

		# *:services=

		else if (($ns == null) && ($pred != null) && ($value == null)){

			$query_filter = '[^\/]+\/' . $esc_pred . '\/.*';
		}

		# *:*=personal

		else if (($ns == null) && ($pred == null) && ($value != null)){

			$query_filter = '[^\/]+\/[^\/]+\/' . $esc_value;
		}

		else {
			# WTF?
		}

		return $query_filter;
	}

	########################################################################

	# the end