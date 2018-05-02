window.addEventListener("load", function load(event){

    if (! document.getElementById("map")) {
	return;
    }
    
    var map = whosonfirst.map.nextzen.get_map("map");

    whosonfirst.map.results.init(map);
    whosonfirst.map.results.draw();

}, false);
