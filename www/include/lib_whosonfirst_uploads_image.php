<?php

	loadlib("whosonfirst_uploads");
	loadlib("whosonfirst_media");

	loadlib("mime_type");

	########################################################################

	function whosonfirst_uploads_image_process_upload(&$upload){

		# SEE THIS???? WE'RE NOT ACTUALLY PROCESSING ANYTHING. PLEASE 
		# FIX ME... (20180507/thisisaaronland)

		# something something something https://github.com/aaronland/go-iiif
		# (20180509/thisisaaronland)

		$derivatives = array();

		$type = $upload["file"]["type"];
		$ext = mime_type_get_extension($type);

		$upload_path = whosonfirst_uploads_id2abspath($upload["id"]);
		$processed_path = $upload_path . ".{$ext}";

		if (! rename($upload_path, $processed_path)){
			return array("ok" => 0, "error" => "failed to rename media");
		}

		return whosonfirst_media_import_media_with_upload($upload, $processed_path, $derivatives);
	}

	########################################################################

	# the end