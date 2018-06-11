window.addEventListener("load", function load(event){

    var drop_id = 'whosonfirst-media-replace-target';
    var drop_el = document.getElementById(drop_id);
    var media_id = drop_el.getAttribute("data-whosonfirst-media-id");
    
    var replace = function(files){

	var count = files.length;

	if (count > 1){
	    alert("Multiple files! Not sure what to do with this (yet...)");
	    return false;
	}
	
	for (var i = 0; i < count; i++){
	    replace_file(files[i]);
	}
    };

    var replace_file = function(file){
	
	var method = "whosonfirst.media.replaceFile";

	var args = {
	    "media_id": media_id,
	    "file": file,
	};

	var on_success = function(rsp){
	    console.log("OKAY", rsp);
	};

	var on_error = function(rsp){
	    console.log("ERROR", rsp);
	}
	
	whosonfirst.api.call(method, args, on_success, on_error);
    };

    whosonfirst.dropbox.register_callback(drop_id, replace);

}, false);
