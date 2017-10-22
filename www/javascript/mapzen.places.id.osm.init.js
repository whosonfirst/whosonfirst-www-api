window.addEventListener("load", function load(event){

	var button = document.getElementById("add-to-osm");

	button.onclick = function(e) {

		var el = e.target;
		var user = el.getAttribute("data-osm-username");

		if (! user){

			// do the OSM Oauth/signin dance
			return;
		}

		// check to see if the place is in OSM... how?

		var method = "mapzen.places.osm.addVenue";
		var args = { "id": "GET VENUE ID" };

		// call API
	};

	var hash = location.hash;
	hash = hash.substring(1,);

	
});
