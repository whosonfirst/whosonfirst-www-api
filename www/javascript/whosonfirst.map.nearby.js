var whosonfirst = whosonfirst || {};
whosonfirst.map = whosonfirst.map || {};

whosonfirst.map.nearby = (function(){

    var no_results;
    var loading_results;
    var num_results;
    var results_table;
    var results_tbody;
    var result_template;
    var abs_root_url;

    var map;
    var nearby_layer;

    var self = {

	'init': function(with_map){

	    map = with_map;

	    map.on('moveend', self.nearby);

	    self.init_vars();
	    self.init_locate();

	    self.nearby();
	},

	'init_vars': function(){
	
	    no_results = document.querySelector('#no-results');
	    loading_results = document.querySelector('#loading-results');
	    num_results = document.querySelector('#num-results');
	    results_table = document.querySelector('#search-results');
	    results_tbody = results_table.querySelector('tbody');
	    result_template = document.querySelector('#result-template');
	    abs_root_url = document.body.getAttribute("data-abs-root-url");
	},

	'init_locate': function(){

	    var locate = L.control.locate({
		setView: 'once',
		drawCircle: false,
		drawMarker: false,
		locateOptions: {
		    maxZoom: 16
		}
	    });
	    
	    locate.addTo(map);

	    var btn = document.getElementById('nearby-find');
	   
	    btn.addEventListener('click', function(e) {
		
		e.preventDefault();
		var css = btn.className + '';
		
		if (css.indexOf('disabled') != -1) {
		    return;
		}
		
		btn.className = css + ' disabled';
		locate.start();
		
	    }, false);

	    map.on({
		locationfound: function(location) {
		    locate.stop();
		    var css = btn.className + '';
		    btn.className = css.replace('disabled', '');
		    map.setView([location.latitude, location.longitude], 16);
		    self.nearby();
		},
		locationerror: function() {
		    var css = btn.className + '';
		    btn.className = css.replace('disabled', '');
		}
	    });

	},

	'nearby': function(){

	    var center = map.getCenter();
	    
	    var lat = center.lat;
	    var lon = center.lng;
	    
	    var method = "whosonfirst.places.getNearby";
	    
	    var args = {
		"latitude": lat,
		"longitude": lon,
		"per_page": 500,
		"extras": "geom:,iso:country,lbl:,mz:is_current,edtf:,wof:superseded_by",
	    };
	    
	    var on_page = function(rsp){
		
		var features = [];
		
		var places = rsp["places"];
		var count_places = places.length;
		
		for (var i=0; i < count_places; i++){
		    
		    var place = places[i];
		    
		    var name = place["wof:name"];
		    
		    var coords = whosonfirst.map.features.get_place_coords(place);

		    var geom = {
			"type": "Point",
			"coordinates": coords,
		    };
		    
		    var props = place;
		    
		    var feature = {
			"type": "Feature",
			"geometry": geom,
			"properties": props,
		    };
		    
		    features.push(feature);
		}
		
		var feature_collection = {
		    "type": "FeatureCollection",
		    "features": features,
		};
		
		nearby_layer = whosonfirst.map.features.add_geojson_clusters_to_map(map, feature_collection);
		self.add_geojson_to_results_table(feature_collection);
	    };

	    var on_error = function(rsp) {
		console.error(rsp);
	    };
	    
	    self.clear_nearby();

	    loading_results.className = '';
	    no_results.className = 'hidden';
	    
	    whosonfirst.api.call_paginated(method, args, on_page, on_error);
	},
	
	'clear_nearby': function(){

	    if (nearby_layer){
		nearby_layer.remove(map);
	    }
	    
	    no_results.className = '';
	    results_table.className = 'hidden';
	    results_tbody.innerHTML = '';
	    num_results.className = 'hidden';	    
	},
	
	'add_geojson_to_results_table': function(geojson){

	    for (var i = 0; i < geojson.features.length; i++){
		
		var feature = geojson.features[i];
		var props = feature.properties;
		var tr = result_template.cloneNode(true);
		
		results_tbody.appendChild(tr);
		tr.className = 'results-item';
		
		var esc_id = htmlspecialchars(props['wof:id']);
		tr.querySelector('.id').innerHTML = esc_id;
		
		var esc_name = htmlspecialchars(props['wof:name']);
		var esc_href = htmlspecialchars(abs_root_url + 'id/' + props['wof:id'] + '/');

		tr.querySelector('.name').innerHTML = esc_name;
		tr.querySelector('.name').setAttribute('href', esc_href);
		
		var esc_pt = htmlspecialchars(props['wof:placetype']);

		tr.querySelector('.placetype').innerHTML = esc_pt;
		
		var currentness = 'unknown';
		
		if (typeof(whosonfirst.flags.existential) == "object"){

		    if (whosonfirst.flags.existential.is_current(props)){
			currentness = 'current';
		    }
		    
		    else if (whosonfirst.flags.existential.is_deprecated(props)){
			currentness = 'deprecated';
		    }
		    
		    else if (whosonfirst.flags.existential.is_ceased(props)){
			currentness = 'ceased';
		    }
		    
		    else if (whosonfirst.flags.existential.is_superseded(props)){
			currentness = 'superseded';
		    }
		    
		    else {}
		}

		tr.querySelector('.currentness').innerHTML = currentness;

		var country_code = props['iso:country'];
		
		if (typeof whosonfirst_countries[country_code] != 'undefined'){

		    var country = whosonfirst_countries[country_code];
		    var country_id = htmlspecialchars(country['wof:id']);
		    var country_name = htmlspecialchars(country['wof:name']);
		    var country_link = '<a href="' + abs_root_url + 'id/' + country_id + '">' + country_name + '</a>';

		    tr.querySelector('.country').innerHTML = country_link;
		}
	    }

	    results_table.className = 'table';
	    loading_results.className = 'hidden';
	    no_results.className = 'hidden';
	    
	    var num = results_tbody.querySelectorAll('tr').length;
	    num_results.innerHTML = num.toLocaleString() + ' results';
	    num_results.className = '';
	},

    };

    return self;

})();
