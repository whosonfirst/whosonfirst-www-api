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

		var units = 'metric';
		if ("localStorage" in window &&
		    localStorage.units){
			units = localStorage.units;
		}
		else {
			fetch('https://ip.dev.mapzen.com/?raw=1', function(rsp) {
				units = get_default_units(rsp.country_id);
			});
		}

		var go_start_loading = function(){
			var btn = document.getElementById('go-btn');
			var classes = btn.className + '';
			btn.className = classes + ' disabled';
			btn.value = 'Loading...';
		};

		var go_is_loading = function(){
			var btn = document.getElementById('go-btn');
			var classes = btn.className + '';
			return classes.indexOf('disabled') != -1;
		};

		var go_done_loading = function(){
			var btn = document.getElementById('go-btn');
			var classes = btn.className + '';
			btn.className = classes.replace('disabled', '');
			btn.value = 'Get Directions';
		}

		var go_geolocate_click = function(e){
			e.preventDefault();
			if (go_is_loading()) {
				return;
			}
			go_start_loading();
			if ("geolocation" in navigator){
				navigator.geolocation.getCurrentPosition(function(position) {
					var lat = position.coords.latitude.toFixed(6);
					var lon = position.coords.longitude.toFixed(6);
					var from = lat + ', ' + lon;
					var type = 'driving';
					if ("localStorage" in window &&
					    localStorage.directions){
						type = localStorage.directions;
					}
					go_show_inputs(from);
					go_directions(from);
				});
			}
			else {
				alert('Your browser does not support geolocation.');
				go_done_loading();
			}
		};

		var go_show_inputs = function(from, type){
			if (! type){
				type = get_default_type();
			}
			var select = document.getElementById('go-costing');
			for (var i = 0; i < select.options.length; i++){
				if (select.options[i].value == type){
					select.selectedIndex = i;
					break;
				}
			}

			if (from){
				document.getElementById('go-from').value = from;
			}
			document.getElementById('go-inputs').className = 'row';
			document.getElementById('go-feedback').className = 'hidden';
		};

		var go_adjust_bounds = function(){

			// Adapted from https://mapzen.com/resources/projects/turn-by-turn/demo/demo.js

			// Adjust padding for fitBounds()
			// ==============================
			//
			// See this discussion: https://github.com/perliedman/leaflet-routing-machine/issues/60
			// We override Leaflet's default fitBounds method to use our padding options by
			// default. Thus, LRM calls fitBounds() as is. Additionally, any other scripts
			// that call for fitBounds() can take advantage of the same padding behaviour.

			var is_mobile = (window.innerWidth < 472);
			var bounds_tl = is_mobile ? [15, 200] : [30, 30];
			var bounds_br = is_mobile ? [15, 15] : [328, 30];

			map.origFitBounds = map.fitBounds;
			map.fitBounds = function (bounds, options) {
				map.origFitBounds(bounds, {
					// Left padding accounts for the narrative window.
					// Top padding accounts for the floating section navigation bar.
					// These conditions apply only when the viewport breakpoint is at
					// desktop screens or higher. Otherwise, assume that the narrative
					// window is not present, and that the section navigation is
					// condensed, so less padding is required on mobile viewports.
					paddingTopLeft: bounds_tl,
					// Bottom and right padding accounts only for slight
					// breathing room, in order to prevent markers from appearing
					// at the very edge of maps.
					paddingBottomRight: bounds_br,
				});
			};

			// Adjust offset for panTo()
			// ==============================
			map.origPanTo = map.panTo;
			// In LRM, coordinate is array format [lat, lng]
			map.panTo = function (coordinate) {
				var offset_x = Math.round((bounds_tl[0] - bounds_br[0]) / 2);
				var offset_y = Math.round((bounds_tl[1] - bounds_br[1]) / 2);
				var x = map.latLngToContainerPoint(coordinate).x - offset_x;
				var y = map.latLngToContainerPoint(coordinate).y - offset_y;
				var point = map.containerPointToLatLng([x, y]);
				map.origPanTo(point);
			};
		};

		var go_routing_error = function(e){
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
				feedback.className = 'alert alert-danger headroom';

				// Hide directions pane, since we don't have any
				var lrm = document.body.querySelector('.leaflet-routing-container');
				if (lrm){
					var classes = lrm.className + '';
					lrm.className = classes + ' hidden';
				}
			}
		};

		var go_directions = function(from, type){

			if (! type){
				type = get_default_type();
			}
			else {
				set_default_type(type);
			}

			var latlon = from.split(',');
			if (latlon.length == 2){
				var lat = parseFloat(latlon[0].trim());
				var lon = parseFloat(latlon[1].trim());
			}

			if (isNaN(lat) || isNaN(lon)){
				go_show_inputs('', type);
				return "Invalid latitude/longitude starting point.";
			}
			go_show_inputs(from, type);
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

			go_adjust_bounds();
			var routingControl = L.Mapzen.routing.control({
				waypoints: [from, to],
				fitSelectedRoutes: true,
				router: L.Mapzen.routing.router({
					costing: costings[type]
				}),
				formatter: new L.Mapzen.routing.formatter({
					units: units
				}),
				defaultErrorHandler: go_routing_error
			}).addTo(map);
			routingControl.on('routesfound', function(){
				go_done_loading();
			});

			return true;
		};

		var go_show_inputs_click = function(e){
			e.preventDefault();
			setTimeout(function(){
				var from = document.getElementById('go-from');
				if (from.value == ''){
					from.focus();
				}
				else {
					from.select();
				}
			}, 0);
			go_show_inputs();
		};

		document.getElementById('go-geolocate').addEventListener('click', go_geolocate_click, false);
		document.getElementById('go-show-inputs').addEventListener('click', go_show_inputs_click, false);

		var args = {};
		var query = window.location.search.substr(1).split('&');
		for (var key, val, keyval, i = 0; i < query.length; i++){
			keyval = query[i].split('=');
			if (keyval.length == 2){
				key = decodeURIComponent(keyval[0].replace(/\+/g, ' '));
				val = decodeURIComponent(keyval[1].replace(/\+/g, ' '));
				args[key] = val;
			}
		}
		if (args.directions &&
		    args.from){
			go_start_loading();
			var result = go_directions(args.from, args.directions);
			if (typeof result == "string"){
				var alert = document.getElementById('go-feedback');
				alert.innerHTML = htmlspecialchars(result);
				alert.className = 'alert alert-danger headroom';
			}
		}
	};

	mapzen.places.map.draw_place_map("map", cb);

	function get_default_units(country_id){
		var units = 'metric';
		if (country_id == 85633793 || // USA
		    country_id == 85632181 || // Myanmar
		    country_id == 85632249){  // Liberia
			units = 'imperial';
		}
		if ("localStorage" in window){
			localStorage.units = units;
		}
		return units;
	}

	function get_default_type(){
		var type = 'driving';
		if ("localStorage" in window &&
		    localStorage.directions){
			type = localStorage.directions;
		}
		return type;
	}

	function set_default_type(type){
		if ("localStorage" in window){
			localStorage.directions = type;
		}
		return type;
	}

});
