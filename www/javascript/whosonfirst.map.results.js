var whosonfirst = whosonfirst || {};
whosonfirst.map = whosonfirst.map || {};

whosonfirst.map.results = (function(){

    var self = {

	'init': function(){
	},
	
	'draw': function(map){

	    var geojson = {
		type: "FeatureCollection",
		features: []
	    };

	    var results = document.querySelectorAll('.results-item');
	    
	    for (var i = 0; i < results.length; i++) {
		
		var item = results[i];
		var lat = parseFloat(item.getAttribute('data-latitude'));
		var lng = parseFloat(item.getAttribute('data-longitude'));
		
		var name = item.querySelector('a[itemprop="name"]').innerHTML;
		
		var feature = {
		    type: "Feature",
		    bbox: [lng, lat, lng, lat],
		    properties: {
			"wof:id": item.getAttribute('data-wof-id'),
			"wof:name": name
		    },
		    geometry: {
			type: "Point",
			coordinates: [lng, lat]
		    }
		};
		
		geojson.features.push(feature);

		whosonfirst.map.features.add_geojson_to_map(map, feature);
	    }
	    
	    whosonfirst.map.features.fit_map(map, geojson);
	}

    };

    return self;

})();
