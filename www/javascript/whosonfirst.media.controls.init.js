window.addEventListener("load", function load(event){
    
    var delete_media = function(media_id){

	var method = "whosonfirst.media.deleteFile";
	
	var args = {
	    "id": media_id,
	};
	
	var on_success = function(rsp){
	    window.location.reload(false); 
	};

	var on_error = function(rsp){
	    console.log("ERROR", media_id, rsp);
	};

	whosonfirst.api.call(method, args, on_success, on_error);	
    };

    var refresh_media = function(media_id){

	var method = "whosonfirst.media.refreshDerivatives";
	
	var args = {
	    "id": media_id,
	};
	
	var on_success = function(rsp){
	    window.location.reload(false); 
	};

	var on_error = function(rsp){
	    console.log("ERROR", media_id, rsp);
	};

	whosonfirst.api.call(method, args, on_success, on_error);	
    };

    var replace_flickr = function(media_id){

	var method = "whosonfirst.media.replaceFlickrPhoto";
	
	var args = {
	    "media_id": media_id,
	};
	
	var on_success = function(rsp){
	    window.location.reload(false); 
	};

	var on_error = function(rsp){
	    console.log("ERROR", media_id, rsp);
	};

	whosonfirst.api.call(method, args, on_success, on_error);	
    };
    
    var set_status = function(media_id, status_id){

	var method = "whosonfirst.media.setStatus";
	
	var args = {
	    "id": media_id,
	    "status_id": status_id,
	    };

	var on_success = function(rsp){

	    var media = rsp["media"];
	    var media_id = media["id"];
	    var status = media["status"];

	    var img = document.getElementById("media-img-" + media_id);

	    var btn_public = document.getElementById("media-mk-public-" + media_id);
	    var btn_private = document.getElementById("media-mk-private-" + media_id);

	    if (status == "public"){
		
		btn_public.style.display = "none";
		btn_private.style.display = "block";

		whosonfirst.html.css.remove_class(img, "media-private");
		whosonfirst.html.css.append_class(img, "media-public");
	    }

	    else {

		btn_public.style.display = "block";
		btn_private.style.display = "none";

		whosonfirst.html.css.remove_class(img, "media-public");
		whosonfirst.html.css.append_class(img, "media-private");
	    }
	};

	var on_error = function(rsp){
	    console.log("ERROR", media_id, rsp);
	};

	whosonfirst.api.call(method, args, on_success, on_error);
    };

    var mk_public = function(e){

	var el = e.target;
	var media_id = el.getAttribute("data-media-id");
	
	if (! media_id){
	    return false;
	}
	
	if (! confirm("Are you sure you want to make this item public?" + " " + media_id)){
	    return false;
	}
	
	set_status(media_id, 1);
    };

    var mk_private = function(e){

	var el = e.target;
	var media_id = el.getAttribute("data-media-id");
	
	if (! media_id){
	    return false;
	}
	
	if (! confirm("Are you sure you want to make this media private?")){
	    return false;
	}
	
	set_status(media_id, 0);
    };
    
    var mk_delete = function(e){

	var el = e.target;
	var media_id = el.getAttribute("data-media-id");
	
	if (! media_id){
	    return false;
	}
	
	if (! confirm("Are you sure you want to delete this item? This can't be undone.")){
	    return false;
	}
	
	delete_media(media_id);
    };

    var mk_refresh = function(e){

	var el = e.target;
	var media_id = el.getAttribute("data-media-id");
	
	if (! media_id){
	    return false;
	}
	
	if (! confirm("Are you sure you want to refresh all the derivatives? This will overwrite any existing files.")){
	    return false;
	}
	
	refresh_media(media_id);
    };

    var mk_replace_flickr = function(e){

	var el = e.target;
	var media_id = el.getAttribute("data-media-id");
	
	if (! media_id){
	    return false;
	}
	
	if (! confirm("Are you sure you want to re-import this photo from Flickr? This will overwrite any existing files.")){
	    return false;
	}
	
	replace_flickr(media_id);
    };
    
    var func_map = {
	"media-mk-public": mk_public,
	"media-mk-private": mk_private,
	"media-delete": mk_delete,
	"media-refresh": mk_refresh,
	"media-replace-flickr": mk_replace_flickr,
    };

    for (class_name in func_map){

	var els = document.getElementsByClassName(class_name);
	var count = els.length;
	
	for (var i=0; i < count; i++){
	    
	    var el = els[i];
	    
	    var media_id = el.getAttribute("data-media-id");
	    
	    if (! media_id){
		continue;
	    }
	    
	    el.onclick = func_map[class_name];
	}
    }

}, false);
