<?php
error_reporting(E_ERROR);
include ('include/config.php');
include ('include/database.php');
include ('include/functions.php');
include ('include/rss.php');
include ('include/setting.php');
if (!isset($rss_items_number) OR $rss_items_number == 0) {
$number = 10;
} else {
$number = $rss_items_number;
}
$siteurl = str_replace('/rss.php','',currentURL());
$siteurl = str_replace('/rss.xml','',currentURL());
$category = abs(intval($_GET['category']));
	if (empty($category) OR $category == 0) {
		$feed = new RSS();
		$feed->title       = "$seo_title";
		$feed->link        = "$siteurl";
		$feed->description = "$seo_description";
		$result = mysql_query("SELECT * FROM feeditems WHERE item_published='1' ORDER BY item_id DESC LIMIT $number");
		while($row = mysql_fetch_array($result))
		{
			$shortdes = substr(strip_tags(htmlspecialchars_decode($row['item_details'], ENT_QUOTES)),0,255);
			$item = new RSSItem();
			$item->title = htmlspecialchars_decode($row['item_title'], ENT_QUOTES);
			if ($friendly_urls == 1) {
			$item->link  = "$siteurl/item-$row[item_id]-".url_slug($row['item_title']);
			} else {
			$item->link  = "$siteurl/item.php?id=$row[item_id]";
			}
			$item->description = "<![CDATA[ $shortdes ]]>";
			$item->PubDate = date('D, d M Y H:i:s ',$row['item_unix_datetime']);
			$feed->addItem($item);
		}
		echo $feed->serve();
	} else {
	$siteurl = str_replace("/rss.php?category=$category",'',currentURL());
	$siteurl = str_replace("/rss-category-$category.xml",'',currentURL());
	$category_sql = mysql_query("SELECT * FROM categories WHERE category_id='$category' LIMIT 1");
	$c_row = mysql_fetch_array($category_sql);
		$feed = new RSS();
		$feed->title       = "$c_row[category_title]";
		if ($friendly_urls == 1) {
		$feed->link        = "$siteurl/category.php?id=$category";
		} else {
		$feed->link        = "$siteurl/category-$category-".url_slug($c_row['category_title']);
		}
		$feed->description = "$c_row[category_title]";
		$result = mysql_query("SELECT * FROM feeditems WHERE item_published='1' ORDER BY item_id DESC LIMIT $number");
		while($row = mysql_fetch_array($result))
		{
			$shortdes = substr(strip_tags(htmlspecialchars_decode($row['item_details'], ENT_QUOTES)),0,255);
			$item = new RSSItem();
			$item->title = htmlspecialchars_decode($row['item_title'], ENT_QUOTES);
			if ($friendly_urls == 1) {
			$item->link  = "$siteurl/item-$row[item_id]-".url_slug($row['item_title']);
			} else {
			$item->link  = "$siteurl/item.php?id=$row[item_id]";
			}
			$item->description = "<![CDATA[ $shortdes ]]>";
			$item->PubDate = date('D, d M Y H:i:s ',$row['item_unix_datetime']);
			$feed->addItem($item);
		}
		echo $feed->serve();
	}
		

?>