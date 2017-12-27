window.addEventListener('load', function(e){

	var endpoint_handler = function() {
		var endpoint = document.body.getAttribute("data-api-endpoint");
		return endpoint;
	}

	var authentication_handler = function(form_data) {
		var api_key = document.body.getAttribute("data-mapzen-api-key");
		form_data.append('api_key', api_key);
		return form_data;
	}

	mapzen.places.api.set_handler('endpoint', endpoint_handler);
	mapzen.places.api.set_handler('authentication', authentication_handler);
});
