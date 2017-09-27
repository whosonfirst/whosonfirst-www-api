window.addEventListener("load", function load(event){

	if (! document.getElementById('map')) {
		return;
	}
	var map = mapzen.places.map.get_map("map");

	// We use a mock GeoJSON FeatureCollection to derive the bbox
	var geojson = {
		type: "FeatureCollection",
		features: []
	};

	var results = document.querySelectorAll('li.results-item');
	for (var i = 0; i < results.length; i++) {
		var item = results[i];
		var lat = parseFloat(item.getAttribute('data-geom-latitude'));
		var lng = parseFloat(item.getAttribute('data-geom-longitude'));
		var name = item.querySelector('a[itemprop="name"]').innerHTML;
		var feature = {
			type: "Feature",
			bbox: [lng, lat, lng, lat],
			properties: {
				"wof:id": item.getAttribute('data-wof-id'),
				"wof:name": name
			},
			geometry: {
				type: "Point",
				coordinates: [lng, lat]
			}
		};
		geojson.features.push(feature);
		mapzen.places.map.add_geojson_to_map(map, feature);
	}

	var bbox = mapzen.whosonfirst.geojson.derive_bbox(geojson);
	if (bbox[0] == bbox[2] && bbox[1] == bbox[3]) {
		map.setView([bbox[1], bbox[0]], 16);
	}

	else {
		var sw = L.latLng(bbox[1], bbox[0]);
		var ne = L.latLng(bbox[3], bbox[2]);

		var bounds = L.latLngBounds(sw, ne);
		var opts = { "padding": [100, 100] };

		map.fitBounds(bounds, opts);
	}

}, false);
