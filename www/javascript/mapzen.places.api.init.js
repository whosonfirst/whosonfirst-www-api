window.addEventListener('load', function(e){

	var endpoint_handler = function(form_data) {
		var endpoint = document.body.getAttribute("data-api-endpoint");
		return endpoint;
	}

	var authentication_handler = function(form_data) {
		var key = document.body.getAttribute("data-mapzen-api-key");

		if (! form_data.has("api_key") && key){
			form_data.append("api_key", key);
		}

		return form_data;
	}

	mapzen.places.api.set_handler('endpoint', endpoint_handler);
	mapzen.places.api.set_handler('authentication', authentication_handler);
});
