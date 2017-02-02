<?php

	loadlib("whosonfirst_placetypes_spec");

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
