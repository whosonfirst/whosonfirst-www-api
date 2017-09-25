window.addEventListener('load', function(e){

	var endpoint_handler = function() {
		var endpoint = document.body.getAttribute("data-api-endpoint");
		return endpoint;
	}

	var authentication_handler = function(form_data, endpoint) {
		var api_key = document.body.getAttribute("data-mapzen-api-key");
		endpoint += '?api_key=' + api_key;
		return endpoint;
	}

	mapzen.places.api.set_handler('endpoint', endpoint_handler);
	mapzen.places.api.set_handler('authentication', authentication_handler);
});
