var mapzen = mapzen || {};
mapzen.whosonfirst = mapzen.whosonfirst || {};

// This library is an adaptation of https://github.com/whosonfirst/go-whosonfirst-geojson-v2/blob/master/properties/whosonfirst/whosonfirst.go#L160-L265
// It is designed to work with SPR results, not with full WOF feature
// records. (20171004/dphiffer)

mapzen.whosonfirst.existential = (function(){

	var self = {

		'is_current': function(place){

			if (typeof place['mz:is_current'] != 'undefined' &&
			    (parseInt(place['mz:is_current']) === 1 ||
			     parseInt(place['mz:is_current']) === 0)){
				return parseInt(place['mz:is_current']);
			}
			else if (self.is_deprecated(place) === 1 ||
			         self.is_ceased(place) === 1 ||
			         self.is_superseded(place) === 1){
				return 0;
			}
			else {
				return -1;
			}
		},

		'is_deprecated': function(place){

			if (! place['edtf:deprecated']){
				return 0;
			}
			else if (place['edtf:deprecated'] === 'u' ||
			         place['edtf:deprecated'] === 'uuuu'){
				return -1;
			}
			else {
				return 1;
			}
		},

		'is_ceased': function(place){

			if (typeof place['edtf:cessation'] === 'undefined' ||
			    place['edtf:cessation'] === 'u' ||
			    place['edtf:cessation'] === 'uuuu'){
				return -1;
			}
			else if (! place['edtf:cessation']){
				return 0;
			}
			else {
				return 1;
			}
		},

		'is_superseded': function(place){

			if (place['wof:superseded_by'] &&
			    place['wof:superseded_by'].length > 0){
				return 1;
			}
			else {
				return 0;
			}
		},

		'is_superseding': function(place){

			if (place['wof:supersedes'] &&
			    place['wof:supersedes'].length > 0){
				return 1;
			}
			else {
				return 0;
			}
		}
	};

	return self;

})();
