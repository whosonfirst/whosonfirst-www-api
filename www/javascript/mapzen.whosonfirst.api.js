var mapzen = mapzen || {};
mapze.whosonfirst = whosonfirst.mapzen || {};

mapzen.whosonfirst.api = (function(){

    var _api = undefined;

    var self = {

        'init': function(){

            _api = new flamework.api();
            _api.set_handler('endpoint', mapzen.whosonfirst.api.endpoint);
            _api.set_handler('authentication', mapzen.whosonfirst.api.authentication);
        },

        'call': function(method, data, on_success, on_error){
            _api.call(method, data, on_success, on_error);
        },

        'endpoint': function(){
            return document.body.getAttribute("data-api-endpoint");
        },

        'authentication': function(form_data){

	    var access_token = document.body.getAttribute("data-api-access-token");
	    
	    if (! form_data.has("access_token")){
		form_data.append("access_token", access_token);
	    }
	    
	    return form_data;
        }
    }

    return self;

})();

window.addEventListener('load', function(e){
    mapzen.whosonfirst.api.init();
});
