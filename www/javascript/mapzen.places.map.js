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
		
                    // https://github.com/mapzen/mapzen.js/blob/master/src/js/components/tangram.js
		
                    tangramOptions: {
			//scene: L.Mapzen.BasemapStyles.Refill,
			scene: abs_root_url + "tangram/refill-style.zip",
			tangramURL: abs_root_url + "javascript/tangram.min.js"
                    }
		});

		maps[map_id] = map;
	    }

	    return maps[map_id];
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

		var min_lon = parseFloat(parent_bbox[0]);
		var min_lat = parseFloat(parent_bbox[1]);
		var max_lon = parseFloat(parent_bbox[2]);
		var max_lat = parseFloat(parent_bbox[3]);
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

	    cb(map);
	},

        'add_geojson_to_map': function(map, geojson, more){

	    if (! more){
                more = {};
            }
	    
            var args = {
                // "style": style,
		// "pointToLayer": handler
            }
	    
            // console.log("[map][geojson] ADD", geojson, args);
	    
            var layer = L.geoJSON(geojson, args);
	    
            // http://leafletjs.com/reference-1.1.0.html#layergroup-setzindex
            // https://github.com/Leaflet/Leaflet/issues/3427 (sigh...)
	    
            if (more["z-index"]){
                var z = layer.setZIndex(more["z-index"]);
            }
	    
            return layer.addTo(map);
        }
    };
    
    return self;

})();
