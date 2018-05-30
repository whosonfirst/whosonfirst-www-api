var whosonfirst = whosonfirst || {};
whosonfirst.dropbox = whosonfirst.dropbox || {};

// https://developer.mozilla.org/en-US/docs/Web/API/HTML_Drag_and_Drop_API/File_drag_and_drop

whosonfirst.dropbox = (function(){

    callbacks = {};

    var self = {

	'register_callback': function(id, cb){
	    self.log("info", "register callback for " + id);
	    callbacks[id] = cb;
	},

	'ondrag': function(e){
	    // var dt = new Date();
	    // console.log("on drag", dt);
	    e.preventDefault();
	},

	'ondrop': function(e){

	    e.preventDefault();

	    var files = new Array();

	    if (e.dataTransfer.items) {

		// console.log("DataTransferItemList");

		for (var i = 0; i < e.dataTransfer.items.length; i++) {

		    if (e.dataTransfer.items[i].kind === 'file') {
			files.push(e.dataTransfer.items[i].getAsFile());
		    }
		}

	    } else {
		// console.log("DataTransfer");		
		files = e.dataTransfer.files;
	    } 

	    var id = e.target.id;
	    var cb = callbacks[id];

	    if (! cb){
		self.log("error", "can't find callback for ID '" + id + "'");
		cb = self.list_files;
	    }

	    cb(files);

	    self.cleanup(e);  
	},

	'list_files': function(files) {

	    for (var i = 0; i < files.length; i++){
		console.log(i, files[i].name);
	    }

	},
	
	'cleanup': function(e) {

	    if (e.dataTransfer.items) {
		e.dataTransfer.items.clear();
	    } else {
		e.dataTransfer.clearData();
	    }
	},

	'log': function(level, message){
	    
	    if (typeof(whosonfirst.log) != 'object'){
		console.log("[whosonfirst.dropbox]", level, message);
		return;
	    }
	    
	    whosonfirst.log.dispatch(message, level);
	}

    };

    return self;

})();
