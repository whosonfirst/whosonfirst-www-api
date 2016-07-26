<?php

	loadlib("elasticsearch");

	########################################################################

	function machinetags_elasticsearch_hierarchies_query_filters($args){

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

			if ($args['namespace']){
            
				$esc_ns = elasticsearch_escape($args['namespace']);
				$include_filter = '^' . $esc_ns . '\/.*';

			}

			else if ($args['predicate']){
            
				$esc_pred = elasticsearch_escape($args['predicate']);
				$include_filter = '^.*\/' . $esc_pred . '\/.*';
			}

			else if ($args['value']){
            
				$esc_value = elasticsearch_escape($args['value']);
				$include_filter = '^.*\/.*\/' . $esc_value + '$';
			}

			else {}
		}
	    
		return array($include_filter, $exclude_filter, $rsp_filter);
	}

	########################################################################

	# the end
