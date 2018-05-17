window.addEventListener("load", function load(event){

    var btn = document.getElementById("process-upload-button");

    if (! btn){
	console.log("Can't find process-upload-button");
	return false;
    }

    btn.onclick = function(e){

	var el = e.target;
	var upload_id = el.getAttribute("data-upload-id");

	if (! upload_id){
	    return false;
	}

	var method = "whosonfirst.uploads.processUpload";

	var args = {
	    "upload_id": upload_id
	};

	var on_success = function(rsp){
	    console.log("SUCCESS", rsp);
	};
	
	var on_error = function(rsp){
	    console.log("ERROR", rsp);
	};

	console.log("PROCESS", method, args);

	whosonfirst.api.call(method, args, on_success, on_error);

	return false;
    };

}, false);
