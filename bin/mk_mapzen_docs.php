<?php

	include("init_local.php");

	# this is important (if we are building the docs from 
	# a not-prod machine)

	$GLOBALS['cfg']['environment'] = 'prod';

	#

	loadlib("cli");
	loadlib("api");
	loadlib("api_methods");
	loadlib("whosonfirst_api");

	$spec = array(
		"page" => array("flag" => "p", "required" => 0, "help" => ""),
		"endpoint" => array("flag" => "e", "required" => 0, "help" => ""),
		"api_key" => array("flag" => "k", "required" => 0, "help" => ""),
		"access_token" => array("flag" => "t", "required" => 0, "help" => ""),
	);

	$opts = cli_getopts($spec);

	$page = $opts['page'];

	# 
	
	if ($page == "methods"){

		ksort($GLOBALS['cfg']['api']['methods']);

		foreach ($GLOBALS['cfg']['api']['methods'] as $method_name => $details){

			$details['name'] = $method_name;

			if (! api_methods_can_view_method($details, 0)){
				continue;
			}

			$parts = explode(".", $method_name);
			array_pop($parts);

			$method_prefix = $parts[0];
			$method_class = implode(".", $parts);

			if (! is_array($method_classes[$method_class])){

				$method_classes[$method_class] = array(
					'methods' => array(),
					'prefix' => $method_prefix,
				);
			}

			$method_classes[$method_class]['methods'][] = $details;
			$method_names[] = $details['name'];

			# generate examples here...


		}

		foreach ($method_classes as $class_name => $ignore){
			usort($method_classes[$class_name]['methods'], function($a, $b) {
				return strcmp($a['name'], $b['name']);
			});
		}

		$GLOBALS['smarty']->assign_by_ref("method_classes", $method_classes);
	}

	$formats = $GLOBALS['cfg']['api']['formats'];
	$GLOBALS['smarty']->assign_by_ref("response_formats", $formats);

	$errors = $GLOBALS['cfg']['api']['errors'];
	ksort($errors);

	$GLOBALS['smarty']->assign("errors", $errors);

	$GLOBALS['smarty']->assign_by_ref("default_format", $GLOBALS['cfg']['api']['default_format']);

	# 

	$template = ($page) ? "markdown_mapzen_api_{$page}.txt" : "markdown_mapzen_api_docs.txt";

	echo $GLOBALS['smarty']->fetch($template);
	exit(0);
?>