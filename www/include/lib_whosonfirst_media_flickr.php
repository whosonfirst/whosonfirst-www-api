<?php

	loadlib("flickr_api");

	#################################################################

	function whosonfirst_media_flickr_fetch_photo_id($photo_id){

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
		
		/*

		<licenses>
		  <license id="0" name="All Rights Reserved" url="" />
		  <license id="1" name="Attribution-NonCommercial-ShareAlike License" url="https://creativecommons.org/licenses/by-nc-sa/2.0/" />
		  <license id="2" name="Attribution-NonCommercial License" url="https://creativecommons.org/licenses/by-nc/2.0/" />
		  <license id="3" name="Attribution-NonCommercial-NoDerivs License" url="https://creativecommons.org/licenses/by-nc-nd/2.0/" />
		  <license id="4" name="Attribution License" url="https://creativecommons.org/licenses/by/2.0/" />
		  <license id="5" name="Attribution-ShareAlike License" url="https://creativecommons.org/licenses/by-sa/2.0/" />
		  <license id="6" name="Attribution-NoDerivs License" url="https://creativecommons.org/licenses/by-nd/2.0/" />
  		  <license id="7" name="No known copyright restrictions" url="https://www.flickr.com/commons/usage/" />
		  <license id="8" name="United States Government Work" url="http://www.usa.gov/copyright.shtml" />
		  <license id="9" name="Public Domain Dedication (CC0)" url="https://creativecommons.org/publicdomain/zero/1.0/" />
		  <license id="10" name="Public Domain Mark" url="https://creativecommons.org/publicdomain/mark/1.0/" />
		</licenses>

		*/

		$license = intval($info["license"]);

		if ($license == 0){
			return array("ok" => 0, "error" => "Flickr license does not allow uploading");
		}

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

		$sz = filesize($tmppath);
		$type = mime_content_type($tmppath);

		$file = array(
			"tmp_name" => $tmppath,
			"name" => $tmpname,
			"size" => $sz,
			"type" => $type,
			"error" => 0,
			"isnot_upload" => 1,	# should this go here... ? (20180515/thisisaaronland)
		);

		$files = array(
			$file,
		);

		return array("ok" => 1, "files" => $files, "info" => $info);
	}

	#################################################################	

	# the end