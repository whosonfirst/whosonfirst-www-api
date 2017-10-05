window.addEventListener("load", function load(event){

	var fetch = function(url, onsuccess, onerror){

		var req = new XMLHttpRequest();

		req.onload = function(){

			var feature;

			try {
				feature = JSON.parse(this.responseText);
			}

			catch (e){
				onerror(e);
				return false;
			}

			onsuccess(feature);
		};

		req.open("get", url, true);
		req.send();
	};

	var cb = function(map){

		var map_el = document.getElementById("map");
		var wof_id = map_el.getAttribute("data-wof-id");
		var wof_parent_id = map_el.getAttribute("data-wof-parent-id");
		var wof_placetype = map_el.getAttribute("data-wof-placetype");

		var abs_path = mapzen.whosonfirst.uri.id2abspath(wof_id);

		var onsuccess = function(feature){
			var layer = mapzen.places.map.add_geojson_to_map(map, feature);
		};

		var onerror = function(rsp){
			console.log("ERROR", rsp);
		};

		fetch(abs_path, onsuccess, onerror);

		if (wof_placetype == "venue"){

			var abs_path = mapzen.whosonfirst.uri.id2abspath(wof_parent_id);
			fetch(abs_path, onsuccess, onerror);
		}

		var go_geolocate_click = function(e){
			e.preventDefault();
			if ("geolocation" in navigator){
				navigator.geolocation.getCurrentPosition(function(position) {
					go_set_latlon(position.coords.latitude, position.coords.longitude);
				});
			}
			else {
				alert('Your browser does not support geolocation.');
			}
		};

		var go_set_latlon = function(lat, lon){
			if (lat){
				lat = parseFloat(lat);
				lat = lat.toFixed(6);
				document.getElementById('go-latitude').value = lat;
			}
			if (lon){
				lon = parseFloat(lon);
				lon = lon.toFixed(6);
				document.getElementById('go-longitude').value = lon;
			}
			document.getElementById('go-latlon').className = 'row';
		};

		var go_directions = function(type, lat, lon){

			go_set_latlon(lat, lon);
			var select = document.getElementById('go-costing');
			for (var i = 0; i < select.options.length; i++){
				if (select.options[i].value == type){
					select.selectedIndex = i;
					break;
				}
			}

			var costings = {
				walking: 'pedestrian',
				biking: 'bicycle',
				transit: 'multimodal',
				driving: 'auto'
			};
			if (! costings[type]){
				return "Unknown directions method '" + htmlspecialchars(type) + "'";
			}

			var lat = parseFloat(lat);
			var lon = parseFloat(lon);
			if (isNaN(lat) || isNaN(lon)){
				return "Invalid latitude/longitude starting point.";
			}
			var from = L.latLng(lat, lon);

			var lat = document.querySelector('*[itemprop="latitude"').innerHTML;
			var lon = document.querySelector('*[itemprop="longitude"').innerHTML;
			var lat = parseFloat(lat);
			var lon = parseFloat(lon);
			if (isNaN(lat) || isNaN(lon)){
				return "Invalid latitude/longitude destination.";
			}
			var to = L.latLng(lat, lon);

			var routingControl = L.Mapzen.routing.control({
				waypoints: [from, to],
				router: L.Mapzen.routing.router({
					costing: costings[type]
				})
			}).addTo(map);
		};

		document.getElementById('go-geolocate').addEventListener('click', go_geolocate_click, false);
		document.getElementById('go-show-latlon').addEventListener('click', function(e){
			e.preventDefault();
			go_set_latlon();
		}, false);

		var args = {};
		var query = window.location.search.substr(1).split('&');
		for (var key, val, keyval, i = 0; i < query.length; i++){
			keyval = query[i].split('=');
			key = decodeURIComponent(keyval[0]);
			val = decodeURIComponent(keyval[1]);
			args[key] = val;
		}
		if (args.directions &&
		    args.from_lat &&
		    args.from_lon){
			go_directions(args.directions, args.from_lat, args.from_lon);
		}
	};

	mapzen.places.map.draw_place_map("map", cb);

});
