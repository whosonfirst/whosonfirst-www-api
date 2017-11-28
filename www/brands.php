<?php

	include("include/init.php");
	loadlib("whosonfirst_brands");
	loadlib("whosonfirst_places");

	$more = array();

	if ($page = get_int32("page")){
		$more["page"] = $page;
	}

	# hey look - see the way we're not doing this:
	#
	# $rsp = whosonfirst_brands_get_brands($more);
	#
	# there are three reasons for this: 
	#
	# 1. we don't have denormalized counts or size informtion
	#    on individual brand records to sort or filter on
	# 2. we have about ~5000K brands that haven't been associated
	#    with venue records yet
	# 3. we need to fix the (smarty) pagination widget and probably
	#    all the underlying PHP pagination code/checks to handle
	#    cursors because the future still sucks...
	# 4. surprise! actually (3) is only half-true meaning that it's 
	#    true and we should do all those things but we can (and do
	#    in elasticsearch_brands_append_config) set the "scroll" flag
	#    we pass to ES to false to explicitly disable cursor-based
	#    pagination - none of which changes the underlying reasons
	#    why we had to do to cursor-based pagination in the first place
	#    and all those problems will eventually haunt brands so really
	#    just do the work in (3)...
	#
	# so instead we're going to facet against those venues that do
	# have a wof:brand_id property and work from there... did I mention
	# that the future still sucks? (20171109/thisisaaronland)

	$rsp = whosonfirst_places_get_brands($more);

	if (! $rsp["ok"]){
		error_500();	# PLEASE FOR PROPER/FRIENDIER ERROR REPORTING
	}

	$rows = $rsp["rows"];
	$pagination = $rsp["pagination"];

	$lookup = array();
	$ids = array();

	foreach ($rows as $row){
		$lookup[$row["key"]] = $row["doc_count"];
		$ids[] = $row["key"];	# preserve ordering. yeah?
	}
	
	$rsp = whosonfirst_brands_get_by_id_multi($ids);

	if (! $rsp["ok"]){
		error_500();	# PLEASE FOR PROPER/FRIENDIER ERROR REPORTING
	}

	$rows = $rsp["rows"];

	foreach ($rows as &$row){
	
		$brand_id = $row["wof:brand_id"];
		$row["places_count"] = $lookup[$brand_id];
	}
	

	$GLOBALS["smarty"]->assign_by_ref("brands", $rows);
	$GLOBALS["smarty"]->assign_by_ref("pagination", $pagination);

	$GLOBALS["smarty"]->display("page_brands.txt");
	exit();

?>