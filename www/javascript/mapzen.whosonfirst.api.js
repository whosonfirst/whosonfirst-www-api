var mapzen = mapzen || {};
mapze.whosonfirst = whosonfirst.mapzen || {};

mapzen.whosonfirst.api = (function(){

    var _api = undefined;

    var self = {

        'init': function(){

            _api = new flamework.api();
            _api.set_handler('endpoint', mapzen.whosonfirst.api.endpoint);
            _api.set_handler('accesstoken', mapzen.whosonfirst.api.accesstoken);
        },

        'call': function(method, data, on_success, on_error){
            _api.call(method, data, on_success, on_error);
        },

        'endpoint': function(){
            return document.body.getAttribute("data-api-endpoint");
        },

        'accesstoken': function(){
            return document.body.getAttribute("data-api-access-token");
        }
    }

    return self;

})();

window.addEventListener('load', function(e){
    mapzen.whosonfirst.api.init();
});
