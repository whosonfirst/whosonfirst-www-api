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
					var lat = position.coords.latitude.toFixed(6);
					var lon = position.coords.longitude.toFixed(6);
					go_set_inputs(lat + ', ' + lon);
				});
			}
			else {
				alert('Your browser does not support geolocation.');
			}
		};

		var go_set_inputs = function(from, type){
			if (type){
				var select = document.getElementById('go-costing');
				for (var i = 0; i < select.options.length; i++){
					if (select.options[i].value == type){
						select.selectedIndex = i;
						break;
					}
				}
			}
			if (from){
				document.getElementById('go-from').value = from;
			}
			document.getElementById('go-inputs').className = 'row';
			document.getElementById('go-feedback').className = 'hidden';
		};

		var go_directions = function(from, type){

			var latlon = from.split(',');
			var lat = parseFloat(latlon[0].trim());
			var lon = parseFloat(latlon[1].trim());

			if (isNaN(lat) || isNaN(lon)){
				go_set_inputs('', type);
				return "Invalid latitude/longitude starting point.";
			}
			go_set_inputs(from, type);
			var from = L.latLng(lat, lon);

			var costings = {
				walking: 'pedestrian',
				biking: 'bicycle',
				transit: 'multimodal',
				driving: 'auto'
			};
			if (! costings[type]){
				return "Unknown directions method '" + htmlspecialchars(type) + "'";
			}

			var lat = document.querySelector('*[itemprop="latitude"').innerHTML;
			var lon = document.querySelector('*[itemprop="longitude"').innerHTML;
			var lat = parseFloat(lat);
			var lon = parseFloat(lon);
			if (isNaN(lat) || isNaN(lon)){
				return "Invalid latitude/longitude destination.";
			}
			var to = L.latLng(lat, lon);

			// Show directions pane, in case we hid it before
			var lrm = document.body.querySelector('.leaflet-routing-container');
			if (lrm){
				var classes = lrm.className + '';
				lrm.className = classes.replace('hidden', '');
			}

			var routingControl = L.Mapzen.routing.control({
				waypoints: [from, to],
				router: L.Mapzen.routing.router({
					costing: costings[type]
				}),
				defaultErrorHandler: function(e){
					if (e.error &&
					    e.error.message){
						// yeah, we get a JSON blob passed back, which is weird
						try {
							var msg = JSON.parse(e.error.message);
						}
						catch (e){
							console.error(e);
						}
						var feedback = document.getElementById('go-feedback');
						feedback.innerHTML = htmlspecialchars(msg.error);
						feedback.className = 'alert alert-danger';

						// Hide directions pane, since we don't have any
						var lrm = document.body.querySelector('.leaflet-routing-container');
						if (lrm){
							var classes = lrm.className + '';
							lrm.className = classes + ' hidden';
						}
					}
				}
			}).addTo(map);

			return true;
		};

		document.getElementById('go-geolocate').addEventListener('click', go_geolocate_click, false);
		document.getElementById('go-show-latlon').addEventListener('click', function(e){
			e.preventDefault();
			document.getElementById('go-from').select();
			go_set_inputs();
		}, false);

		var args = {};
		var query = window.location.search.substr(1).split('&');
		for (var key, val, keyval, i = 0; i < query.length; i++){
			keyval = query[i].split('=');
			key = decodeURIComponent(keyval[0].replace(/\+/g, ' '));
			val = decodeURIComponent(keyval[1].replace(/\+/g, ' '));
			args[key] = val;
		}
		if (args.directions &&
		    args.from){
			var result = go_directions(args.from, args.directions);
			if (typeof result == "string"){
				var alert = document.getElementById('go-feedback');
				alert.innerHTML = htmlspecialchars(result);
				alert.className = 'alert alert-danger';
			}
		}
	};

	mapzen.places.map.draw_place_map("map", cb);

});
