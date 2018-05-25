var whosonfirst = whosonfirst || {};
whosonfirst.media = whosonfirst.media || {};

whosonfirst.media.depicts = (function(){

    var self = {

	'attach_typeahead': function(id, name, data) {

	    // var el = document.getElementById(id);
	    
	    var el = $('#' + id + ' .typeahead');
	    
	    if (! el){
		console.log("can't find element '" + id + "'");
		return false;
	    }
	    
	    var values = [];

	    for (k in data){
		values.push(k);
	    }
	    
	    var source = new Bloodhound({
		datumTokenizer: Bloodhound.tokenizers.whitespace,
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		local: values
	    });
	    
	    var args = {
		"name": name,
		"limit": 20,
		"highlight": true,
		"source": source,
	    };
	    
	    el.typeahead(null, args);
	    
	    var on_select = function(name){

		var wof_id = data[name];

		if (! wof_id){
		    console.log("Unable to lookup ID for '" + name + "'");
		    return false;
		}

		var depicts = document.getElementById(id);
		var media_id = depicts.getAttribute("data-media-id");

		if (! media_id){
		    console.log("Unable to determine media ID");
		    return false
		}
		
		var button = document.createElement("button");
		button.setAttribute("class", "btn btn-sm");
		button.appendChild(document.createTextNode("save"));

		button.onclick = function(e){

		    var method = "whosonfirst.media.depictsWhosOnFirstID";

		    var args = {
			"id": media_id,
			"whosonfirst_id": wof_id,
		    };

		    var on_success = function(rsp){
			console.log("OKAY", rsp);
		    };

		    var on_error = function(rsp){
			console.log("ERROR", rsp);
		    };

		    whosonfirst.api.call(method, args, on_success, on_error);

		    var el = e.target;
		    depicts.removeChild(el);
		};

		depicts.appendChild(button);
	    };

	    if (typeof(on_select) == "function"){
		
		el.bind('typeahead:select', function(e, value){
		    on_select(value);
		});
	    }
	    
	    return true;
	},
	
    };

    return self;

})();
