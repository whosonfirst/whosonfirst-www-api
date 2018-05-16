window.addEventListener("load", function load(event){

    var drop_id = 'dropbox-target';
    var drop_el = document.getElementById(drop_id);
    var wof_id = drop_el.getAttribute("data-whosonfirst-id");
    
    var upload = function(files){

	var count = files.length;
	var rows = new Array();
	
	for (var i = 0; i < count; i++){
	    upload_file(files[i]);
	}
    };

    var upload_file = function(file){
	
	var method = "whosonfirst.photos.uploadPhoto";

	var args = {
	    "whosonfirst_id": wof_id,
	    "filename": file.name,
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

    whosonfirst.dropbox.register_callback(drop_id, upload);

}, false);
