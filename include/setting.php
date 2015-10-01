<?php
// Get The Rows Of Setting Table From Database And Assign Them To Variables.
$setting_sql 	= "SELECT * FROM setting WHERE id='1'";
$setting_query  = mysql_query($setting_sql);
$setting_row 	= mysql_fetch_array($setting_query);
	$seo_title			   = $setting_row['seo_title'];
	$seo_keywords 		   = $setting_row['seo_keywords'];
	$seo_description 	   = $setting_row['seo_description'];
	$direct_links 		   = $setting_row['direct_links'];
	$site_template 		   = $setting_row['site_template'];
	$new_items_number	   = $setting_row['new_items_number'];
	$top_hits_items_number = $setting_row['top_hits_items_number'];
	$category_items_number = $setting_row['category_items_number'];
	$ad_slot_728		   = htmlspecialchars_decode($setting_row['ad_slot_728'],ENT_QUOTES);
	$ad_slot_300           = htmlspecialchars_decode($setting_row['ad_slot_300'],ENT_QUOTES);
	$friendly_urls 		   = abs(intval($setting_row['friendly_urls']));
	$pagination_style 	   = abs(intval($setting_row['pagination_style']));
	$display_rss    	   = abs(intval($setting_row['display_rss']));
	$display_category_rss  = abs(intval($setting_row['display_category_rss']));
	$rss_items_number      = abs(intval($setting_row['rss_items_number']));
	$facebook 	   		   = $setting_row['facebook'];
	$twitter 	           = $setting_row['twitter'];
	$google_plus    	   = $setting_row['google_plus'];
	$display_calendar      = $setting_row['display_calendar'];
	$google_analytics      = htmlspecialchars_decode($setting_row['google_analytics'],ENT_QUOTES);
	
?>