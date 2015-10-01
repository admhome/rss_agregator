<?php
	error_reporting(E_ERROR); // print all errors, edit E_ERROR into 0 to hide errors.  
    include('include/config.php');
	include('include/database.php');
    include('include/setting.php');
	include('include/functions.php');
    require_once('include/smarty/Smarty.class.php');
	// Smarty define class and options
    $smarty = new Smarty;
    $smarty->compile_check = false;
    $smarty->compile_dir = 'cache'; // it should be writable
    $smarty->force_compile = true;
    $smarty->template_dir = 'templates/'.$site_template; // $site_template variable is derived from database in include/setting.php
	// Assign include/setting.php variables
	$smarty->assign('seo_title',$seo_title); // title of the page
	$smarty->assign('page_title',$seo_title.' | Feed Sources'); // title of the page
	$smarty->assign('seo_keywords',$seo_keywords); // page's keywords
	$smarty->assign('seo_description',$seo_description); // page's description
	$smarty->assign('ad_slot_728',$ad_slot_728); // ad code for 728/90 ad space
	$smarty->assign('ad_slot_300',$ad_slot_300); // ad code for 300/250 ad space
	$smarty->assign('friendly_urls',$friendly_urls); // if value = 1 item links will be rewritten using htaccess
	$smarty->assign('pagination_style',$pagination_style); // 1 = php pagination, 2 = load more pagination, 3 = infinite scroll
	$smarty->assign('display_rss',$display_rss); // if value = 1 rss link appeared
	$smarty->assign('display_category_rss',$display_category_rss); // if value = 1 rss link appeared in each category
	$smarty->assign('facebook',$facebook); // facebook link
	$smarty->assign('twitter',$twitter); // twitter link
	$smarty->assign('google_plus',$google_plus); // google+ link
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
	// feed source loop
	$sources_sql = "SELECT 
	feeds.feed_id,
	feeds.feed_title,
	feeds.feed_url,
	feeds.feed_logo,
	feeds.feed_category_id,
	feeds.feed_last_update,
	categories.category_id,
	categories.category_title
	FROM feeds JOIN categories
	ON feeds.feed_category_id=categories.category_id
	ORDER BY feeds.feed_id ASC";
	$sources_query = mysql_query($sources_sql);
	$isthere = mysql_num_rows($sources_query);
	$smarty->assign('isthere',$isthere);
	if ($isthere > 0) {
	while ($sources_row = mysql_fetch_array($sources_query)) {
		$sources[] = $sources_row;
	}
	$smarty->assign('sources',$sources);
	}
	$smarty->display('sources.html');
?>