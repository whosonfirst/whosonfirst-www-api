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

			$rsp_filter = 'machinetags_elasticsearch_hierarchies_query_filter_namespaces';

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

			$rsp_filter = 'machinetags_elasticsearch_hierarchies_query_filter_predicates';

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

			$rsp_filter = 'machinetags_elasticsearch_hierarchies_query_filter_values';

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

	function machinetags_elasticsearch_hierarchies_query_filter_namespaces($unfiltered){

		$filtered = array();
		$tmp = array();

		foreach ($unfiltered as $row){

			$key = $row['key'];
			$count = $row['doc_count'];

			$key = explode("/", $key);
			$ns = $key[0];

			$tmp[$ns] += $count;
		}

		foreach ($tmp as $ns => $count){

			$filtered[] = array(
				'doc_count' => $count,
				'key' => $ns,
				'namespace' => $ns,
				'predicate' => null,
				'value' => null
			);
		}

		return machinetags_elasticsearch_hierarchies_sort_filtered($filtered);
	}	

	########################################################################

	function machinetags_elasticsearch_hierarchies_query_filter_predicates($unfiltered){

		$filtered = array();
		$tmp = array();

		foreach ($unfiltered as $row){

			$key = $row['key'];
			$count = $row['doc_count'];

			$key = explode("/", $key);
			$pred = $key[1];

			$tmp[$pred] += $count;
		}

		foreach ($tmp as $pred => $count){

			$filtered[] = array(
				'doc_count' => $count,
				'key' => $pred,
				'namespace' => null,
				'predicate' => $pred,
				'value' => null
			);
		}

		return machinetags_elasticsearch_hierarchies_sort_filtered($filtered);
	}	

	########################################################################

	function machinetags_elasticsearch_hierarchies_query_filter_values($unfiltered){

		$filtered = array();
		$tmp = array();

		foreach ($unfiltered as $row){

			$key = $row['key'];
			$count = $row['doc_count'];

			$key = explode("/", $key);
			$value = $key[2];

			$tmp[$value] += $count;
		}

		foreach ($tmp as $value => $count){

			$filtered[] = array(
				'doc_count' => $count,
				'key' => $value,
				'namespace' => null,
				'predicate' => null,
				'value' => $value,
			);
		}

		return machinetags_elasticsearch_hierarchies_sort_filtered($filtered);
	}	

	########################################################################

	function machinetags_elasticsearch_hierarchies_sort_filtered(&$unsorted){

		$sorted = array();
		$tmp = array();

		foreach ($unsorted as $row){

			$key = $row['key'];
			$count = $row['doc_count'];

			$bucket = (isset($tmp[$count])) ? $tmp[$count] : array();
			$bucket[] = $row;

			$tmp[$count] = $bucket;
		}

		krsort($tmp);

		foreach ($tmp as $count => $buckets){

			foreach ($buckets as $row){
				$row['doc_count'] = $count;
				$sorted[] = $row;
			}
		}

		return $sorted;
	}

	########################################################################

	# the end
