window.addEventListener("load", function load(event){

    var btn_id = "upload-delete-button";
    var btn = document.getElementById(btn_id);

    if (! btn){
	console.log("Can't find " + btn_id);
	return false;
    }

    btn.onclick = function(e){

	var el = e.target;
	var upload_id = el.getAttribute("data-upload-id");

	if (! upload_id){
	    return false;
	}

	if (! confirm("Are you sure you want to delete this upload? There is no \"undo\"")){
	    return false;
	}

	var method = "whosonfirst.uploads.deleteUpload";

	var args = {
	    "upload_id": upload_id
	};

	var on_success = function(rsp){
	    console.log("SUCCESS", rsp);
	};
	
	var on_error = function(rsp){
	    console.log("ERROR", rsp);
	};

	console.log("DELETE", method, args);

	whosonfirst.api.call(method, args, on_success, on_error);
	return false;
    };

}, false);
