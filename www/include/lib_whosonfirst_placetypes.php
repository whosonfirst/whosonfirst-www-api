<?php

	########################################################################

	$GLOBALS['whosonfirst_placetypes']['__SPEC__'] = '{"102312321": {"role": "optional", "name": "microhood", "parent": [102312319], "names": {}}, "102312323": {"role": "optional", "name": "macrohood", "parent": [102312317], "names": {}}, "102312325": {"role": "common_optional", "name": "venue", "parent": [102312327, 102312329, 102312331, 102312321, 102312319], "names": {}}, "102312327": {"role": "common_optional", "name": "building", "parent": [102312329, 102312331, 102312321, 102312319], "names": {}}, "102312329": {"role": "common_optional", "name": "address", "parent": [102312331, 102312321, 102312319], "names": {}}, "102312331": {"role": "common_optional", "name": "campus", "parent": [102312321, 102312319, 102312323, 102312317, 404221409], "names": {}}, "404528653": {"role": "common_optional", "name": "ocean", "parent": [102312341], "names": {}}, "102312335": {"role": "common_optional", "name": "empire", "parent": [102312309], "names": {}}, "102312341": {"role": "common_optional", "name": "planet", "parent": [], "names": {}}, "102320821": {"role": "common_optional", "name": "dependency", "parent": [102312307], "names": {}}, "136057795": {"role": "common_optional", "name": "timezone", "parent": [102312307, 102312309, 102312341], "names": {}}, "404528655": {"role": "common_optional", "name": "marinearea", "parent": [102312307, 102312309, 102312341], "names": {}}, "102371933": {"role": "optional", "name": "metroarea", "parent": [], "names": {}}, "404221409": {"role": "common_optional", "name": "localadmin", "parent": [102312313, 102312311], "names": {}}, "404221411": {"role": "optional", "name": "macroregion", "parent": [102320821, 102322043, 102312307], "names": {}}, "404221413": {"role": "optional", "name": "macrocounty", "parent": [102312311], "names": {}}, "102312307": {"role": "common", "name": "country", "parent": [102312335, 102312309], "names": {}}, "102312309": {"role": "common", "name": "continent", "parent": [102312341], "names": {}}, "102312311": {"role": "common", "name": "region", "parent": [404221411, 102320821, 102322043, 102312307], "names": {}}, "102312313": {"role": "common_optional", "name": "county", "parent": [404221413, 102312311], "names": {}}, "102322043": {"role": "common_optional", "name": "disputed", "parent": [102312307], "names": {}}, "102312317": {"role": "common", "name": "locality", "parent": [404221409, 102312313, 102312311], "names": {}}, "102312319": {"role": "common", "name": "neighbourhood", "parent": [102312323, 102312317], "names": {"eng_p": ["neighbourhood", "neighborhood"]}}}';

	########################################################################

	# Hey look! Running code!! (20161010/thisisaaronland)
	
	$GLOBALS['whosonfirst_placetypes']['spec'] = json_decode($GLOBALS['whosonfirst_placetypes']['__SPEC__'], "as hash");

	if (! $GLOBALS['whosonfirst_placetypes']['spec']){
		log_fatal("failed to parse placetypes spec");
	}

	# Hey look! More running code!!! (20161010/thisisaaronland)
	
	$GLOBALS['whosonfirst_placetypes']['placetypes_by_id'] = array();
	$GLOBALS['whosonfirst_placetypes']['placetypes'] = array();
	$GLOBALS['whosonfirst_placetypes']['roles'] = array();	

	foreach ($GLOBALS['whosonfirst_placetypes']['spec'] as $id => $details){

		$name = $details['name'];
		$role = $details['role'];
		$parents = array();

		$GLOBALS['whosonfirst_placetypes']['placetypes_by_id'][$id] = $name;
		
		foreach ($details['parent'] as $_pid){
			$_parent = $GLOBALS['whosonfirst_placetypes']['spec'][$_pid];
			$parents[] = $_parent['name'];
		}

		$names = (is_array($details['names'])) ? $details['names'] : array();
		
		$GLOBALS['whosonfirst_placetypes']['placetypes'][$name] = array(
			'id' => $id,
			'role' => $role,
			'parents' => $parents,
			'names' => $names,				
		);

		foreach ($names as $label => $alts){

	        	# if not label.endswith("_p"):
            		# continue

			foreach ($alts as $alt){

				if (! isset($GLOBALS['whosonfirst_placetypes']['placetypes'][$alt])){
					$GLOBALS['whosonfirst_placetypes']['placetypes'][$alt] = $GLOBALS['whosonfirst_placetypes']['placetypes'][$name];
				}
			}
		}

		if (! isset($GLOBALS['whosonfirst_placetypes']['roles'][$role])){
			$GLOBALS['whosonfirst_placetypes']['roles'][$role] = array();
		}
	}
	
	########################################################################

	function whosonfirst_placetypes_is_valid_placetype($pt, $more=array()){

		$defaults = array(
			'role' => null
		);

		$more = array_merge($defaults, $more);

		if (! isset($GLOBALS['whosonfirst_placetypes']['placetypes'][$pt])){
			return 0;
		}

		if (($role = $more['role']) && ($role != $GLOBALS['whosonfirst_placetypes'][$pt]['role'])){
			return 0;
		}

		return 1;
	}

	########################################################################

	function whosonfirst_placetypes_is_valid_role($role){

		if (! isset($GLOBALS['whosonfirst_placetypes']['roles'][$role])){
			return 0;
		}

		return 1;
	}

	########################################################################

	function whosonfirst_placetypes_common() {
	
		return whosonfirst_placetypes_with_role("common");
	}
	
	########################################################################

	function whosonfirst_placetypes_common_optional() {

		return whosonfirst_placetypes_with_role("common_optional");
	}
	
	########################################################################

	function whosonfirst_placetypes_optional() {

		return whosonfirst_placetypes_with_role("optional");
	}
			
	########################################################################

	function whosonfirst_placetypes_with_role($role){

		return whosonfirst_placetypes_with_roles(array($role));
	}
	
	########################################################################

	function whosonfirst_placetypes_with_roles($roles){

		$placetypes = array();

		foreach ($GLOBALS['whosonfirst_placetypes']['spec'] as $id => $details){

			if (! in_array($details['role'], $roles)){
				continue;
			}

			$placetypes[] = $details['name'];
		}

		return $placetypes;
	}

	########################################################################

	function whosonfirst_placetypes_id_to_name($id){

		return $GLOBALS['whosonfirst_placetypes']['placetypes_by_id'][$id];
	}
	
	########################################################################
	
	function whosonfirst_placetypes_name_to_id($name){

		return $GLOBALS['whosonfirst_placetypes']['placetypes'][$name]['id'];
	}
	########################################################################
	
	# the end
