window.addEventListener("load", function load(event){

	var no_results = document.querySelector('#no-results');
	var loading_results = document.querySelector('#loading-results');
	var num_results = document.querySelector('#num-results');
	var results_table = document.querySelector('#search-results');
	var results_tbody = results_table.querySelector('tbody');
	var result_template = document.querySelector('#result-template');
	var abs_root_url = document.body.getAttribute("data-abs-root-url");

	function add_geojson_to_results_table(geojson){

		for (var i = 0; i < geojson.features.length; i++){

			var feature = geojson.features[i];
			var props = feature.properties;
			var tr = result_template.cloneNode(true);

			results_tbody.appendChild(tr);
			tr.className = 'results-item';

			var esc_id = htmlspecialchars(props['wof:id']);
			tr.querySelector('.id').innerHTML = esc_id;

			var esc_name = htmlspecialchars(props['wof:name']);
			var esc_href = htmlspecialchars(abs_root_url + 'id/' + props['wof:id'] + '/');
			tr.querySelector('.name').innerHTML = esc_name;
			tr.querySelector('.name').setAttribute('href', esc_href);

			var esc_pt = htmlspecialchars(props['wof:placetype']);
			tr.querySelector('.placetype').innerHTML = esc_pt;

			var currentness = 'unknown';
			if (mapzen.whosonfirst.existential.is_current(props)){
				currentness = 'current';
			}
			else if (mapzen.whosonfirst.existential.is_deprecated(props)){
				currentness = 'deprecated';
			}
			else if (mapzen.whosonfirst.existential.is_ceased(props)){
				currentness = 'ceased';
			}
			else if (mapzen.whosonfirst.existential.is_superseded(props)){
				currentness = 'superseded';
			}
			tr.querySelector('.currentness').innerHTML = currentness;

			if (currentness != 'current'){
				// Remove 'hidden' class from 'not current' label
				tr.querySelector('.not-current').className = 'not-current';
			}

			var country_code = props['iso:country'];
			if (typeof whosonfirst_countries[country_code] != 'undefined'){
				var country = whosonfirst_countries[country_code];
				var country_id = htmlspecialchars(country['wof:id']);
				var country_name = htmlspecialchars(country['wof:name']);
				var country_link = '<a href="' + abs_root_url + 'id/' + country_id + '">' + country_name + '</a>';
				tr.querySelector('.country').innerHTML = country_link;
			}
		}
		results_table.className = 'table';
		loading_results.className = 'hidden';
		no_results.className = 'hidden';

		var num = results_tbody.querySelectorAll('tr').length;
		num_results.innerHTML = num.toLocaleString() + ' results';
		num_results.className = '';
	}

	var cb = function(map){

		L.Mapzen.hash({
			map: map
		});

		var nearby_layer;

		var nearby_clear = function(){
			if (nearby_layer){
				nearby_layer.remove(map);
			}
			no_results.className = '';
			results_table.className = 'hidden';
			results_tbody.innerHTML = '';
			num_results.className = 'hidden';
		};

		var nearby = function(){

			var center = map.getCenter();

			var lat = center.lat;
			var lon = center.lng;

			var method = "whosonfirst.places.getNearby";

			var args = {
				"latitude": lat,
				"longitude": lon,
				"per_page": 500,
				"extras": "geom:,iso:country,lbl:,mz:is_current,edtf:,wof:superseded_by",
			};

			var on_page = function(rsp){

				var features = [];

				var places = rsp["places"];
				var count_places = places.length;

				for (var i=0; i < count_places; i++){

					var place = places[i];

					var name = place["wof:name"];

					var coords = mapzen.places.map.get_place_coords(place);
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

				nearby_layer = mapzen.places.map.add_geojson_clusters_to_map(map, feature_collection);
				add_geojson_to_results_table(feature_collection);
			};

			var on_error = function(rsp) {
				console.error(rsp);
			};

			nearby_clear();

			loading_results.className = '';
			no_results.className = 'hidden';

			mapzen.places.api.call_paginated(method, args, on_page, on_error);
		};

		//map.on("dragend", nearby);
		//map.on("zoomend", nearby);

		nearby();

		var locate = L.control.locate({
			setView: 'once',
			drawCircle: false,
			drawMarker: false,
			locateOptions: {
				maxZoom: 16
			}
		}).addTo(map);

		var btn = document.getElementById('nearby-find');
		btn.addEventListener('click', function(e) {

			e.preventDefault();
			var css = btn.className + '';
			if (css.indexOf('disabled') != -1) {
				return;
			}

			btn.className = css + ' disabled';
			locate.start();

		}, false);

		map.on({
			locationfound: function(location) {
				locate.stop();
				var css = btn.className + '';
				btn.className = css.replace('disabled', '');
				map.setView([location.latitude, location.longitude], 16);
				nearby();
			},
			locationerror: function() {
				var css = btn.className + '';
				btn.className = css.replace('disabled', '');
			}
		});
	};

	mapzen.places.map.draw_nearby_map("map", cb);
});
