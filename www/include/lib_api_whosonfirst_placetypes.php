<?php

	loadlib("whosonfirst_placetypes");

	########################################################################

	function api_whosonfirst_placetypes_getRoles(){

		$roles = $GLOBALS['whosonfirst_placetypes']['roles'];
		$roles = array_keys($roles);

		$out = array("roles" => $roles);
		api_output_ok($out);
	}

	########################################################################

	function api_whosonfirst_placetypes_getInfo(){

		$id = request_int64("id");
		$name = request_str("name");
		
		if ((! $id) && (! $name)){
			api_output_error(452);
		}

		if ($id){

			if (! isset($GLOBALS['whosonfirst_placetypes']['placetypes_by_id'][$id])){
				api_output_error(432);
			}

			$name = $GLOBALS['whosonfirst_placetypes']['placetypes_by_id'][$id];
		} 

		if (! isset($GLOBALS['whosonfirst_placetypes']['placetypes'][$name])){
			api_output_error(433);
		}

		$place = $GLOBALS['whosonfirst_placetypes']['placetypes'][$name];
		api_whosonfirst_enpublicify_placetype($place, array("name" => $name));

		$out = array("placetype" => $place);

		$more = array(
			'is_singleton' => 1,
			'key' => 'placetype',
		);

		api_output_ok($out, $more);
	}

	########################################################################

	function api_whosonfirst_placetypes_getList(){

		$role = request_str("role");

		if (($role) && (! whosonfirst_placetypes_is_valid_role($role))){
			api_output_error(432);
		}

		$placetypes = array();

		foreach ($GLOBALS['whosonfirst_placetypes']['placetypes'] as $name => $details){

			if (($role) && ($details["role"] != $role)){
				continue;
			}

			api_whosonfirst_enpublicify_placetype($details, array("name" => $name));

			$placetypes[] = $details;
		}

		$out = array("placetypes" => $placetypes);

		$more = array(
			'key' => 'placetypes',
		);

		api_output_ok($out, $more);
	}

	########################################################################

	function api_whosonfirst_enpublicify_placetype(&$placetype, $more=array()){

		$defaults = array(
			"name" => null,
		);

		$more = array_merge($defaults, $more);

		unset($placetype["names"]);

		if ($name = $more["name"]){
			$placetype["name"] = $name;
		}

		ksort($placetype);

		# pass by ref
	}

	########################################################################

	# the end