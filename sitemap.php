<?php
header("Content-Type: application/xml; charset=utf-8");
error_reporting(E_ERROR);
include('include/config.php');
include('include/database.php');
include('include/functions.php');
include('include/setting.php');
$siteurls = str_replace('/sitemap.php','',currentURL());
$siteurl = str_replace('/sitemap.xml','',$siteurls);
$today = date('Y-m-d');	
$feed_output .= '<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/xsl" href="include/sitemap.xsl"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
	xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
	xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
			    http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
                            
$feed_output .= "<url>
                <loc>$siteurl</loc>
		<lastmod>$today</lastmod>
		<changefreq>daily</changefreq>
		<priority>1</priority>
                </url>";
			
$categories_query = mysql_query("SELECT * FROM categories ORDER BY category_order ASC");
	while($c_row = mysql_fetch_array($categories_query))
	{
 
    $feed_output .= "<url>";
		if ($friendly_urls == 1) {
		$feed_output .= "<loc>$siteurl/category-$c_row[category_id]-1-".url_slug($c_row['category_title'])."</loc>";
		} else {
		$feed_output .= "<loc>$siteurl/category.php?id=$c_row[category_id]</loc>";
		}
		$feed_output .= "<lastmod>$today</lastmod>
		<changefreq>daily</changefreq>
		<priority>0.8</priority>
                </url>";
    
	}

$feeds_query = mysql_query("SELECT * FROM feeds ORDER BY feed_id ASC");
	while($f_row = mysql_fetch_array($feeds_query))
	{
 
    $feed_output .= "<url>";
		if ($friendly_urls == 1) {
		$feed_output .= "<loc>$siteurl/feed-$f_row[feed_id]-1-".url_slug($f_row['feed_title'])."</loc>";
		} else {
		$feed_output .= "<loc>$siteurl/feed.php?id=$f_row[feed_id]</loc>";
		}
		$feed_output .= "<lastmod>$today</lastmod>
		<changefreq>daily</changefreq>
		<priority>0.8</priority>
                </url>";
    
	}
	
$items_query = mysql_query("SELECT * FROM feeditems ORDER BY item_id DESC LIMIT 10000");
	while($row = mysql_fetch_array($items_query))
	{
 
    $feed_output .= "<url>";
		if ($friendly_urls == 1) {
		$feed_output .= "<loc>$siteurl/item-$row[item_id]-".url_slug($row['item_title'])."</loc>";
		} else {
		$feed_output .= "<loc>$siteurl/item.php?id=$row[item_id]</loc>";
		}
		$feed_output .= "<lastmod>$today</lastmod>
		<changefreq>monthly</changefreq>
		<priority>0.5</priority>
                </url>";
    
	}

$feed_output .= "</urlset>";
echo $feed_output;

?>