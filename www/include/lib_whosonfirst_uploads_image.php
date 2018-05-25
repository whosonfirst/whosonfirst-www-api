<?php

	loadlib("whosonfirst_uploads");
	loadlib("whosonfirst_media");
	loadlib("whosonfirst_media_iiif");

	loadlib("mime_type");

	########################################################################

	function whosonfirst_uploads_image_process_upload(&$upload){

		$file = $upload["file"];

		if (! is_array($file)){

			$file = json_decode($file, "as hash");

			if (! $file){
				return array("ok" => 0, "error" => "Unable to parse file information");
			}
		}

		$original_processed = null;
		$derivatives_processed = array();

		$type = $file["type"];
		$ext = mime_type_get_extension($type);

		$upload_path = whosonfirst_uploads_id2abspath($upload["id"]);

		if (features_is_enabled("whosonfirst_media_iiif")){

			$source = whosonfirst_uploads_id2relpath($upload["id"]);

			$instructions = $GLOBALS["cfg"]["iiif_default_instructions"];
			$instructions["o"]["format"] = $ext;

			$args = array(
				"destination" => $GLOBALS["cfg"]["whosonfirst_uploads_pending_dir"],
			);

			$rsp = whosonfirst_media_iiif_process_image($source, $instructions, $args);

			if (! $rsp["ok"]){		
				return $rsp;
			}

			$processed = $rsp["processed"];

			$original_processed = $processed["o"];
			unset($processed["o"]);

			$derivatives_processed = $processed;
		}

		else {

			$original_processed = $upload_path . ".{$ext}";

			if (! copy($upload_path, $original_processed)){
				return array("ok" => 0, "error" => "failed to rename media");
			}
		}

		$rsp = whosonfirst_media_import_media_with_upload($upload, $original_processed, $derivatives_processed);

		if ($rsp["ok"]){
			unlink($upload_path);
		}

		return $rsp;
	}

	########################################################################

	# the end