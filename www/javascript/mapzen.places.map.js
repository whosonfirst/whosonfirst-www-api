var mapzen = mapzen || {};
mapzen.places = mapzen.places || {};

mapzen.places.map = (function(){

    var self = {
	
	'draw_map': function(){
	    
	    var map_id = "map";
	    
	    var map_el = document.getElementById(map_id);
	    var api_key = map_el.getAttribute("data-api-key");

	    var placetype = map_el.getAttribute("wof-placetype");

	    var lat = map_el.getAttribute("data-geom-latitude");
	    var lon = map_el.getAttribute("data-geom-longitude");

	    lat = parseFloat(lat);
	    lon = parseFloat(lon);

	    var bbox = map_el.getAttribute("data-geom-bbox");
	    bbox = bbox.split(",");

	    var min_lat = parseFloat(bbox[1]);
	    var min_lon = parseFloat(bbox[0]);
	    var max_lat = parseFloat(bbox[3]);
            var max_lon = parseFloat(bbox[2]);
	    
            var sw = L.latLng(min_lat, min_lon);
            var ne = L.latLng(max_lat, max_lon);
	    
	    var bounds = L.latLngBounds(sw, ne);
            var opts = { "padding": [100, 100] };
	    
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

	    var zoom = 12;

	    if (placetype == "venue"){
		zoom = 15;
	    }
	    
	    map.setView([lat, lon], 12);
            // map.fitBounds(bounds, opts);
	}
    };
    
    return self;

})();
