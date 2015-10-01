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
	$q = strip_tags(trim(mysql_real_escape_string(addslashes($_GET['q'])))); // the search word variable
	$smarty->assign('q',$q);
	// the number of feed items that match the search word
	$items_number = mysql_num_rows(mysql_query("SELECT item_title FROM feeditems WHERE item_published='1' AND item_title LIKE '%$q%' /*sql_no_cache*/"));
	$smarty->assign('items_number',$items_number);
	if ($items_number > 0) { // is there feed items match the search word
	$page = 1;
	$size = 12; 
	if (isset($_GET['page'])){ $page = abs(intval($_GET['page'])); }
	$pagination = new Pagination();
	$pagination->setLink("search.php?q=$q&page=%s");
	$pagination->setPage($page);
	$pagination->setSize($size);
	$pagination->setTotalRecords($items_number);
	// the loop of feed items that match the search word
	$search_sql = "SELECT 
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
	WHERE feeditems.item_published='1' AND feeditems.item_title LIKE '%$q%' /*sql_no_cache*/
	ORDER BY feeditems.item_id DESC ". $pagination->getLimitSql();
	$search_query = mysql_query($search_sql);
	while ($search_rows = mysql_fetch_assoc($search_query)) {
		$search[] = $search_rows;
	}
	$smarty->assign('items',$search); // assign the feed items result to smarty
	$smarty->assign('pagi',$pagination->create_links()); // assign the paginations result to smarty
	}
	$smarty->assign('page_title',$seo_title.' | Search Results For : '.$q); // title of the page
	$smarty->display('search.html'); // display all the assigned data in a template 'search.html'
?>