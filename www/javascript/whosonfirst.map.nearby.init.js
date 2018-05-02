window.addEventListener("load", function load(event){

    var map_id = "map";
    var map = whosonfirst.map.nextzen.get_map(map_id);

    map.setMaxZoom(18);		// required by leaflet cluster

    var map_el = document.getElementById(map_id);
      
    if (map_el.getAttribute("data-wof-id")){
	// return self.draw_place_map(map_id, cb);
    }

    var lat = 37.616198;
    var lon = -122.389979;
    var zoom = 17;

    map.setView([lat, lon], zoom);
    whosonfirst.map.nearby.init(map);

});
