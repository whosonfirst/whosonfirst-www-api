<?php

	loadlib("elasticsearch");
	loadlib("machinetags");

	########################################################################

	function machinetags_elasticsearch_query_filter_from_machinetag($tag){

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

	function machinetags_elasticsearch_query_filter_from_hierarchy($args){

		# https://stackoverflow.com/questions/24819234/elasticsearch-using-the-path-hierarchy-tokenizer-to-access-different-level-of
		# https://www.elastic.co/guide/en/elasticsearch/reference/1.7/search-aggregations-bucket-terms-aggregation.html
		# https://github.com/whosonfirst/py-mapzen-whosonfirst-machinetag/blob/master/mapzen/whosonfirst/machinetag/__init__.py

		# these are used to prune the initial ES dataset

		$rsp_filter = null;

		# these are appended to aggrs['hierarchies']['terms']

		$include_filter = null;
		$exclude_filter = null;

		if ($args['filter'] == 'namespaces'){

			$rsp_filter = 'query_filter_namespaces';	# fix me

			if ($args['predicate'] && $args['value']){

				$esc_pred = elasticsearch_escape($args['predicate']);
				$esc_value = elasticsearch_escape($args['value']);

				$include_filter = '.*\/' . $esc_pred + '\/' . $esc_value . '$';
			}

			# all the namespaces for a predicate

			else if ($args['predicate']){

				$esc_pred = elasticsearch_escape($args['predicate']);

				$include_filter = '^.*\/' . $esc_pred;
				$exclude_filter = '.*\/.*\/.*';
			}

			# all the namespaces for a value 
            
			else if ($args['value']){

				$esc_value = elasticsearch_escape($args['value']);

				$include_filter = '.*\/.*\/' . $esc_value . '$';
			}

			# all the namespaces
        
			else {

				$exclude_filter = '.*\/.*';
			}
		}

	    	else if ($args['filter'] == 'predicates'){

			$rsp_filter = 'query_filter_predicates';	# fix me

			# all the predicates for a namespace and value

			if ($args['namespace'] && $args['value']){

				$esc_ns = elasticsearch_escape($args['namespace']);
				$esc_value = elasticsearch_escape($args['value']);

				$include_filter = '^' . $esc_ns + '\/.*\.' . $esc_value . '$';
			}

			# all the predicates for a namespace

			else if ($args['namespace']){

				$esc_ns = elasticsearch_escape($args['namespace']);

				$include_filter = '^' . $esc_ns . '\/[^\/]+';
				$exclude_filter = '.*\/.*\/.*';
			}

			# all the predicates for a value

			else if ($args['value']){

				$esc_value = elasticsearch_escape($args['value']);

				$include_filter = '.*\/.*\/' . $esc_value . '$';
			}

			# all the predicates

			else {

				$include_filter = '.*\/.*';
				$exclude_filter = '.*\/.*\/.*';
        		}
		}

		else if ($args['filter'] == 'values'){

			$rsp_filter = 'query_filter_values';	# fix me

			# all the values for namespace and predicate

			if ($args['namespace'] && $args['predicate']){

				$esc_ns = elasticsearch_escape($args['namespace']);
				$esc_pred = elasticsearch_escape($args['predicate']);

				$include_filter = '^' . $esc_ns + '\.' . $esc_pred + '\..*';
			}

			# all the values for a namespace

			else if ($args['namespace']){

				$esc_ns = elasticsearch_escape($args['namespace']);

				$include_filter = '^' . $esc_ns . '\/.*\/.*';
			}

			# all the values for a predicate
    
			else if ($args['predicate']){
            
				$esc_pred = elasticsearch_escape($args['predicate']);

				$include_filter = '^.*\/' . $esc_pred . '\/.*';
			}

			# all the values

			else {

				$include_filter = '.*\/.*\/.*';
			}
		}

		else {

			# TO DO - all the other combinations (20160612/thisisaaronland)
		}

		/*
        if $args['namespace']:
            
            $esc_ns = elasticsearch_escape($args['namespace'])
            $include_filter = '^' + $esc_ns + '\/.*'

        else if $args['predicate']:
            
            $esc_pred = elasticsearch_escape($args['predicate'])
            $include_filter = '^.*\/' + $esc_pred + '\/.*'

        else if $args['value']:
            
            $esc_value = elasticsearch_escape($args['value'])
            $include_filter = '^.*\/.*\/' + $esc_value + '$'

        else:
            pass

		*/
	    
		return array($include_filter, $exclude_filter, $rsp_filter);

	}

	########################################################################

	# the end
