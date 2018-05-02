var whosonfirst = whosonfirst || {};

whosonfirst.api = (function(){

    var _api = undefined;

    var self = {

        'init': function(){

            _api = new flamework.api();
            _api.set_handler('endpoint', whosonfirst.api.endpoint);
            _api.set_handler('authentication', whosonfirst.api.authentication);
        },

        'call': function(method, data, on_success, on_error){
            _api.call(method, data, on_success, on_error);
        },

        'call_paginated': function(method, data, on_success, on_error, on_complete){
            _api.call_paginated(method, data, on_success, on_error, on_complete);
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
    whosonfirst.api.init();
});
