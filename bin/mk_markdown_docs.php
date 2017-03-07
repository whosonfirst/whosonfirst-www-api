<?php

	include("init_local.php");

	$GLOBALS['cfg']['environment'] = 'prod';

	loadlib("api");
	loadlib("api_methods");

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
	}

	foreach ($method_classes as $class_name => $ignore){
		usort($method_classes[$class_name]['methods'], function($a, $b) {
			return strcmp($a['name'], $b['name']);
		});
	}

	$GLOBALS['smarty']->assign_by_ref("method_classes", $method_classes);

	$formats = $GLOBALS['cfg']['api']['formats'];
	$GLOBALS['smarty']->assign_by_ref("response_formats", $formats);

	$errors = $GLOBALS['cfg']['api']['errors'];
	ksort($errors);

	$GLOBALS['smarty']->assign("errors", $errors);

	$GLOBALS['smarty']->assign_by_ref("default_format", $GLOBALS['cfg']['api']['default_format']);

	echo $GLOBALS['smarty']->fetch("markdown_mapzen_api_docs.txt");
	exit(0);
?>