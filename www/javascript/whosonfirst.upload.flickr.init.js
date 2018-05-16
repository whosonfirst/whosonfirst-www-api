window.addEventListener("load", function load(event){

    var btn = document.getElementById("flickr-photo-button");
    console.log("BTN", btn);

    btn.onclick = function(e){

	var el = document.getElementById("flickr-photo-id");
	var input = el.value;

	var whosonfirst_id = el.getAttribute("data-whosonfirst-id");

	if (! whosonfirst_id){
	    console.log("Missing Who's On First ID");
	    return false;
	}

	var m = input.match(/(?:.*\/)?(\d+)\/?$/);

	if (! m){
	    alert("Failed to recognize Flickr photo");
	    return false;
	}

	var photo_id = m[1];

	var args = {
	    "whosonfirst_id": whosonfirst_id,
	    "photo_id": photo_id,
	}

	var method = "whosonfirst.uploads.uploadFlickrPhoto";

	var on_success = function(rsp){
	    console.log("SUCCESS", rsp);
	};
	
	var on_error = function(rsp){
	    console.log("ERROR", rsp);
	};

	whosonfirst.api.call(method, args, on_success, on_error);
	return false;
    };

}, false);
