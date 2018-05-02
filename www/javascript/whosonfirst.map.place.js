var whosonfirst = whosonfirst || {};
whosonfirst.map = whosonfirst.map || {};

whosonfirst.map.place = (function(){

    var map;

    var self = {

	'init': function(with_map){
	    map = with_map;
	},

	'draw': function(map_el){

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
	    
	    whosonfirst.net.fetch(abs_path, onsuccess, onerror);
	    
	    if (wof_parent_id){
		var abs_path = mapzen.whosonfirst.uri.id2abspath(wof_parent_id);
		whosonfirst.net.fetch(abs_path, onsuccess, onerror);
	    }
	    
	};

	mapzen.places.map.draw_place_map("map", cb);

});
