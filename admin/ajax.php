<?php
session_start();
set_time_limit(6000*60); // lengthening the script execution time
error_reporting(E_ERROR);
if(!isset($_SESSION['admin']) OR $_SESSION['admin'] == 0) {
header("location:login.php");
}
include('../include/config.php');
include('../include/database.php');
include('inc/functions.php');
if (isset($_POST['action'])) {
$action = mysql_real_escape_string($_POST['action']); 
} else {
$action = '';
}
// ajax sort categories by drag and drop 
if ($action == "sort_category"){
	$records = $_POST['records'];
	$counter = 1;
	foreach ($records as $record) {
		$query = "UPDATE categories SET category_order='$counter' WHERE category_id='$record'";
		mysql_query($query) or die('Error, insert query failed');
		$counter = $counter + 1;	
	}
}

// ajax validate the feed url
if ($action == "validate_rss"){
	$feed_url = $_POST['feed_url'];
	$sValidator = 'http://feedvalidator.org/check.cgi?url=';
    if( $sValidationResponse = @file_get_contents($sValidator . urlencode($feed_url)) ) {
        if( strpos( $sValidationResponse , 'This is a valid RSS feed' ) !== false OR strpos( $sValidationResponse , 'This is a valid Atom 1.0 feed' ) !== false)
        {
            echo 1;
        }
        else
        {
            echo 0;
        }
    }
    else
    {
        echo 0;
    }
}

// ajax grab feed items
if ($action == "grab_feed_items") {
	require_once('classes/simplepie.inc');
	$id = abs(intval($_POST['id']));
	$query = mysql_query("SELECT * FROM feeds WHERE feed_id='$id'");
	$row = mysql_fetch_assoc($query);
	$category_id = $row['feed_category_id'];
	$feed_id = $row['feed_id'];
	$feed_url = $row['feed_url'];
	$feed_items = $row['feed_items'];
	$feed = new SimplePie();
	$feed->set_useragent();
	$feed->set_feed_url($feed_url);
	
	$feed->init(); 
	$feed->handle_content_type();
	$array = array_reverse($feed->get_items(0,$feed_items));
	foreach ($array AS $item) {
		$link = $item->get_permalink();
		if (strpos($link,'feedproxy') != false) {
		$orig = $item->get_item_tags('http://rssnamespace.org/feedburner/ext/1.0','origLink');
		$permalink = $orig[0]['data'];
		} else {
		$permalink = $link;
		}
		$title = htmlspecialchars($item->get_title(), ENT_QUOTES);
		$details = htmlspecialchars($item->get_content(), ENT_QUOTES);
		$datetime = $item->get_date();
		$unix = time();
		if (check_item_url($permalink) == 0) {
		$insert = mysql_query("INSERT INTO feeditems (item_title,item_url,item_category_id,item_feed_id,item_details,item_datetime,item_unix_datetime,item_published) 
											  VALUES ('$title','$permalink','$category_id','$feed_id','$details','$datetime','$unix','1')");
		}
	}
	$now = time();
	mysql_query("UPDATE feeds SET feed_last_update='$now' WHERE feed_id='$id'");
}

// ajax pin & unpin the feed item
if ($action == "pin_item"){
	$id = abs(intval($_POST['id']));
	$check = mysql_num_rows(mysql_query("SELECT item_id,item_pinned FROM feeditems WHERE item_id='$id' AND item_pinned='0' LIMIT 1"));
	if ($check == 0) {
	mysql_query("UPDATE feeditems SET item_pinned='0' WHERE item_id='$id'");
	echo 0;
	} else {
	mysql_query("UPDATE feeditems SET item_pinned='1' WHERE item_id='$id'");
	echo 1;
	}
}

// ajax delete feed logo
if ($action == "delete_feed_logo"){
	$id = abs(intval($_POST['id']));
	$select = mysql_query("SELECT * FROM feeds WHERE feed_id='$id' LIMIT 1");
	$row = mysql_fetch_array($select);
	@unlink('../upload/feeds_logos/'.$row['feed_logo']);
	$delete = mysql_query("UPDATE feeds SET feed_logo='' WHERE feed_id='$id'");
	if ($delete) {
	echo 1;
	}
}
?>
