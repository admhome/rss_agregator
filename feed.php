<?php
	error_reporting(E_ERROR); // print all errors, edit E_ERROR into 0 to hide errors.  
    include('include/config.php');
	include('include/database.php');
    include('include/functions.php');
	include('include/setting.php');
	include('include/pagination.class.php');
    require_once('include/smarty/Smarty.class.php');
	// Smarty define class and options
    $smarty = new Smarty;
    $smarty->compile_check = false;
    $smarty->compile_dir = 'cache'; // it should be writable
    $smarty->force_compile = true;
    $smarty->template_dir = 'templates/'.$site_template; // $site_template variable is derived from database in include/setting.php
	// Assign include/setting.php variables
	$smarty->assign('seo_title',$seo_title); // title of the page
	$smarty->assign('seo_keywords',$seo_keywords); // page's keywords
	$smarty->assign('seo_description',$seo_description); // page's description
	$smarty->assign('ad_slot_728',$ad_slot_728); // ad code for 728/90 ad space
	$smarty->assign('ad_slot_300',$ad_slot_300); // ad code for 300/250 ad space
	$smarty->assign('direct_links',$direct_links); // if value = 1 item links will point to source directly
	$smarty->assign('friendly_urls',$friendly_urls); // if value = 1 item links will be rewritten using htaccess
	$smarty->assign('pagination_style',$pagination_style); // 1 = php pagination, 2 = load more pagination, 3 = infinite scroll
	$smarty->assign('display_rss',$display_rss); // if value = 1 rss link appeared
	$smarty->assign('display_category_rss',$display_category_rss); // if value = 1 rss link appeared in each category
	$smarty->assign('facebook',$facebook); // facebook link
	$smarty->assign('twitter',$twitter); // twitter link
	$smarty->assign('google_plus',$google_plus); // google+ link
	$smarty->assign('category_items_number',$category_items_number); // number of items in each page
	$smarty->assign('display_calendar',$display_calendar); // option to display/hide calendar widget
	$smarty->assign('google_analytics',$google_analytics); // google analytics tracking code
	// extract categories information from database
	$categories_sql = "SELECT category_id,category_title,category_order FROM categories ORDER BY category_order ASC";
	$categories_query = mysql_query($categories_sql);
	$categories_number = mysql_num_rows($categories_query);
	$smarty->assign('categories_number',$categories_number);
	if ($categories_number > 0) {
	while ($categories_row = mysql_fetch_assoc($categories_query)) {
		$categories[] = $categories_row;
	}
	$smarty->assign('categories',$categories); // assign the categories loop to smarty.
	}
	$id = abs(intval($_GET['id'])); // the id of the category
	// extract the category data
	$sql = mysql_query("SELECT * FROM feeds WHERE feed_id='$id' LIMIT 1");
	$row = mysql_fetch_array($sql);
	$smarty->assign('feed_id',$row['feed_id']); // assign the feed id
	$smarty->assign('feed_title',$row['feed_title']); // assign the feed title
	$items_number = mysql_num_rows(mysql_query("SELECT item_feed_id FROM feeditems WHERE item_feed_id='$id' AND item_published='1'"));
	$smarty->assign('items_number',$items_number);
	if ($items_number > 0) { // if feed items number is more than 0
	$page = 1;
	$size = $category_items_number; // extracted from include/setting.php
	if (isset($_GET['page'])){ $page = abs(intval($_GET['page'])); }
	// define the pagination class (include/pagination.class.php)
	$pagination = new Pagination();
	if ($friendly_urls == 1) {
	$pagination->setLink("feed-$id-%s-".url_slug($row['feed_title'])); // set the link of the pages
	} else {
	$pagination->setLink("feed.php?id=$id&page=%s"); // set the link of the pages
	}
	$pagination->setPage($page);
	$pagination->setSize($size);
	$pagination->setTotalRecords($items_number);
	// feed items in feed
	$category_sql = "SELECT 
	feeditems.item_id,
	feeditems.item_title,
	feeditems.item_feed_id,
	feeditems.item_category_id,
	feeditems.item_published,
	feeditems.item_url,
	feeditems.item_datetime,
	feeditems.item_unix_datetime,
	feeditems.item_details,
	feeditems.item_pinned,
	feeditems.item_hits,
	categories.category_id,
	categories.category_title
	FROM feeditems JOIN categories
	ON feeditems.item_category_id=categories.category_id
	WHERE feeditems.item_feed_id='$id' AND feeditems.item_published='1'
	ORDER BY feeditems.item_id DESC ". $pagination->getLimitSql();
	$category_query = mysql_query($category_sql);
	while ($category_rows = mysql_fetch_assoc($category_query)) {
		$category[] = $category_rows;
	}
	$smarty->assign('items',$category); // assign the feed items loop to smarty
	$smarty->assign('pagi',$pagination->create_links()); // assign the paginations result to smarty
	}
	$smarty->assign('page_title',$seo_title.' | '.$row['feed_title']); // title of the page
	$smarty->display('feed.html'); // display all the assigned data in a template 'feed.html'
?>