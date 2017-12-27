<?php

	include("include/init.php");
	loadlib("whosonfirst_brands");

	$more = array();

	if ($page = get_int32("page")){
		$more["page"] = $page;
	}

	if ($q = get_str("q")){

		# see notes in brands.php and note that we are querying the 'brands'
		# index in ES here whereas of this writing the /brands page is faceting
		# against wof:brand_id in the 'spelunker' ES index - this will continue
		# to cause weirdness until we finish backfilling brands and venues...
		# (20171109/thisisaaronland)

		$rsp = whosonfirst_brands_search($q, $more);

		if (! $rsp["ok"]){
			error_500();	# PLEASE FOR PROPER/FRIENDIER ERROR REPORTING
		}

		$rows = $rsp["rows"];
		$pagination = $rsp["pagination"];		

		$GLOBALS["smarty"]->assign_by_ref("query", $q);

		$GLOBALS["smarty"]->assign_by_ref("brands", $rows);
		$GLOBALS["smarty"]->assign_by_ref("pagination", $pagination);		

		$pagination_url = "{$GLOBALS["cfg"]["abs_root_url"]}brands/search/?q=" . urlencode($q);
		$pagination_page_as_queryarg = 1;

		$GLOBALS["smarty"]->assign("pagination_url", $pagination_url);
		$GLOBALS["smarty"]->assign("pagination_page_as_queryarg", $pagination_page_as_queryarg);
	}

	$GLOBALS["smarty"]->display("page_brands_search.txt");
	exit();
?>

