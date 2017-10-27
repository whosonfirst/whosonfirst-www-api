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

		if (mapzen && mapzen.places && mapzen.places.routing){
			mapzen.places.routing.init(map);
		}
	};

	mapzen.places.map.draw_place_map("map", cb);

	var summary = document.getElementById('wikipedia-summary');
	if (summary) {
		var page = summary.getAttribute('data-page');
		if (page) {
			var title = page.replace(/_/g, ' ');
			var url_title = encodeURIComponent(title);
			var origin = encodeURIComponent('*');
			var url = 'https://en.wikipedia.org/w/api.php?format=json&action=parse&redirects=1&prop=text&section=0&page=' + page + '&origin=' + origin;
			var onerror = function() {
				console.error('Could not load ' + url);
			};
			var req = new XMLHttpRequest();
			req.onload = function(){
				try {
					var rsp = JSON.parse(req.responseText);
				}
				catch(e) {
					console.error('Could not parse result');
					return;
				}
				summary.style.visibility = 'hidden';
				summary.innerHTML = rsp.parse.text['*'];
				var p_search = summary.querySelectorAll('p');
				for (var i = 0; i < p_search.length; i++) {
					var p = p_search[i];
					if (p.parentNode.className == 'mw-parser-output') {
						break;
					}
				}
				if (p) {
					summary.innerHTML = '<h5>Wikipedia</h5><blockquote><p>' + p.innerHTML + '</p></blockquote><a href="https://en.wikipedia.org/wiki/' + page + '">' + htmlspecialchars(rsp.parse.title) + ' on Wikipedia</a>';
					summary.style.visibility = 'visible';
				}
			};
			req.open("get", url, true);
			req.send();
		}
	}
});
