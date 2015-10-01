<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<!-- If you delete this meta tag, Half Life 3 will never be released. -->
<meta name="viewport" content="width=device-width" />

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Install Or Upgrade</title>
	
<style type="text/css">
/* ------------------------------------- 
		GLOBAL 
------------------------------------- */
* { 
	margin:0;
	padding:0;
}


body {
	-webkit-font-smoothing:antialiased; 
	-webkit-text-size-adjust:none; 
	width: 100%!important; 
	height: 100%;
}


/* ------------------------------------- 
		ELEMENTS 
------------------------------------- */
a { color: #2BA6CB;}

.btn {
	text-decoration:none;
	color: #FFF;
	background-color: #666;
	padding:10px 16px;
	font-weight:bold;
	margin-right:10px;
	text-align:center;
	cursor:pointer;
	display: inline-block;
}
p {
padding:10px;
color:#777;
}
h3 {
padding:10px;
color:#444;
}
</style>

</head>
 
<body bgcolor="#FFFFFF">
<?php
error_reporting(E_ERROR);
include('config.php');

$con = mysql_connect($database['db_host'], $database['db_user'], $database['db_pass'])or die("cannot connect");
$db = mysql_select_db($database['db_name']) or die("cannot select DB");
switch ($_GET['do']) {
case 'install';
$admin_sql = mysql_query("CREATE TABLE IF NOT EXISTS `admin` (
  `id` varchar(1) NOT NULL,
  `admin` varchar(40) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

$admin_data_sql = mysql_query("INSERT INTO `admin` (`id`, `admin`, `password`) VALUES
('1', 'admin', '6c5ac7b4d3bd3311f033f971196cfa75');");

$categories_sql = mysql_query("CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int(12) NOT NULL AUTO_INCREMENT,
  `category_title` varchar(255) NOT NULL,
  `category_order` int(12) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

$feeditems_sql = mysql_query("CREATE TABLE IF NOT EXISTS `feeditems` (
  `item_id` int(12) NOT NULL AUTO_INCREMENT,
  `item_title` varchar(255) NOT NULL,
  `item_url` varchar(255) NOT NULL,
  `item_category_id` int(12) NOT NULL,
  `item_feed_id` int(12) NOT NULL,
  `item_details` text NOT NULL,
  `item_datetime` varchar(100) NOT NULL,
  `item_unix_datetime` int(12) NOT NULL,
  `item_hits` int(12) NOT NULL,
  `item_published` int(1) NOT NULL,
  `item_pinned` int(1) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");


$feeds_sql = mysql_query("CREATE TABLE IF NOT EXISTS `feeds` (
  `feed_id` int(12) NOT NULL AUTO_INCREMENT,
  `feed_url` varchar(255) NOT NULL,
  `feed_title` varchar(100) NOT NULL,
  `feed_logo` varchar(255) NOT NULL,
  `feed_category_id` int(12) NOT NULL,
  `feed_last_update` int(12) NOT NULL,
  `feed_items` int(3) NOT NULL,
  PRIMARY KEY (`feed_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;");

$setting_sql = mysql_query("CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(1) NOT NULL,
  `seo_title` varchar(255) NOT NULL,
  `seo_keywords` text NOT NULL,
  `seo_description` text NOT NULL,
  `site_template` varchar(100) NOT NULL,
  `direct_links` int(1) NOT NULL,
  `new_items_number` int(2) NOT NULL,
  `top_hits_items_number` int(2) NOT NULL,
  `category_items_number` int(2) NOT NULL,
  `ad_slot_728` text NOT NULL,
  `ad_slot_300` text NOT NULL,
  `friendly_urls` int(1) NOT NULL,
  `pagination_style` int(1) NOT NULL,
  `display_rss` int(1) NOT NULL,
  `display_category_rss` int(1) NOT NULL,
  `rss_items_number` int(4) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `google_plus` varchar(255) NOT NULL,
  `display_calendar` int(1) NOT NULL,
  `google_analytics` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

$setting_data_sql = mysql_query("INSERT INTO `setting` (`id`, `seo_title`, `seo_keywords`, `seo_description`, `site_template`, `direct_links`, `new_items_number`, `top_hits_items_number`, `category_items_number`, `ad_slot_728`, `ad_slot_300`, `friendly_urls`, `pagination_style`, `display_rss`, `display_category_rss`, `rss_items_number`, `facebook`, `twitter`, `google_plus`, `display_calendar`, `google_analytics`) VALUES
(1, 'Rss Aggregator Script', 'rss,feeds,feed,atom,aggregator', 'Rss Aggregator is a Script That Grab, Organize And Publish The Stories From Multi Sources. ', 'v2', 0, 15, 15, 15, '&lt;img src=&quot;upload/top.jpg&quot; /&gt;', '&lt;img src=&quot;upload/left.jpg&quot; /&gt;', 1, 1, 1, 1, 10, 'http://www.facebook.com/webbagusblog', 'http://twitter.com/roudyhermez', '', 1, '');");

if ($setting_data_sql) {
echo '<div style="width:500px; margin:100px auto; background:#eee;">
<h3 style="text-align:center;">RSS Aggregator Script Instal & Upgrade</h3>
<p>the script database is installed please delete the install.php file or change its name</p>
<div style="text-align:center;">
<a href="../" class="btn">GO To Script Home Page</a>
</div>
</div>';
}
break;
case 'upgrade';
$setting_new_fields_sql = mysql_query("ALTER TABLE `setting` 
ADD `friendly_urls` INT(1) NOT NULL AFTER `ad_slot_300`, 
ADD `pagination_style` INT(1) NOT NULL AFTER `friendly_urls`, 
ADD `display_rss` INT(1) NOT NULL AFTER `pagination_style`, 
ADD `display_category_rss` INT(1) NOT NULL AFTER `display_rss`, 
ADD `rss_items_number` INT(4) NOT NULL AFTER `display_category_rss`, 
ADD `facebook` VARCHAR(255) NOT NULL AFTER `rss_items_number`, 
ADD `twitter` VARCHAR(255) NOT NULL AFTER `facebook`, 
ADD `google_plus` VARCHAR(255) NOT NULL AFTER `twitter`, 
ADD `display_calendar` INT(1) NOT NULL AFTER `google_plus`, 
ADD `google_analytics` TEXT NOT NULL AFTER `display_calendar`");

$setting_data_sql = mysql_query("UPDATE setting SET 
display_rss = '1', 
display_category_rss = '1', 
site_template = 'v2',
rss_items_number = '15', 
facebook = 'http://www.facebook.com/webbagusblog', 
twitter = 'http://twitter.com/roudyhermez', 
display_calendar = '1'
WHERE id = '1';");

if ($setting_data_sql) {
echo '<div style="width:500px; margin:100px auto; background:#eee; height:300px;">
<h3 style="text-align:center;">RSS Aggregator Script Instal & Upgrade</h3>
<p>the script database is upgraded please delete the install.php file or change its name</p>
<div style="text-align:center;">
<a href="../" class="btn">GO To Script Home Page</a>
</div>
</div>';
}
break;
default;
echo '<div style="width:500px; margin:100px auto; background:#eee; padding:20px;">
<h3 style="text-align:center;">RSS Aggregator Script Instal & Upgrade</h3>
<p>Make Sure that you insert the right values in config.php file before clicking any button.</p>
<div style="text-align:center;">
<a href="?do=install" class="btn">Fresh Install</a>
<a href="?do=upgrade" class="btn">Upgrade From v1.4 to v2.0</a>
</div>
</div>';
}
?>
</body>
</html>