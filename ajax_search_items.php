<?php
	error_reporting(E_ERROR); // print all errors, edit E_ERROR into 0 to hide errors.  
    include('include/config.php');
	include('include/database.php');
	include('include/functions.php');
    include('include/setting.php');
    require_once('include/smarty/Smarty.class.php');
	// Smarty define class and options
    $smarty = new Smarty;
    $smarty->compile_check = false;
    $smarty->compile_dir = 'cache'; // it should be writable
    $smarty->force_compile = true;
    $smarty->template_dir = 'templates/'.$site_template; // $site_template variable is derived from database in include/setting.php
	$smarty->assign('direct_links',$direct_links); // if value = 1 item links will point to source directly
	$smarty->assign('friendly_urls',$friendly_urls); // if value = 1 item links will be rewritten using htaccess
	$offset = is_numeric($_POST['offset']) ? $_POST['offset'] : die('error');
	$postnumbers = is_numeric($_POST['number']) ? $_POST['number'] : die('error');
	$q = strip_tags(trim(mysql_real_escape_string(addslashes($_GET['q'])))); // the search word variable
	// extract new feed items from database
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
	WHERE feeditems.item_published='1' AND feeditems.item_title LIKE '%$q%' /*sql_no_cache*/
	ORDER BY feeditems.item_id DESC LIMIT $postnumbers OFFSET $offset";
	$newitems_query = mysql_query($newitems_sql);
	$isthere = mysql_num_rows($newitems_query);
	$smarty->assign('isthere',$isthere);
	if ($isthere > 0) {
	while ($newitems_row = mysql_fetch_array($newitems_query)) {
		$items[] = $newitems_row;
	}
	$smarty->assign('items',$items); // assign the new feed items loop to smarty.
	$smarty->display('ajax_search_items.html'); 
	}
?>