<?php
	error_reporting(E_ERROR); // print all errors, edit E_ERROR into 0 to hide errors.  
    include('include/config.php');
	include('include/database.php');
    include('include/setting.php');
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
	$id = abs(intval($_GET['id'])); // the id of the item eg: item_id
	$item_sql = "SELECT 
	feeditems.item_id,
	feeditems.item_title,
	feeditems.item_details,
	feeditems.item_url
	FROM feeditems 
	WHERE feeditems.item_id='$id' LIMIT 1";
	$item_query = mysql_query($item_sql);
	$item_row = mysql_fetch_assoc($item_query);
	// assign selected item data to smarty variables
	$smarty->assign('item_id',$item_row['item_id']);
	$smarty->assign('item_title',$item_row['item_title']);
	$smarty->assign('item_details',$item_row['item_details']);
	$smarty->assign('item_url',$item_row['item_url']);
	mysql_query("UPDATE feeditems SET item_hits=item_hits+1 WHERE item_id='$id'"); // update the hits number of this item
	$smarty->display('redirect.html');
?>