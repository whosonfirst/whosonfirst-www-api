window.addEventListener("load", function load(event){

    var abs_root_url = document.body.getAttribute("data-abs-root-url");
    var tile_url = abs_root_url + 'tiles/svg/{z}/{x}/{y}.json?api_key=' + api_key;
    
    var api_key = document.body.getAttribute("data-nextzen-api-key");
    
    if (! api_key){
      	console.log("Can't find nextzen api_key");
	return false;
    }
    
    var draw_map = function(map_el) {

	var lat = map_el.getAttribute("data-latitude");
	var lon = map_el.getAttribute("data-longitude");
	
	if ((! lat) || (! lon)){
      	    console.log("Can't find coordinates");
	    return false;
	}
	
	var zoom = map_el.getAttribute("data-zoom");
	
	if (! zoom){
      	    zoom = 14;
	}
		
	var map_id = map_el.getAttribute("id");

	var map = L.map(map_id);
	map.setView([lat, lon], zoom);
	
	var layer = L.tileLayer(tile_url, {maxZoom: 16});
	layer.addTo(map);
	
	var feature = {
      	    "type": "Feature",
	    "geometry": { "type": "Point", "coordinates": [ lon, lat ] }      	  
	};
	
	var marker_opts = {
	    radius: 8,
	    fillColor: "#ff7800",
	    color: "#000",
	    weight: 1,
	    opacity: 1,
	    fillOpacity: 0.8
	};
	
	var geojson_opts = {
	    pointToLayer: function (feature, latlon) {
            	return L.circleMarker(latlon, marker_opts);
    	    }
	};
	
	var geojson_layer = L.geoJSON(feature, geojson_opts);
	geojson_layer.addTo(map);
    }

    var els = document.getElementsByClassName("whosonfirst-photo-card-map");
    var count = els.length;
    
    for (var i=0; i < count; i++){

	var map_el = els[i];
	draw_map(map_el);
    }
});      	  
