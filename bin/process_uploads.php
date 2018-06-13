<?php

	include("init_local.php");
	loadlib("whosonfirst_uploads");
	loadlib("whosonfirst_media");

	# This is the second pass. The first pass and notes about it are below
	# Also it - the first pass - is deprecated and will hopefully be removed
	# shortly (20180613/thisisaaronland)

	loadlib("cli");

	$spec = array(
	 	"config" => array("flag" => "c", "required" => 1, "help" => "A valid INI config file"),
	);

	$opts = cli_getopts($spec);

	$cfg = parse_ini_file($opts["config"], true);

	if (! isset($cfg["api"])){
		echo "config is missing [api] section\n";
		exit(1);
	}

	if (! isset($cfg["api"]["access_token"])){
		echo "config is missing [api] access_token directive\n";
		exit(1);
	}

	$token = trim($cfg["api"]["access_token"]);

	if (! $token){
		echo "config is missing [api] access_token value\n";
		exit(1);
	}

	if (! isset($cfg["api"]["endpoint"])){
		echo "config is missing [api] endpoint directive\n";
		exit(1);
	}

	$endpoint = trim($cfg["api"]["endpoint"]);

	if (! $endpoint){
		echo "config is missing [api] endpoint value\n";
		exit(1);
	}

	$GLOBALS["process_uploads_token"] = $token;
	$GLOBALS["process_uploads_endpoint"] = $endpoint;

	$method = "api.test.echo";

	$rsp = local_api_call($method);

	if (! $rsp["ok"]){
		dumper($rsp);
		exit(1);
	}

	$delay = 2;

	while (1){

		sleep($delay);

		// this gets a pending upload and marks it as queued

		$method = "whosonfirst.uploads.claimPendingUpload";

		$rsp = local_api_call($method);

		if (! $rsp["ok"]){
			# dumper($rsp);
			continue;
		}

		$data = $rsp["response"];

		if (! $data["upload"]){
			# echo "nothing to process\n";
			continue;
		}

		$upload = $data["upload"];

		// this takes an upload and marks it as processing, does
		// stuff and then marks it as failed or completed

		$method = "whosonfirst.uploads.processUpload";

		$args = array(
			"upload_id" => $upload["id"],
		);

		$rsp = local_api_call($method, $args);

		echo "process upload {$upload['id']} : {$rsp['ok']}\n";
	}

	# START OF DEPRECATED

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

	*/

	# END OF DEPRECATED

	echo "all done\n";
	exit();

	#####################################################################

	function local_api_call($method, $args=array()){

		$token = $GLOBALS["process_uploads_token"];
		$endpoint = $GLOBALS["process_uploads_endpoint"];

		$args["method"] = $method;
		$args["access_token"] = $token;

		$url = $endpoint . "?" . http_build_query($args);
		$rsp = http_get($url);

		if (! $rsp["ok"]){
			return $rsp;
		}

		$doc = json_decode($rsp["body"], "as hash");

		if (! $doc){
			$rsp["ok"] = 0;
			$rsp["error"] = "JSON parse error";
			return $rsp;
		}

		return array("ok" => 1, "response" => $doc);
	}
