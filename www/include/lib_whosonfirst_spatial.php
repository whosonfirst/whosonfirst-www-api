<?php

	loadlib("tile38");

	# A FEW IMPORTANT THINGS:
	#
	# 1. All of the requests here are using the Tile38 "POINTS" endpoint/hoohah. This
	#    is so that we (read: PHP) can actually return data from Tile38 without timing
	#    out. Go ahead, just try to return full geometries. I can wait 30 seconds...
	#
	# 2. The indexing logic is currently implemented in two places while the inflating
	#    logic is currently implemented once. Indexing happens in this library and also
	#    in the go-whosonfirst-tile38 package. Inflating happens in this library. It's
	#    also still a moving target. Specifically: Which fields do we index with the 
	#    geometry itself in Tile38 (these can only be numeric fields like wof:parent_id
	#    or mz:is_current) and which fields do we store separately in a 'WOFID#meta'
	#    entry in Tile38.
	#
	# 3. The entire practice of storing things in 'WOFID#meta' is open to debate since
	#    from the perspective of this library we need to query ES anyway if we want to
	#    support "?extras=foo,bar" (and we do). That said, the stuff in 'WOFID#meta' is
	#    there to ensure we can always generate a "minimum viable WOF result" using only
	#    Tile38 so maybe the practice just looks funny from this side of the fence but
	#    is otherwise perfectly reasonable.
	#
	# 4. More documentation (everywhere) please...
	#
	# (20161020/thisisaaronland)

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

		$rsp2 = whosonfirst_spatial_index_meta($props, $more);

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

		$defaults = array(
			'per_page' => $GLOBALS['cfg']['pagination_per_page'],
		);

		$more = array_merge($defaults, $more);

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

		if ($cursor = $more['cursor']){
			$cmd[] = "CURSOR {$cursor}";
		}

		$cmd[] = "LIMIT {$more['per_page']}";

		if (count($where)){
			$cmd[] = implode(" ", $where);
		}

		$cmd[] = "POINTS";

		$cmd = array_merge($cmd, array(
			"POINT", $lat, $lon, $r
		));

		$cmd = implode(" ", $cmd);

		return whosonfirst_spatial_do($cmd, $more);
	}

	########################################################################

	function whosonfirst_spatial_intersects($swlat, $swlon, $nelat, $nelon, $more=array()){

		$defaults = array(
			'per_page' => $GLOBALS['cfg']['pagination_per_page'],
			'placetype_id' => null,			
			'cursor' => null,
		);

		$more = array_merge($defaults, $more);

		# Basically make sure you are using Tile38 >= 1.5.2 because:
		# https://github.com/tidwall/tile38/issues/70

		# INTERSECTS searches a collection for objects that intersect a specified bounding area.
		# WITHIN and INTERSECTS have identical syntax. The only difference between the two is that
		# WITHIN returns objects that are contained inside an area, and intersects returns objects
		# that are contained or intersects an area.
		# 
		# http://tile38.com/commands/intersects/

		$cmd = array(
			"INTERSECTS __COLLECTION__",
		);
		
		if ($cursor = $more['cursor']){
			$cmd[] = "CURSOR {$cursor}";
		}

		$cmd[] = "LIMIT {$more['per_page']}";

		if ($pt = $more['placetype_id']){
			$cmd[] = "WHERE wof:placetype_id {$pt} ${pt}";
		}

		$cmd[] = "POINTS";

		$cmd[] = "BOUNDS {$swlat} {$swlon} {$nelat} {$nelon}";

		$cmd = implode(" ", $cmd);

		return whosonfirst_spatial_do($cmd, $more);
	}

	########################################################################

	function whosonfirst_spatial_index_meta(&$props, $more=array()){

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

		$count_points = count($rsp['points']);

		# first construct all the requests
		
		for ($i=0; $i < $count_points; $i++){

			$row = $rsp['points'][$i];
			list($id, $ignore) = explode("#", $row['id']);

			$key = "{$id}#meta";
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
		
		for ($i=0; $i < $count_points; $i++){

			# Note the lack of error checking...
			$obj = json_decode($rsps[$i]['object'], "as hash");

			foreach ($more['meta_fields'] as $f){
				$rsp['points'][$i]['fields'][] = $obj[$f];
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

		whosonfirst_spatial_append_meta($rsp);

		$results = array();
		$cursor = $rsp['cursor'];
		
		$fields = $rsp['fields'];
		$count_fields = count($fields);

		foreach ($rsp['points'] as $row){

			$pt = $row['point'];

			# $geom = $row['object'];
			# $coords = $geom['coordinates'];

			$props = array();

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
				'geom:latitude' => $pt['lat'],
				'geom:longitude' => $pt['lon'],
			);
		}

		return array($results, $cursor);
	}

	########################################################################
	
	# the end
