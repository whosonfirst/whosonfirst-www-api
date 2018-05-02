var whosonfirst = whosonfirst || {};
whosonfirst.map = whosonfirst.map || {};

whosonfirst.map.features = (function(){

	var maps = {};
    
    var self = {
	
	'get_marker': function(feature, latlon){
	    
	    var props = feature['properties'];
	    var label = props['wof:name'];
	    
	    if (! latlon) {
		var lat = props['geom:latitude'];
		var lon = props['geom:longitude'];
		latlon = [lat, lon];
	    }
	    
	    var abs_root_url = document.body.getAttribute("data-abs-root-url");
	    
	    var icon = L.icon({
		iconUrl: abs_root_url + 'images/pin.png',
		iconSize: [32, 47],
		iconAnchor: [16, 46],
	    });
	    
	    var m = L.marker(latlon, {
		icon: icon
	    });
	    
	    m.bindTooltip(label);
	    return m;
	},
	
	'feature_handler': function(feature, layer){
	    
	    var props = feature['properties'];
	    var wofid = props["wof:id"];
	    
	    layer.on('click', function (e){
		
		var enc_id = encodeURIComponent(wofid);
		
		var abs_root_url = document.body.getAttribute("data-abs-root-url");
		var url = abs_root_url + "id/" + enc_id + "/";
		
		location.href = url;
	    });
	},
	
	'add_geojson_to_map': function(map, geojson, more){
	    
	    if (! more){
		more = {};
	    }
	    
	    var args = {
		"pointToLayer": self.get_marker,
		"onEachFeature": self.feature_handler
	    };
	    
	    var layer = L.geoJSON(geojson, args);
	    
	    // http://leafletjs.com/reference-1.1.0.html#layergroup-setzindex
	    // https://github.com/Leaflet/Leaflet/issues/3427 (sigh...)
	    
	    if (more["z-index"]){
		var z = layer.setZIndex(more["z-index"]);
	    }
	    
	    return layer.addTo(map);
	},
	
	'add_geojson_clusters_to_map': function(map, geojson, more){
	    
	    var cluster = L.markerClusterGroup({
		maxClusterRadius: 120,
		showCoverageOnHover: false
	    });

	    var feature, layer;
	    
	    for (var i = 0; i < geojson.features.length; i++) {
		feature = geojson.features[i];
		marker = self.get_marker(feature);
		self.feature_handler(feature, marker);
		cluster.addLayer(marker);
	    }
	    
	    map.addLayer(cluster);
	},
	
	'get_place_coords': function(place){
	    
	    var lat = null;
	    var lon = null;
	    
	    if ('lbl:latitude' in place){
		lat = place['lbl:latitude'];
	    }

	    else if ('geom:latitude' in place){
		lat = place['geom:latitude'];
	    }
	    
	    if ('lbl:longitude' in place){
		lon = place['lbl:longitude'];
	    }

	    else if ('geom:longitude' in place){
		lon = place['geom:longitude'];
	    }
	    
	    return [lon, lat];
	},

	'draw_bbox': function(map, geojson, more){
	    
	    var bbox = whosonfirst.geojson.derive_bbox(geojson);
	    
	    if (! bbox){
		self.log("error", "missing bounding box");
		return false;
	    }
	    
	    var bbox = geojson['bbox'];
	    var swlat = bbox[1];
	    var swlon = bbox[0];
	    var nelat = bbox[3];
	    var nelon = bbox[2];
	    
	    var geom = {
		'type': 'Polygon',
		'coordinates': [[
		    [swlon, swlat],
		    [swlon, nelat],
		    [nelon, nelat],
		    [nelon, swlat],
		    [swlon, swlat],
		]]
	    };
	    
	    var bbox_geojson = {
		'type': 'Feature',
		'geometry': geom
	    }
	    
	    return self.add_geojson_to_map(map, bbox_geojson);
	},
	
	'draw_centroids': function(map, geojson){

	    // please rewrite me (20180502/thisisaaronland)
	},
	
	'fit_map': function(map, geojson, force){
	    
	    var bbox = whosonfirst.geojson.derive_bbox(geojson);
	    
	    if (! bbox){
		console.log("no bounding box");
		return false;
	    }
	    
	    if ((bbox[1] == bbox[3]) && (bbox[2] == bbox[4])){
		map.setView([bbox[1], bbox[0]], 14);
		return;
	    }
	    
	    var sw = [bbox[1], bbox[0]];
	    var ne = [bbox[3], bbox[2]];
	    
	    var bounds = new L.LatLngBounds([sw, ne]);
	    var redraw = true;

	    try {
		var current = map.getBounds();
	    
		if (! force){
		
		    var redraw = false;
		    
		    /*
		      console.log("south bbox: " + bounds.getSouth() + " current: " + current.getSouth().toFixed(6));
		      console.log("west bbox: " + bounds.getWest() + " current: " + current.getWest().toFixed(6));
		      console.log("north bbox: " + bounds.getNorth() + " current: " + current.getNorth().toFixed(6));
		      console.log("east bbox: " + bounds.getEast() + " current: " + current.getEast().toFixed(6));
		    */
		    
		    if (bounds.getSouth() <= current.getSouth().toFixed(6)){
			redraw = true;
		    }
		    
		    else if (bounds.getWest() <= current.getWest().toFixed(6)){
			redraw = true;
		    }
		    
		    else if (bounds.getNorth() >= current.getNorth().toFixed(6)){
			redraw = true;
		    }
		    
		    else if (bounds.getEast() >= current.getEast().toFixed(6)){
			redraw = true;
		    }
		    
		    else {}
		}
	    }

	    catch (e) {
		self.log("error", e);
	    }
	    
	    if (redraw){
		map.fitBounds(bounds);
	    }
	},

	'log': function(level, message){
	    
	    ctx = "[whosonfirst.map.features]";

	    if (typeof(whosonfirst.log) != 'object'){
		console.log(ctx, level, message);
		return;
	    }
	    
	    whosonfirst.log.dispatch(ctx + ' ' + message, level);
	}

	};

	return self;

})();
