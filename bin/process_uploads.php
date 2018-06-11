<?php

	include("init_local.php");
	loadlib("whosonfirst_uploads");
	loadlib("whosonfirst_media");

	# Okay, so this is just the first pass at processing uploads. The principal
	# advantage to this code is that it's simple and dumb. The principal disadvantage
	# to this code is that you need to remember to reload it everytime you update
	# any of the code that it uses. One possibility is to just write the equivalent
	# code to use the API instead which would allow us to do things like write a
	# processing tool in Go and take advantage of more-better locks and parallel
	# tasks and general stability for a background daemon. That mostly just means
	# writing whosonfirst.uploads.getPendingUpload but that hasn't happened yet
	# (20180611/thisisaaronland)

	/*

	// this gets a pending upload and marks it as queued

	$method = "whosonfirst.uploads.claimPendingUpload";

	$args = array(
		"access_token" => $token
	);

	$rsp = something_something_api_call($method, $args);
	$upload = $rsp["data"];

	// this takes an upload and marks it as processing, does
	// stuff and then marks it as failed or completed

	$method = "whosonfirst.uploads.processUpload";

	$args = array(
		"access_token" => $token,
		"upload_id" => $upload["id"],
	);

	$rsp = something_something_api_call($method, $args);
	
	*/

	$status_map = whosonfirst_uploads_status_map("string keys");
	$delay = 1;

	while (1){

		$args = array(
			"per_page" => 1,
			"status_id" => $status_map["pending"],
		);

		$rsp = whosonfirst_uploads_get_uploads($args);
		$upload = db_single($rsp);

		if ($upload){

			$upload_id = $upload["id"];

			$rsp = whosonfirst_uploads_process_upload($upload);

			if (! $rsp["ok"]){
				echo "{$upload_id} failed : {$rsp['error']}\n";
			}

			else {
				echo "{$upload_id} OK\n";
			}
		}

		sleep($delay);
	}

	echo "all done\n";
	exit();