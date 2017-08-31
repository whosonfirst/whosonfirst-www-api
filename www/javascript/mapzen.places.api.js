var mapzen = mapzen || {};
mapzen.places = mapzen.places || {};

mapzen.places.api = (function(){

    var _api = undefined;

    var self = {

        'init': function(){

            _api = new flamework.api();
            _api.set_handler('endpoint', mapzen.places.api.endpoint);
            _api.set_handler('authentication', mapzen.places.api.authentication);
        },

        'execute_method': function(method, data, on_success, on_error){
            _api.call(method, data, on_success, on_error);
	},

        'call': function(method, data, on_success, on_error){
            _api.call(method, data, on_success, on_error);
        },

        'endpoint': function(){
            return document.body.getAttribute("data-mapzen-api-endpoint");
        },

        'authentication': function(form_data){

            var key = document.body.getAttribute("data-mapzen-api-key");

	    if (! form_data.has("api_key")){
		form_data.append("api_key", key);
	    }

	    return form_data;
        }
    }

    return self;

})();

window.addEventListener('load', function(e){
    mapzen.places.api.init();
});
