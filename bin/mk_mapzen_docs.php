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
		"examples" => array("flag" => "x", "required" => 0, "boolean" => 1, "help" => ""),
	);

	$opts = cli_getopts($spec);

	$page = $opts['page'];
	$examples = $opts['examples'];

	#

	$api_endpoint = $GLOBALS['whosonfirst_api_endpoint'];

	if ($endpoint = $opts['endpoint']){
		$api_endpoint = $endpoint;
	}

	$GLOBALS['whosonfirst_api_endpoint'] = $api_endpoint;

	# 

	if ($examples){

		if ((! $opts['api_key']) && (! $opts['access_token'])){

			echo "Missing API key or access token!";
			exit(1);
		}
	}

	if ($page == "methods"){

		$example_calls = array();

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

			if ($examples){

				$args = array();

				if ($method_name == "whosonfirst.places.search"){
					$args["q"] = "poutine";
				}

				else if ($method_name == "whosonfirst.places.getDescendants"){
					$args["id"] = 420780703;
				}

				else if (is_array($details["parameters"])) {

					foreach ($details["parameters"] as $p){
						$args[$p["name"]] = $p["example"];
					}
				}

				else {}

				#

				if ($details["paginated"]){
					$args["per_page"] = 1;
				}

				#

				if ($key = $opts['api_key']){
					$args['api_key'] = $key;
				}

				else {

					$token = $opts['access_token'];
					$args['access_token'] = $token;
				}			

				#

				$rsp = whosonfirst_api_call($method_name, $args);

				if ((! $rsp["ok"]) && ($method_name != "api.test.error")){
					continue;
				}

				unset($args["api_key"]);
				unset($args["access_token"]);

				$data = $rsp["data"];
				unset($data["_query"]);

				$truncated = 0;

				if ($method_name == "api.spec.errors"){
					$data["errors"] = array_slice($data["errors"], 0, 2);
					$truncated = 1;
				}

				else if ($method_name == "api.spec.methods"){

					$methods = array();

					foreach ($data["methods"] as $m){

						$_method = $GLOBALS['cfg']['api']['methods'][$m['name']];

						if (($_method['enabled']) && ($_method['documented'])){
							$methods[] = $m;
						}

						if (count($methods) == 2){
							break;						   		   
						}
					}
					
					$data["methods"] = $methods;
					$truncated = 1;
				}

				else if ($method_name == "whosonfirst.placetypes.getList"){
					$data["placetypes"] = array_slice($data["placetypes"], 0, 2);
					$truncated = 1;
				}

				else if ($method_name == "whosonfirst.sources.getList"){
					$data["sources"] = array_slice($data["sources"], 0, 2);
					$truncated = 1;
				}

				else {}

				$body = json_encode($data, JSON_PRETTY_PRINT);

				$example_calls[ $method_name ] = array(
					"parameters" => $args,
					"response" => $body,
					"is_truncated" => $truncated,
				);
			}
		}

		foreach ($method_classes as $class_name => $ignore){
			usort($method_classes[$class_name]['methods'], function($a, $b) {
				return strcmp($a['name'], $b['name']);
			});
		}

		$GLOBALS['smarty']->assign_by_ref("method_classes", $method_classes);

		$GLOBALS['smarty']->assign_by_ref("method_classes", $method_classes);

		if ($examples){
			$GLOBALS['smarty']->assign_by_ref("example_calls", $example_calls);
		}
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