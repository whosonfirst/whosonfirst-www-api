window.addEventListener("load", function load(event){
    
    var delete_photo = function(photo_id){

	var method = "whosonfirst.photos.deletePhoto";
	
	var args = {
	    "photo_id": photo_id,
	    };
	
	var on_success = function(rsp){

	};

	var on_error = function(rsp){
	    console.log("ERROR", photo_id, rsp);
	};

	whosonfirst.api.call(method, args, on_success, on_error);	
    };
    
    var set_status = function(photo_id, status_id){

	var method = "whosonfirst.photos.setStatus";
	
	var args = {
	    "photo_id": photo_id,
	    "status_id": status_id,
	    };
	
	var on_success = function(rsp){

	    var photo = rsp["photo"];
	    var photo_id = photo["id"];
	    var status_id = photo["status_id"];

	    var img = document.getElementById("photo-img-" + photo_id);

	    var btn_public = document.getElementById("photo-mk-public-" + photo_id);
	    var btn_private = document.getElementById("photo-mk-private-" + photo_id);

	    if (status_id == 1){
		
		btn_public.style.display = "none";
		btn_private.style.display = "block";

		whosonfirst.html.css.remove_class(img, "photo-private");
		whosonfirst.html.css.append_class(img, "photo-public");
	    }

	    else {

		btn_public.style.display = "block";
		btn_private.style.display = "none";

		whosonfirst.html.css.remove_class(img, "photo-public");
		whosonfirst.html.css.append_class(img, "photo-private");
	    }
	};

	var on_error = function(rsp){
	    console.log("ERROR", photo_id, rsp);
	};

	whosonfirst.api.call(method, args, on_success, on_error);
    };

    var mk_public = function(e){

	var el = e.target;
	var photo_id = el.getAttribute("data-photo-id");
	
	if (! photo_id){
	    return false;
	}
	
	if (! confirm("Are you sure you want to make this photo public?" + " " + photo_id)){
	    return false;
	}
	
	set_status(photo_id, 1);
    };

    var mk_private = function(e){

	var el = e.target;
	var photo_id = el.getAttribute("data-photo-id");
	
	if (! photo_id){
	    return false;
	}
	
	if (! confirm("Are you sure you want to make this photo private?")){
	    return false;
	}
	
	set_status(photo_id, 0);
    };
    
    var mk_delete = function(e){

	var el = e.target;
	var photo_id = el.getAttribute("data-photo-id");
	
	if (! photo_id){
	    return false;
	}
	
	if (! confirm("Are you sure you want to delete this photo? This can't be undone.")){
	    return false;
	}
	
	delete_photo(photo_id);
    };
    
    var func_map = {
	"photo-mk-public": mk_public,
	"photo-mk-private": mk_private,
	"photo-delete": mk_delete,
    };

    for (class_name in func_map){

	var els = document.getElementsByClassName(class_name);
	var count = els.length;
	
	for (var i=0; i < count; i++){
	    
	    var el = els[i];
	    
	    var photo_id = el.getAttribute("data-photo-id");
	    
	    if (! photo_id){
		continue;
	    }
	    
	    el.onclick = func_map[class_name];
	}
    }

}, false);
