<?php

	loadlib("whosonfirst_uploads");
	loadlib("whosonfirst_media");

	loadlib("mime_type");

	# maybe update to use a vanilla golang reader so as not to require
	# both pdfbox and java (20180517/thisisaaronland)

	loadlib("pdfbox");

	########################################################################

	function whosonfirst_uploads_pdf_process_upload(&$upload){

		$type = $upload["file"]["type"];
		$ext = mime_type_get_extension($type);

		$upload_path = whosonfirst_uploads_id2abspath($upload["id"]);
		$processed_path = $upload_path . ".{$ext}";

		if (! rename($upload_path, $processed_path)){
			return array("ok" => 0, "error" => "failed to rename media");
		}

		$derivatives = array();

		# See the way we are writing to disk here? As in not passing the -console
		# flag? That's on purpose. Don't pass the console flag because you might
		# be thinking "I know... I'll just store the raw text in the database alongside
		# everything else". Don't worry, I thought the same thing. It's a bad idea.
		# (20180517/thisisaaronland)

		$rsp = pdfbox_exec("ExtractText", array($processed_path));

		if (! $rsp["ok"]){
			return $rsp;
		}

		$text_path = $upload_path . ".txt";

		if (! file_exists($text_path)){

			error_log("Text extraction worked but can't find output file");
		}

		else {

			if (filesize($text_path) > 0){
				$derivatives["t"] = $text_path;
			}
		}

		# it would be nice to call java -jar /usr/local/bin/pdfbox.jar PDFToImage
		# but it will almost certainly take too long and time out unless this is
		# being invoked as an offline task (20180516/thisisaaronland)

		# maybe just the cover image... (20180516/thisisaaronland)

		return whosonfirst_media_import_media_with_upload($upload, $processed_path, $derivatives);
	}

	########################################################################

	# the end