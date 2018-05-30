var flamework = flamework || {};

/*

  api = new flamework.api();
  api.set_handler('endpoint', lampzen.api.endpoint);
  api.set_handler('accesstoken', lampzen.api.accesstoken);

*/

flamework.api = function(){

    var null_handler = function(){
	return undefined;
    };

    var self = {

	'_handlers': {
	    'endpoint': null_handler,
	    'authentication': null_handler,
	},

	'set_handler': function(target, handler){

	    if (! self._handlers[target]){
		console.log("MISSING " + target);
		return false;
	    }

	    if (typeof(handler) != "function"){
		console.log(target + " IS NOT A FUNCTION");
		return false;
	    }

	    // console.log("FLAMEWORK", target, handler);
	    self._handlers[target] = handler;
	},

	'get_handler': function(target){

	    if (! self._handlers[target]){
		return false;
	    }

	    return self._handlers[target];
	},

	'call': function(method, data, on_success, on_error){
    
	    var dothis_onsuccess = function(rsp){

		if (on_success){
		    on_success(rsp);
		}
	    };
	    
	    var dothis_onerror = function(rsp){
			
		console.log(rsp);

		if (on_error){
		    on_error(rsp);
		}
	    };

	    var get_endpoint = self.get_handler('endpoint');

	    if (! get_endpoint){
		dothis_onerror(self.destruct("Missing endpoint handler"));
		return false
	    }

	    endpoint = get_endpoint();

	    console.log("API", endpoint);
	    
	    if (! endpoint){
		dothis_onerror(self.destruct("Endpoint handler returns no endpoint!"));
		return false
	    }

	    var form_data = data;

	    if (! form_data.append){

		form_data = new FormData();
		
		for (key in data){
		    form_data.append(key, data[key]);
		}
	    }

	    form_data.append('method', method);
		
	    var set_auth = self.get_handler('authentication');

	    if (set_auth){
		form_data = set_auth(form_data);
	    }
	    
	    var onload = function(rsp){

		var target = rsp.target;

		if (target.readyState != 4){
		    return;
		}

		var status_code = target['status'];
		var status_text = target['statusText'];
		
		var raw = target['responseText'];
		var data = undefined;

		try {
		    data = JSON.parse(raw);
		}

		catch (e){

		    dothis_onerror(self.destruct("failed to parse JSON " + e));
		    return false;
		}

		if (data['stat'] != 'ok'){

		    dothis_onerror(data);
		    return false;
		}

		dothis_onsuccess(data);
		return true;
	    };
	    
	    var onprogress = function(rsp){
		// console.log("progress");
	    };
	    
	    var onfailed = function(rsp){

		dothis_onerror(self.destruct("connection failed " + rsp));
	    };

	    var onabort = function(rsp){

		dothis_onerror(self.destruct("connection aborted " + rsp));
	    };

	    // https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest/Sending_and_Receiving_Binary_Data

	    try {
		var req = new XMLHttpRequest();

		req.addEventListener("load", onload);
		req.addEventListener("progress", onprogress);
		req.addEventListener("error", onfailed);
		req.addEventListener("abort", onabort);

		/*
		for (var pair of form_data.entries()){
			console.log(pair[0]+ ', '+ pair[1]); 
		}
		*/

		req.open("POST", endpoint, true);
		req.send(form_data);
		
	    } catch (e) {
		
		dothis_onerror(self.destruct("failed to send request, because " + e));
		return false;
	    }

	    return false;
	},

	'call_paginated': function(method, data, on_page, on_error, on_complete){

	    var results = [];
	    
	    var dothis_oncomplete = function(rsp) {
		
		results.push(rsp);
		
		if (on_page) {
		    on_page(rsp);
		}
		
		if (rsp.next_query) {
		    
		    var args = rsp.next_query.split('&');
		    
		    for (var i = 0; i < args.length; i++) {
			var arg = args[i].split('=');
			var key = decodeURIComponent(arg[0]);
			var value = decodeURIComponent(arg[1]);
			data[key] = value;
		    }
		    
		    self.call(method, data, dothis_oncomplete, on_error);
		    
		}  else if (on_complete) {
		    on_complete(results);
		}
	    };
	    
	    self.call(method, data, dothis_oncomplete, on_error);
	},

	'destruct': function(msg){

	    return {
		'stat': 'error',
		'error': {
		    'code': 999,
		    'message': msg
		}
	    };

	},
    }

    return self;

};
