<?php
	error_reporting(E_ERROR); // print all errors, edit E_ALL into 0 to hide errors.  
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
	$smarty->assign('page_title',$seo_title.' | Top Hits Items'); // title of the page
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
	$smarty->assign('top_hits_items_number',$top_hits_items_number); // number of items in each page
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
	$smarty->assign('categories',$categories);
	}
	// period variable 
	if (isset($_GET['period'])) {$period = strip_tags(trim(mysql_real_escape_string(addslashes($_GET['period']))));} else {$period = 'all';}
	$smarty->assign('period',$period);
	switch ($period) {
	case 'lasthour'; // period = day, it will extract the results of today.
	$lasthour = time()-3600; // time() = now time in unix timestamp, 3600 = 1 hour in unix timestamp; total amount of seconds in 1 hour
	$period_sql = " AND item_unix_datetime > $lasthour";
	break;
	case 'lastsixhours'; // period = day, it will extract the results of today.
	$lastsixhours = time()-21600; // time() = now time in unix timestamp, 21600 = 6 hours in unix timestamp; total amount of seconds in 6 hours
	$period_sql = " AND item_unix_datetime > $lastsixhours";
	break;
	case 'day'; // period = day, it will extract the results of today.
	$day = time()-86400; // time() = now time in unix timestamp, 86400 = 1 day in unix timestamp; total amount of seconds in 24 hours
	$period_sql = " AND item_unix_datetime > $day";
	break;
	case 'week'; // period = week, it will extract the results of this week.
	$week = time()-604800; // 604800 = 7 days in unix timestamp; total amount of seconds in 7 days
	$period_sql = " AND item_unix_datetime > $week";
	break;
	case 'month'; // period = month, it will extract the results of this month.
	$month = time()-2592000; // 2592000 = 30 days in unix timestamp; total amount of seconds in 30 days
	$period_sql = " AND item_unix_datetime > $month";
	break;
	default; // extract all the results.
	$period_sql = "";
	}
	// top items loop
	$newitems_sql = "SELECT 
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
	WHERE feeditems.item_published='1' AND feeditems.item_hits > 0 $period_sql
	ORDER BY feeditems.item_hits DESC LIMIT $top_hits_items_number";
	$newitems_query = mysql_query($newitems_sql);
	$isthere = mysql_num_rows($newitems_query);
	$smarty->assign('isthere',$isthere);
	if ($isthere > 0) {
	while ($newitems_row = mysql_fetch_array($newitems_query)) {
		$newitems[] = $newitems_row;
	}
	$smarty->assign('items',$newitems);
	}
	$smarty->display('top_items.html');
?>