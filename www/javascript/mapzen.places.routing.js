var mapzen = mapzen || {};
mapzen.places = mapzen.places || {};

mapzen.places.routing = (function(){

	var self = {

		'init': function(map){
			self.map = map;
			self.setup_units();
			self.setup_controls();
			self.check_url();
		},

		'setup_units': function(){
			var units = 'metric';
			if ("localStorage" in window &&
			    localStorage.units){
				units = localStorage.units;
			}
			else {
				self.fetch('https://ip.dev.mapzen.com/?raw=1', function(rsp) {
					self.units = self.get_default_units(rsp.country_id);
					if ("localStorage" in window){
						localStorage.units = self.units;
					}
				});
			}
			self.units = units;
		},

		'setup_controls': function(){
			document.getElementById('go-geolocate').addEventListener('click', self.geolocate_click, false);
			document.getElementById('go-show-inputs').addEventListener('click', self.show_inputs_click, false);
		},

		'check_url': function(){
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
				self.start_loading();
				var result = self.get_directions(args.from, args.directions);
				if (typeof result == "string"){
					var alert = document.getElementById('go-feedback');
					alert.innerHTML = htmlspecialchars(result);
					alert.className = 'alert alert-danger headroom';
				}
			}
		},

		'start_loading': function(){
			var btn = document.getElementById('go-btn');
			var classes = btn.className + '';
			btn.className = classes + ' disabled';
			btn.value = 'Loading...';
		},

		'is_loading': function(){
			var btn = document.getElementById('go-btn');
			var classes = btn.className + '';
			return classes.indexOf('disabled') != -1;
		},

		'done_loading': function(){
			var btn = document.getElementById('go-btn');
			var classes = btn.className + '';
			btn.className = classes.replace('disabled', '');
			btn.value = 'Get Directions';
		},

		'geolocate_click': function(e){
			e.preventDefault();
			if (self.is_loading()) {
				return;
			}
			self.start_loading();
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
					self.show_inputs(from);
					self.get_directions(from);
				});
			}
			else {
				alert('Your browser does not support geolocation.');
				self.done_loading();
			}
		},

		'show_inputs': function(from, type){
			if (! type){
				type = self.get_default_type();
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
		},

		'adjust_bounds': function(){

			// Adapted from https://mapzen.com/resources/projects/turn-by-turn/demo/demo.js

			// Adjust padding for fitBounds()
			// ==============================
			//
			// See this discussion: https://github.com/perliedman/leaflet-routing-machine/issues/60
			// We override Leaflet's default fitBounds method to use our padding options by
			// default. Thus, LRM calls fitBounds() as is. Additionally, any other scripts
			// that call for fitBounds() can take advantage of the same padding behaviour.

			var map = self.map;

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
		},

		'routing_error': function(e){
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
		},

		'get_directions': function(from, type){

			if (! type){
				type = self.get_default_type();
			}
			else {
				self.set_default_type(type);
			}

			var latlon = from.split(',');
			if (latlon.length == 2){
				var lat = parseFloat(latlon[0].trim());
				var lon = parseFloat(latlon[1].trim());
			}

			if (isNaN(lat) || isNaN(lon)){
				self.show_inputs('', type);
				return "Invalid latitude/longitude starting point.";
			}
			self.show_inputs(from, type);
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

			self.adjust_bounds();
			var routingControl = L.Mapzen.routing.control({
				waypoints: [from, to],
				fitSelectedRoutes: true,
				router: L.Mapzen.routing.router({
					costing: costings[type]
				}),
				formatter: new L.Mapzen.routing.formatter({
					units: self.units
				}),
				defaultErrorHandler: self.routing_error
			}).addTo(self.map);
			routingControl.on('routesfound', function(){
				self.done_loading();
			});

			return true;
		},

		'show_inputs_click': function(e){
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
			self.show_inputs();
		},

		'fetch': function(url, onsuccess, onerror){

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
		},

		'get_default_units': function(country_id){
			var units = 'metric';
			if (country_id == 85633793 || // USA
			    country_id == 85632181 || // Myanmar
			    country_id == 85632249){  // Liberia
				units = 'imperial';
			}
			return units;
		},

		 'get_default_type': function(){
			var type = 'driving';
			if ("localStorage" in window &&
			    localStorage.directions){
				type = localStorage.directions;
			}
			return type;
		},

		'set_default_type': function(type){
			if ("localStorage" in window){
				localStorage.directions = type;
			}
			return type;
		}
	};

	return self;

})();
