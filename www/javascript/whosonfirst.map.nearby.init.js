window.addEventListener("load", function load(event){

    var map = whosonfirst.map.nextzen.get_map("map");
    var map_el = whosonfirst.map.nextzen.get_map_element(map);

    map.setMaxZoom(15);		// required by leaflet cluster

    var wof_id = map_el.getAttribute("data-wof-id");

    if (wof_id){

	var uri = whosonfirst.uri.id2abspath(wof_id);
	
	var on_success = function(feature){
	    whosonfirst.map.features.add_geojson_to_map(map, feature);
	};
	
	var on_error = function(rsp){
	    self.log("error", uri, rsp);
	};
	
	whosonfirst.net.fetch(uri, on_success, on_error);	
    }

    else {
	
	var lat = 37.781569;
	var lon = -122.433014;
	var zoom = 14;
	
	map.setView([lat, lon], zoom);
    }

    whosonfirst.map.nearby.init(map);

});
