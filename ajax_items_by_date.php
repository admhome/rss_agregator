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
	$offset = is_numeric($_POST['offset']) ? $_POST['offset'] : die('error');
	$smarty->assign('direct_links',$direct_links); // if value = 1 item links will point to source directly
	$smarty->assign('friendly_urls',$friendly_urls); // if value = 1 item links will be rewritten using htaccess
	$postnumbers = is_numeric($_POST['number']) ? $_POST['number'] : die('error');
	$date = strip_tags(trim(mysql_real_escape_string(addslashes($_GET['date']))));
	$smarty->assign('date',$date);
	$date_array = explode('-',$date);
	$smarty->assign('month',$date_array[1]);
	$smarty->assign('year',$date_array[2]);
	$unix_date = mktime(0,0,0,$date_array[1],$date_array[0],$date_array[2]);
	$to_unix_date = $unix_date+86400;
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
	WHERE feeditems.item_published='1' AND item_unix_datetime BETWEEN $unix_date AND $to_unix_date
	ORDER BY feeditems.item_id DESC LIMIT $postnumbers OFFSET $offset";
	$category_query = mysql_query($category_sql);
	$isthere = mysql_num_rows($category_query);
	$smarty->assign('isthere',$isthere);
	if ($isthere > 0) {
	while ($category_rows = mysql_fetch_assoc($category_query)) {
		$category[] = $category_rows;
	}
	$smarty->assign('items',$category); // assign the feed items loop to smarty
	$smarty->display('ajax_items_by_date.html');
	}
?>