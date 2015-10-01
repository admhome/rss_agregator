<?php
	set_time_limit(6000*60); // lengthening the script execution time
	error_reporting(E_ERROR);
	include('include/config.php'); // include database config
	include('include/database.php'); // include database connect
	require_once('include/simplepie/simplepie.inc'); // include simplepie lib
	
	// function to prevent duplicate items
	function check_item_url($url) {
		$check = mysql_num_rows(mysql_query("SELECT item_url FROM feeditems WHERE item_url='$url' LIMIT 1"));
		return $check;
	}
	
	// feed sources loop
	$query = mysql_query("SELECT * FROM feeds ORDER BY feed_id ASC");
	while ($row = mysql_fetch_assoc($query)) {
	$category_id = $row['feed_category_id'];
	$feed_id = $row['feed_id'];
	$feed_url = $row['feed_url'];
	$feed_items = $row['feed_items'];
	$feed = new SimplePie();
	$feed->set_useragent('gecko');
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
		$datetime = $item->get_date('j-n-Y');
		$unix = time();
		if (check_item_url($permalink) == 0) {
		$insert = mysql_query("INSERT INTO feeditems (item_title,item_url,item_category_id,item_feed_id,item_details,item_datetime,item_unix_datetime,item_published) 
											  VALUES ('$title','$permalink','$category_id','$feed_id','$details','$datetime','$unix','1')");
		}
	}
	$now = time();
	mysql_query("UPDATE feeds SET feed_last_update='$now' WHERE feed_id='$feed_id'"); 
	}