<?php

	loadlib("flickr_api");

	#################################################################

	function whosonfirst_photos_flickr_fetch_photo_id($photo_id){

		# are we even set up to deal with this stuff

		$tmpdir = $GLOBALS['cfg']['flickr_pending_dir'];

		if (! is_dir($tmpdir)){
			return array("ok" => 0, "error" => "flickr pending dir is misconfigured");
		}

		# first get the details about this photo for safe-keeping

		$method = "flickr.photos.getInfo";
		$args = array("photo_id" => $photo_id);

		$rsp = flickr_api_call($method, $args);

		if (! $rsp["ok"]){
			return $rsp;
		}

		$info = $rsp["rsp"]["photo"];

		# now figure out the largest size to import

		$method = "flickr.photos.getSizes";
		$args = array("photo_id" => $photo_id);

		$rsp = flickr_api_call($method, $args);

		if (! $rsp["ok"]){
			return $rsp;
		}
		
		$sizes = $rsp["rsp"]["sizes"];

		if (! $sizes["candownload"]){
			return array("ok" => 0, "error" => "Can not download");
		}

		$sizes = $sizes["size"];

		if (count($sizes) == 0){
			return array("ok" => 0, "error" => "Nothing to download");
		}

		$idx = count($sizes) - 1;

		$biggest = $sizes[$idx];
		$url = $biggest["source"];

		# now we actually get the photo itself

		$rsp = http_get($url);

		if (! $rsp){
			return $rsp;
		}

		$now = time();

		$tmpname = "flickr-{$photo_id}-{$now}";

		$tmppath = $tmpdir . DIRECTORY_SEPARATOR . $tmpname;

		$fh = fopen($tmppath, "w");

		if (! $fh){
			return array("ok" => 0, "error" => "Failed to open tmp file");
		}

		fwrite($fh, $rsp["body"]);
		fclose($fh);

		if (! file_exists($tmppath)){
			return array("ok" => 0, "error" => "waaaaah");
		}

		$file = array(
			"tmp_name" => $tmppath,
			"name" => $tmpname,
			"isnot_upload" => 1,	# should this go here... ? (20180515/thisisaaronland)
		);

		$files = array(
			$file,
		);

		return array("ok" => 1, "files" => $files, "info" => $info);
	}

	#################################################################	

	# the end