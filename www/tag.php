<?php

	include("include/init.php");
	loadlib("whosonfirst_places");

	$tag = get_str("tag");

	if (! $tag){
		error_404();
	}

	$GLOBALS["smarty"]->assign("tag", $tag);

	$filters = array();

	$filters[] = array("query" => array(
		'match' => array("wof:placetype" => array(
			'query' => "venue", 'operator' => 'and'
		)
	)));

	if ($wofid = get_int64("wofid")){

		$place = whosonfirst_places_get_by_id($wofid);

		if (! $place){
			error_404();
		}

		$esc_wofid = elasticsearch_escape($wofid);

		$filters[] = array("query" => array(
			'match' => array("wof:belongsto" => array(
				'query' => $esc_wofid, 'operator' => 'and'
			)
		)));

		$GLOBALS["smarty"]->assign_by_ref("place", $place);
	}

	$args = array();

	if ($page = get_int32("page")){
		$args["page"] = $page;
	}

	$rsp = whosonfirst_places_get_tagged($tag, $filters, $args);

	$GLOBALS["smarty"]->assign_by_ref("results", $rsp["rows"]);
	$GLOBALS["smarty"]->assign_by_ref("pagination", $rsp["pagination"]);

	$GLOBALS["smarty"]->display("page_tag.txt");
	exit();

?>
