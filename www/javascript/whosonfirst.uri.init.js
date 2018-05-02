window.addEventListener("load", function load(event){

    if (typeof(whosonfirst.uri) != 'object'){
	return false;
    }

    alt = document.body.getAttribute("data-abs-root-url-data");

    if (alt){
	whosonfirst.uri.endpoint(alt);
    }
    
}, false);
