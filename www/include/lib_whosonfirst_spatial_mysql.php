<?php

	# As of this writing this library assumes a database table named "whosonfirst" that 
	# has been indexed with https://github.com/whosonfirst/go-whosonfirst-mysql - while
	# it's entirely possible that absolutely nothing about that set up will change... it
	# is still posssible that it might (change) so adjust all the things accordingly
	# (20180236/thisisaaronland)

	# See also:
	# https://dev.mysql.com/doc/refman/5.7/en/spatial-function-reference.html

	########################################################################

	function whosonfirst_spatial_mysql_point_in_polygon($lat, $lon, $more=array()){

		$enc_lat = AddSlashes($lat);
		$enc_lon = AddSlashes($lon);

		$wkt = "POINT({$enc_lon} {$enc_lat})";

		$query = array(
			"ST_Within(GeomFromText('{$wkt}', 4326), geometry)",
		);

		$possible = array(
			# "wof:id",
			"wof:placetype",
			"mz:is_current",
			"mz:is_deprecated",
			"mz:is_ceased",
			# "mz:is_superseded",
			# "mz:is_superseding",
		);

		whosonfirst_spatial_mysql_apply_query_filters($query, $possible, $more);

		$where = implode($query, " AND ");

		$sql = "SELECT id FROM whosonfirst WHERE ${where}";

		return whosonfirst_spatial_mysql_fetch($sql, $more);
	}

	########################################################################

	function whosonfirst_spatial_mysql_nearby($lat, $lon, $r, $more=array()){

		$enc_lat = AddSlashes($lat);
		$enc_lon = AddSlashes($lon);

		$wkt = "POINT({$enc_lon} {$enc_lat})";

		$enc_r = AddSlashes($r);

		$query = array(
			"ST_Distance_Sphere(ST_GeomFromText('{$wkt}'), centroid) <= {$enc_r}",
		);

		$possible = array(
			# "wof:id",
			"wof:placetype",
			"mz:is_current",
			"mz:is_deprecated",
			"mz:is_ceased",
			# "mz:is_superseded",
			# "mz:is_superseding",
		);

		whosonfirst_spatial_mysql_apply_query_filters($query, $possible, $more);

		$where = implode($query, " AND ");

		$sql = "SELECT id FROM whosonfirst WHERE ${where}";
		return whosonfirst_spatial_mysql_fetch($sql, $more);
	}

	########################################################################

	function whosonfirst_spatial_mysql_intersects($swlat, $swlon, $nelat, $nelon, $more=array()){

		$enc_swlat = AddSlashes($swlat);
		$enc_swlon = AddSlashes($swlon);
		$enc_nelat = AddSlashes($nelat);
		$enc_nelon = AddSlashes($nelon);

		$enc_sw = "{$enc_swlon} {$enc_swlat}";
		$enc_nw = "{$enc_swlon} {$enc_nelat}";
		$enc_ne = "{$enc_nelon} {$enc_nelat}";
		$enc_se = "{$enc_nelon} {$enc_swlat}";

		$wkt = "POLYGON(({$enc_sw}, {$enc_nw}, {$enc_ne}, {$enc_se}, {$enc_sw}))";

		$query = array(
			"ST_Intersects(GeomFromText('{$wkt}', 4326), geometry)",
		);

		$possible = array(
			# "wof:id",
			"wof:placetype",
			"mz:is_current",
			"mz:is_deprecated",
			"mz:is_ceased",
			# "mz:is_superseded",
			# "mz:is_superseding",
		);

		whosonfirst_spatial_mysql_apply_query_filters($query, $possible, $more);

		$where = implode($query, " AND ");

		$sql = "SELECT id FROM whosonfirst WHERE ${where}";
		return whosonfirst_spatial_mysql_fetch($sql, $more);
	}

	########################################################################

	function whosonfirst_spatial_mysql_polyline($polyline, $more=array()){

		return array("ok" => 0, "error" => "Please write me");
	}

	########################################################################

	function whosonfirst_spatial_mysql_nearby_feature(&$feature, $more=array()){

		$props = $feature['properties'];

		# sudo make me a function to pick the best coordinate for
		# nearby-iness (20160811/thisisaaronland)

		$lat = $props['geom:latitude'];
		$lon = $props['geom:longitude'];

		$r = 100;

		return whosonfirst_spatial_mysql_nearby($lat, $lon, $r, $more);
	}

	########################################################################

	function whosonfirst_spatial_mysql_fetch($sql, $more=array()){

		$rsp = db_fetch_whosonfirst_paginated($sql, $more);

		# dumper($sql);
		# dumper($rsp);

		if ($rsp["ok"]){
			whosonfirst_spatial_mysql_prepare_rsp($rsp);
		}

		return $rsp;
	}

	########################################################################

	function whosonfirst_spatial_mysql_apply_query_filters(&$query, $possible, $candidates){

		foreach ($possible as $k){

			if (! isset($candidates[$k])){
				continue;
			}

			$v = $candidates[$k];

			if (strval($v) == ""){
				continue;
			}

			$enc_v = AddSlashes($v);

			# THIS IS A HACK WHILE I FIGURE OUT HOW TO WRANGLE NAMESPACED
			# PROPERTIES AND MYSQL... (20180426/thisisaaronland)

			$parts = explode(":", $k, 2);

			if (count($parts) == 2){
				$k = $parts[1];
			}			   

			$query[] = "`{$k}` = '{$enc_v}'";
		}

		# pass-by-ref
	}

	########################################################################

	function whosonfirst_spatial_mysql_prepare_rsp(&$rsp){

		# this is a kludge to account for the part where asking for
		# "SELECT id AS `wof:id`" causes the pagination COUNT() logic
		# (in lib_db.php) to generate bunk SQL (20180426/thisisaaronland)

		foreach ($rsp["rows"] as &$row){
			$row["wof:id"] = $row["id"];
			unset($row["id"]);
		}

		# pass-by-ref
	}

	########################################################################

	# the end