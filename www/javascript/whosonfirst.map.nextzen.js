var whosonfirst = whosonfirst || {};
whosonfirst.map = whosonfirst.map || {};

whosonfirst.map.nextzen = (function(){

	var maps = {};

	var self = {

	    'get_map': function(map_id){
		
		if (maps[map_id]){
		    return maps[map_id];
		}
	    
		var api_key = document.body.getAttribute("data-nextzen-api-key");
		var abs_root_url = document.body.getAttribute("data-abs-root-url");

		// this is just to prevent warning in the console.log
		// (20180427/thisisaaronland)

		L.Mapzen.apiKey = api_key;

		var sources = {
		    mapzen: {
			url: 'https://{s}.tile.nextzen.org/tilezen/vector/v1/512/all/{z}/{x}/{y}.topojson',
			url_subdomains: ['a', 'b', 'c', 'd'],
			url_params: {
			    api_key: api_key
			},
			tile_size: 512,
			max_zoom: 15
	            }
		};
		
		var scene = {
		    import: [
			"/tangram/refill-style.zip",
			"/tangram/refill-style-themes-label.zip",
	            ],
		    sources: sources,
		    global: {
			sdk_mapzen_api_key: api_key,
	            },
		};
		
		var attributions = {
		    "Tangram": "https://github.com/tangrams/",
		    "© OSM contributors": "http://www.openstreetmap.org/",
		    "Who\"s On First": "http://www.whosonfirst.org/",
		    "Nextzen": "https://nextzen.org/",
		};
		
		var attrs = [];
		
		for (var label in attributions){
		    
		    var link = attrs[label];
		    
		    if (! link){
			attrs.push(label);
			continue;
	            }
		    
		    var anchor = '<a href="' + link + '" target="_blank">' + enc_label + '</a>';
		    attrs.push(anchor);
		}
		
		var str_attributions = attrs.join(" | ");
		
		// waiting for nextzen.js to be updated to do all the things - that said it's
		// not entirely clear we need all of (map/next)zen.js and could probably get
		// away with leaflet + tangram but for now we'll just keep on as-is...
		// (20180304/thisisaaronland)
		
		L.Mapzen.apiKey = api_key;
		
		var map_opts = {
		    tangramOptions: {
			scene: scene,
			attribution: attributions,
	            }
		};
		
		map = L.Mapzen.map(map_id, map_opts);

		maps[map_id] = map;
		return map;
		
		}
	    };

    return self;

})();
