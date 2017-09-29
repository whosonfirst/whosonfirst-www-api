var mapzen = mapzen || {};
mapzen.places = mapzen.places || {};

mapzen.places.map = (function(){

	var maps = {};

	var self = {

		'get_map': function(map_id){

			if (! maps[map_id]){

				var api_key = document.body.getAttribute("data-mapzen-api-key");
				var abs_root_url = document.body.getAttribute("data-abs-root-url");

				L.Mapzen.apiKey = api_key;

				var map = L.Mapzen.map(map_id, {
					zoomControl: false,
					// https://github.com/mapzen/mapzen.js/blob/master/src/js/components/tangram.js
					tangramOptions: {
						//scene: L.Mapzen.BasemapStyles.Refill,
						scene: abs_root_url + "tangram/refill-style.zip",
						tangramURL: abs_root_url + "javascript/tangram.min.js"
					}
				});

				L.control.zoom({
					position: 'topleft'
				}).addTo(map);

				maps[map_id] = map;
			}

			return maps[map_id];
		},

		'draw_nearby_map': function(map_id, cb){

			var map_el = document.getElementById(map_id);
			var map = self.get_map(map_id);

			if (map_el.getAttribute("data-wof-id")){
				return self.draw_place_map(map_id, cb);
			}

			map.setView([37.7749, -122.4194], 12);

			cb(map);
		},

		'draw_place_map': function(map_id, cb){

			var map_el = document.getElementById(map_id);
			var map = self.get_map(map_id);

			var placetype = map_el.getAttribute("data-wof-placetype");

			var lat = map_el.getAttribute("data-geom-latitude");
			var lon = map_el.getAttribute("data-geom-longitude");

			lat = parseFloat(lat);
			lon = parseFloat(lon);

			var bbox = map_el.getAttribute("data-geom-bbox");
			bbox = bbox.split(",");

			var min_lon = parseFloat(bbox[0]);
			var min_lat = parseFloat(bbox[1]);
			var max_lon = parseFloat(bbox[2]);
			var max_lat = parseFloat(bbox[3]);

			if (placetype == "venue"){

				var parent_bbox = map_el.getAttribute("data-parent-geom-bbox");
				parent_bbox = parent_bbox.split(",");

				if (parent_bbox.length == 4){
					min_lon = parseFloat(parent_bbox[0]);
					min_lat = parseFloat(parent_bbox[1]);
					max_lon = parseFloat(parent_bbox[2]);
					max_lat = parseFloat(parent_bbox[3]);
				}
			}

			if ((min_lat == max_lat) && (min_lon == max_lon)){

				var zoom = 12;

				if (placetype == "venue"){
					zoom = 16;
				}

				map.setView([lat, lon], zoom);
			}

			else {
				var sw = L.latLng(min_lat, min_lon);
				var ne = L.latLng(max_lat, max_lon);

				var bounds = L.latLngBounds(sw, ne);
				var opts = { "padding": [100, 100] };

				map.fitBounds(bounds, opts);
			}

			// this doesn't work well enough to use yet...

			/*
			var abs_root_url = document.body.getAttribute("data-abs-root-url");

			var opts = {
				"url": abs_root_url + "pelias/v1",
				"focus": false,
				"panToPoint": false,
			};

			var geocoder = L.Mapzen.geocoder(opts);
			geocoder.addTo(map);
			*/

			cb(map);
		},

		'add_geojson_to_map': function(map, geojson, more){

			if (! more){
				more = {};
			}

			var point_color = "#0BBDFF";
			if (document.body.className.indexOf('places') != -1) {
				// https://mapzen.com/common/styleguide/design-elements.html#colors
				point_color = '#ff4947';
			}

			var point_style = {
				"color": "#000",
				"weight": 2,
				"opacity": 1,
				"radius": 6,
				"fillColor": point_color,
				"fillOpacity": 1
			};

			var point_handler = function(feature, latlon){

				var props = feature['properties'];
				var label = props['wof:name'];

				var m = L.circleMarker(latlon, point_style);
				m.bindTooltip(label);

				return m;
			};

			var feature_handler = function(feature, layer) {

				var props = feature['properties'];
				var wofid = props["wof:id"];

				layer.on('click', function (e){

					var enc_id = encodeURIComponent(wofid);

					var abs_root_url = document.body.getAttribute("data-abs-root-url");
					var url = abs_root_url + "id/" + enc_id + "/";

					location.href = url;
				});

			};

			var args = {
				"pointToLayer": point_handler,
				"onEachFeature": feature_handler,
			}

			// console.log("[map][geojson] ADD", geojson, args);

			var layer = L.geoJSON(geojson, args);

			// http://leafletjs.com/reference-1.1.0.html#layergroup-setzindex
			// https://github.com/Leaflet/Leaflet/issues/3427 (sigh...)

			if (more["z-index"]){
				var z = layer.setZIndex(more["z-index"]);
			}

			return layer.addTo(map);
		},

		'get_place_coords': function(place){

			var lat = null;
			var lon = null;

			if ('lbl:latitude' in place){
				lat = place['lbl:latitude'];
			} else if ('geom:latitude' in place){
				lat = place['geom:latitude'];
			}

			if ('lbl:longitude' in place){
				lon = place['lbl:longitude'];
			} else if ('geom:longitude' in place){
				lon = place['geom:longitude'];
			}

			return [lon, lat];
		}
	};

	return self;

})();
