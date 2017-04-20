<?php

	loadlib("api_spec_utils");

	# See also:
	# http://blog.linode.com/2012/04/04/api_spec/

 	#################################################################

	function api_spec_formats(){

		api_output_ok(array(
			'formats' => $GLOBALS['cfg']['api']['formats'],
			'default_format' => $GLOBALS['cfg']['api']['default_format']
		));
	}

 	#################################################################

	function api_spec_methods(){

		$export_keys = array(
			'method',
			'description',
			'requires_auth',
			'parameters',
			'errors',
			'notes',
			'example',
			'extras',
			'paginated',
			'pagination',
			'disallow_formats',
		);

		$export_keys_params = array(
			'name',
			'description',
			'required',
			'example',
		);

		$defaults = array(
			'method' => 'GET',
			'requires_auth' => 0,
			'description' => '',
			'parameters' => array(),
			'errors' => array(),
			'extras' => 0,
			'paginated' => 0,
			'pagination' => 'plain',
			'disallow_formats' => array(),
		);

		$methods = array();

		foreach ($GLOBALS['cfg']['api']['methods'] as $name =>$details){

			if (! $details['enabled']){
				continue;
			}

			if (! $details['documented']){
				continue;
			}

			$details = array_merge($defaults, $details);

			$method = array(
				'name' => $name,
			);

			foreach ($export_keys as $k){

				if (! isset($details[$k])){
					continue;
				}

				$v = $details[$k];

				if ($k == "parameters"){

					$params_list = array();

					foreach ($v as $param_raw){

						$param = array();

						foreach ($export_keys_params as $p){

							if (isset($param_raw[$p])){
								$param[$p] = $param_raw[$p];							
							}
						}

						$params_list[] = $param;
					}

					$v = $params_list;
				}

				$method[$k] = $v;
			}

			if (! $method['paginated']){
				unset($method['pagination']);
			}

			$methods[] = $method;
		}

		api_output_ok(array(
			'methods' => $methods
		));

	}

 	#################################################################

	function api_spec_errors(){

		$all_errors = $GLOBALS['cfg']['api']['errors'];
		ksort($all_errors);

		$rsp_errors = [];

		foreach ($all_errors as $code => $details){

			if (! $details['documented']){
				continue;
			}

			$details['code'] = $code;

			$rsp_errors[] = array(
				'code' => $code,
				'message' => $details['message']
			);
		}

		$out = array('errors' => $rsp_errors);
		api_output_ok($out);
	}

 	#################################################################

	# the end
