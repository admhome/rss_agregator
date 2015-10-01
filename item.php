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
	$id = abs(intval($_GET['id'])); // the id of the item eg: item_id
	$item_sql = "SELECT 
	feeditems.item_id,
	feeditems.item_title,
	feeditems.item_feed_id,
	feeditems.item_category_id,
	feeditems.item_published,
	feeditems.item_url,
	feeditems.item_details,
	feeditems.item_datetime,
	feeditems.item_unix_datetime,
	feeditems.item_pinned,
	feeditems.item_hits,
	feeds.feed_id,
	feeds.feed_title,
	feeds.feed_url
	FROM feeditems JOIN feeds
	ON feeditems.item_feed_id=feeds.feed_id
	WHERE feeditems.item_published='1' AND feeditems.item_id='$id' LIMIT 1";
	$item_query = mysql_query($item_sql);
	$item_row = mysql_fetch_assoc($item_query);
	// assign selected item data to smarty variables
	$smarty->assign('item_id',$item_row['item_id']);
	$smarty->assign('item_title',$item_row['item_title']);
	$smarty->assign('item_details',$item_row['item_details']);
	$smarty->assign('item_url',$item_row['item_url']);
	$smarty->assign('item_unix_datetime',$item_row['item_unix_datetime']);
	$smarty->assign('item_category_id',$item_row['item_category_id']);
	$smarty->assign('feed_id',$item_row['feed_id']);
	$smarty->assign('feed_title',$item_row['feed_title']);
	$smarty->assign('item_hits',$item_row['item_hits']);
	// related items loop
	$related_sql = "SELECT 
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
	WHERE feeditems.item_published='1' AND feeditems.item_id != '$item_row[item_id]' AND MATCH (feeditems.item_title) AGAINST ('$item_row[item_title]' IN BOOLEAN MODE)
	ORDER BY feeditems.item_id DESC LIMIT 3";
	$related_query = mysql_query($related_sql);
	$isthererelated = mysql_num_rows($related_query);
	$smarty->assign('isthererelated',$isthererelated);
	if ($isthererelated > 0) {
	while ($related_row = mysql_fetch_array($related_query)) {
	$related[] = $related_row;
	}
	$smarty->assign('related',$related);
	}
	mysql_query("UPDATE feeditems SET item_hits=item_hits+1 WHERE item_id='$id'"); // update the hits number of this item
	$smarty->assign('page_title',$seo_title.' | '.$item_row['item_title']); // title of the page
	$smarty->display('item.html');
?>