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

	var go_geolocate_click = function(e){
		e.preventDefault();
		if ("geolocation" in navigator){
			navigator.geolocation.getCurrentPosition(function(position) {
				go_step1(position.coords.latitude, position.coords.longitude);
			});
		}
		else {
			alert('Your browser does not support geolocation.');
		}
	};

	var go_step1 = function(lat, lon){
		if (lat){
			lat = parseFloat(lat);
			lat = lat.toFixed(6);
			document.getElementById('go-latitude').value = lat;
		}
		if (lon){
			lon = parseFloat(lon);
			lon = lon.toFixed(6);
			document.getElementById('go-longitude').value = lon;
		}
		document.getElementById('go-step1').className = 'row';
	};

	document.getElementById('go-geolocate').addEventListener('click', go_geolocate_click, false);
	document.getElementById('go-latlon').addEventListener('click', function(e) {
		e.preventDefault();
		go_step1();
	}, false);
});
