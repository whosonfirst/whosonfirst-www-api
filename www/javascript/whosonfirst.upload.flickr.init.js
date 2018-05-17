window.addEventListener("load", function load(event){

    var btn = document.getElementById("flickr-photo-button");

    btn.onclick = function(e){

	var el = document.getElementById("flickr-photo-id");
	var input = el.value;

	var whosonfirst_id = el.getAttribute("data-whosonfirst-id");

	if (! whosonfirst_id){
	    console.log("Missing Who's On First ID");
	    return false;
	}

	// please make this work with the various "-in-whatever" flickr
	// URLs that exist out there... (20180517/thisisaaronland)

	var m = input.match(/(?:.*\/)?(\d+)\/?$/);

	if (! m){
	    alert("Failed to recognize Flickr photo");
	    return false;
	}

	var photo_id = m[1];

	// it would be nice to be able to check the licensing of the photo
	// here but that doesn't appear to be possible absent an API key
	// and the oembed endpoint doesn't return that information
	// (20180516/thisisaaronland)

	var args = {
	    "whosonfirst_id": whosonfirst_id,
	    "photo_id": photo_id,
	}

	var method = "whosonfirst.media.uploadFlickrPhoto";

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
