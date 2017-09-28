window.addEventListener("load", function load(event){

	var cb = function(map){

		L.Mapzen.hash({
			map: map
		});

		var nearby_layer;

		var nearby = function(){

			var center = map.getCenter();

			var lat = center.lat;
			var lon = center.lng;

			var method = "whosonfirst.places.getNearby";

			var args = {
				"latitude": lat,
				"longitude": lon,
				"per_page": 500,
				"extras": "geom:",
			};

			var on_page = function(rsp){

				var features = [];

				var places = rsp["places"];
				var count_places = places.length;

				for (var i=0; i < count_places; i++){

					var place = places[i];

					var name = place["wof:name"];

					var lat = place["geom:latitude"];
					var lon = place["geom:longitude"];

					var coords = [ lon, lat ];

					var geom = {
						"type": "Point",
						"coordinates": coords,
					};

					var props = place;

					var feature = {
						"type": "Feature",
						"geometry": geom,
						"properties": props,
					};

					features.push(feature);
				}

				var feature_collection = {
					"type": "FeatureCollection",
					"features": features,
				};

				nearby_layer = mapzen.places.map.add_geojson_to_map(map, feature_collection);
			};

			var on_error = function(rsp) {
				console.error(rsp);
			};

			if (nearby_layer){
				nearby_layer.remove(map);
			}

			mapzen.places.api.call_paginated(method, args, on_page, on_error);
		};

		map.on("dragend", nearby);
		map.on("zoomend", nearby);

		nearby();
	};

	mapzen.places.map.draw_nearby_map("map", cb);
});
