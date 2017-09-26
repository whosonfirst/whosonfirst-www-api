window.addEventListener('load', function(e){

	var endpoint_handler = function() {
		var endpoint = document.body.getAttribute("data-api-endpoint");
		return endpoint;
	}

	var api_key_handler = function() {
		var api_key = document.body.getAttribute("data-mapzen-api-key");
		return api_key;
	}

	mapzen.places.api.set_handler('endpoint', endpoint_handler);
	mapzen.places.api.set_handler('api_key', api_key_handler);
});
