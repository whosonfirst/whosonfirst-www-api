<?php

	loadlib("tile38");

	# Pending a proper refeed of the Tile38 data (20161011/thisisaaronland)

	$GLOBALS['whosonfirst_spatial_properties_hack'] = 1;

	########################################################################

	function whosonfirst_spatial_index_feature(&$feature, $more=array()){

		$geom = $feature['geometry'];
		$props = $feature['properties'];

		$wofid = $props['wof:id'];
		$parent_id = $props['wof:parent_id'];

		$placetype = $props['wof:placetype'];
		$placetype_id = whosonfirst_placetypes_name_to_id($placetype);
						
		$str_geom = json_encode($geom);

		$cmd = array(
			"SET", "__COLLECTION__", $wofid,
			"FIELD", "wof:id", $wofid,
			"FIELD", "wof:placetype_id", $placetype_id,
			"FIELD", "wof:parent_id", $parent_id,
			# PLEASE IMPLEMENT ME... (20161010/thisisaaronland)				 
			# "FIELD", "wof:deprecated", $deprecated,
			# "FIELD", "wof:superseded", $superseded,
			# "FIELD", "wof:is_current", $current,			
			"OBJECT", $str_geom
		);

		$cmd = implode(" ", $cmd);

		$rsp = whosonfirst_spatial_do($cmd, $more);

		if (! $rsp['ok']){
			return $rsp;
		}

		$rsp2 = whosonfirst_spatial_assign_meta($props, $more);

		if (! $rsp2['ok']){
			return $rsp2;
		}
		
		return $rsp;
	}

	########################################################################

	function whosonfirst_spatial_nearby_feature(&$feature, $more=array()){

		$props = $feature['properties'];
		
		# sudo make me a function to pick the best coordinate for
		# nearby-iness (20160811/thisisaaronland)

		$lat = $props['geom:latitude'];
		$lon = $props['geom:longitude'];

		$r = 100;
	
		return whosonfirst_spatial_nearby_latlon($lat, $lon, $r, $more);
	}

	########################################################################

	function whosonfirst_spatial_nearby_latlon($lat, $lon, $r, $more=array()){

		$where = array();

		$possible = array(
			"wof:id",
			"wof:placetype_id",
		);

		foreach ($possible as $key){

			if ((! isset($more[$key])) || (! $more[$key])){
				continue;
			}

			$id = $more[$key];

			$where[] = "WHERE {$key} {$id} {$id}";
		}

		$cmd = array(
			"NEARBY", "__COLLECTION__",
		);

		if (count($where)){
			$cmd[] = implode(" ", $where);
		}

		$cmd = array_merge($cmd, array(
			"POINT", $lat, $lon, $r
		));

		$cmd = implode(" ", $cmd);

		return whosonfirst_spatial_do($cmd, $more);
	}

	########################################################################

	function whosonfirst_spatial_within($swlat, $swlon, $nelat, $nelon, $more=array()){

		$defauts = array(
			'placetype_id' => null,			
			'cursor' => null,
		);

		$more = array_merge($defaults, $more);

		$cmd = array(
			"INTERSECTS __COLLECTION__",
		);
		
		if ($cursor = $more['cursor']){
			$cmd[] = "CURSOR {$cursor}";
		}

		if ($pt = $more['placetype_id']){
			$cmd[] = "WHERE {$pt} ${pt}";
		}

		$cmd[] = "BOUNDS {$swlat} {$swlon} {$nelat} {$nelon}";

		$cmd = implode(" ", $cmd);

		return whosonfirst_spatial_do($cmd, $more);
	}

	########################################################################

	function whosonfirst_spatial_assign_meta(&$props, $more=array()){

		$defaults = array(
			'meta_fields' => array('wof:name', 'wof:country')
		);

		$more = array_merge($defaults, $more);

		$meta = array();

		foreach ($more['meta_fields'] as $f){
			$meta[$f] = $props[$f];
		}
		
		$meta = json_encode($meta);
		
		$meta_key = "{$wofid}:meta";
		
		$cmd = array("SET", "__COLLECTION__", $meta_key, "STRING", $meta);
		$cmd = implode(" ", $cmd);

		return whosonfirst_spatial_do($cmd, $more);
	}
	
	########################################################################

	# THIS IS DEPRECATED - WAITING ON A REFEED OF THE TILE38 DATA
	# (20161011/thisisaaronland)

	function whosonfirst_spatial_append_names(&$rsp, $more=array()){

		$fields = $rsp['fields'];
		$fields[] = "wof:name";

		# What follows is written in a way that should make it easy to
		# support a 'tile38_do_multi' command once it's been written
		# (20160811/thisisaaronland)

		$cmds = array();
		$rsps = array();

		$count_objects = count($rsp['objects']);

		for ($i=0; $i < $count_objects; $i++){

			$row = $rsp['objects'][$i];
			list($id, $ignore) = explode("#", $row['id']);

			$key = "{$id}:name";
			$cmd = "GET __COLLECTION__ {$key}";

			$cmds[] = $cmd;
		}

		foreach ($cmds as $cmd){

			# Note the lack of error checking...
			
			$rsp2 = whosonfirst_spatial_do($cmd, $more);
			$rsps[] = $rsp2;
		}

		for ($i=0; $i < $count_objects; $i++){

			$rsp['objects'][$i]['fields'][] = $rsps[$i]['object'];
		}
	
		$rsp['fields'] = $fields;

		# pass-by-ref
	}

	########################################################################

	function whosonfirst_spatial_append_meta(&$rsp, $more=array()){

		$defaults = array(
			'meta_fields' => array('wof:name', 'wof:country')
		);

		$more = array_merge($defaults, $more);
		
		$fields = $rsp['fields'];

		foreach ($more['meta_fields'] as $f){
			$fields[] = $f;
		}

		# What follows is written in a way that should make it easy to
		# support a 'tile38_do_multi' command once it's been written
		# (20160811/thisisaaronland)

		$cmds = array();
		$rsps = array();

		$count_objects = count($rsp['objects']);

		# first construct all the requests
		
		for ($i=0; $i < $count_objects; $i++){

			$row = $rsp['objects'][$i];
			list($id, $ignore) = explode("#", $row['id']);

			$key = "{$id}:meta";
			$cmd = "GET __COLLECTION__ {$key}";

			$cmds[] = $cmd;
		}

		# execute all the requests (this is the do_multi bit)
		
		foreach ($cmds as $cmd){

			# Note the lack of error checking...
			
			$rsp2 = whosonfirst_spatial_do($cmd, $more);
			$rsps[] = $rsp2;
		}

		# parse all the requests
		
		for ($i=0; $i < $count_objects; $i++){

			# Note the lack of error checking...
			$obj = json_decode($rsps[$i]['object'], "as hash");

			foreach ($more['meta_fields'] as $f){
				$rsp['objects'][$i]['fields'][] = $obj[$f];
			}
		}
	
		$rsp['fields'] = $fields;

		# pass-by-ref
	}
	
	########################################################################

	function whosonfirst_spatial_do($cmd, $more=array()){

		$defaults = array(
			'host' => $GLOBALS['cfg']['spatial_tile38_host'],
			'port' => $GLOBALS['cfg']['spatial_tile38_port'],
			'collection' => $GLOBALS['cfg']['spatial_tile38_collection'],
		);

		$more = array_merge($defaults, $more);

		$cmd = str_replace("__COLLECTION__", $more['collection'], $cmd);

		$rsp = tile38_do($cmd, $more);

		$rsp['command'] = $cmd;
		return $rsp;
	}

	########################################################################

	function whosonfirst_spatial_inflate_results($rsp){

		# See this? It takes ~ 20-40 µs to fetch each name individually.
		# Which isn't very much even when added up. There are two considerations
		# here: 1) It's useful just to be able to append the name from the 
		# tile38 index itself 2) It might be just as fast to look up the
		# entire record from ES itself. Basically what I am trying to say is
		# that it's too soon so we're just going to do this for now...
		# (20160811/thisisaaronland)

		if ($GLOBALS['whosonfirst_spatial_properties_hack']){
			whosonfirst_spatial_append_names($rsp);
		}

		else {
			whosonfirst_spatial_append_meta($rsp);
		}

		$results = array();
		$cursor = null;			# PLEASE FIX ME
		
		$fields = $rsp['fields'];
		$count_fields = count($fields);

		foreach ($rsp['objects'] as $row){

			$geom = $row['object'];
			$coords = $geom['coordinates'];

			$props = array();

			if ($GLOBALS['whosonfirst_spatial_properties_hack']){

				$props = array(
					'wof:parent_id' => -1,
					'wof:country' => 'XN'
				);
			}

			for ($i=0; $i < $count_fields; $i++){
				$props[ $fields[$i] ] = $row['fields'][$i];
			}

			list($id, $repo) = explode("#", $row['id']);

			$placetype = whosonfirst_placetypes_id_to_name($props['wof:placetype_id']);
			
			$results[] = array(
				'wof:name' => $props['wof:name'],
				'wof:id' => $props['wof:id'],
				'wof:placetype' => $placetype,
				'wof:parent_id' => $props['wof:parent_id'],
				'wof:country' => $props['wof:country'],
				'wof:repo' => $repo,
				'geom:latitude' => $coords[1],
				'geom:longitude' => $coords[0],
			);
		}

		return array($results, $cursor);
	}

	########################################################################
	
	# the end
