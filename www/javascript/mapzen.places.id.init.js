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
    };
    
    mapzen.places.map.draw_place_map("map", cb);
});
