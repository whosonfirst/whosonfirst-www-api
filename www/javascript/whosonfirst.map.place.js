var whosonfirst = whosonfirst || {};
whosonfirst.map = whosonfirst.map || {};

whosonfirst.map.place = (function(){

    var self = {

	'init': function(){
	},

	'draw': function(map){

	    var map_el = whosonfirst.map.nextzen.get_map_element(map);

	    var wof_id = map_el.getAttribute("data-wof-id");
	    var wof_parent_id = map_el.getAttribute("data-wof-parent-id");
	    var wof_placetype = map_el.getAttribute("data-wof-placetype");
	    
	    var uri = whosonfirst.uri.id2abspath(wof_id);
	    
	    var on_success = function(feature){
		whosonfirst.map.features.add_geojson_to_map(map, feature);
	    };
	    
	    var on_error = function(rsp){
		self.log("error", uri, rsp);
	    };
	    
	    whosonfirst.net.fetch(uri, on_success, on_error);
	    
	    if (wof_parent_id){
		var parent_uri = whosonfirst.uri.id2abspath(wof_parent_id);
		whosonfirst.net.fetch(parent_uri, on_success, on_error);
	    }
	    
	},

	'log': function(level, message){
	    
	    ctx = "[whosonfirst.map.place]";

	    if (typeof(whosonfirst.log) != 'object'){
		console.log(ctx, level, message);
		return;
	    }
	    
	    whosonfirst.log.dispatch(ctx + ' ' + message, level);
	}

    };

    return self;

})();
