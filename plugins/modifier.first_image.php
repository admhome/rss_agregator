<?php
function smarty_modifier_first_image($texthtml,$feed_id)
{
    preg_match('/<img.+src=[\'"](?P<src>.+)[\'"].*>/i', urldecode($texthtml), $image);
	if (isset($image['src']) AND strpos($image['src'],'feedburner.com') == false) {
	$is = explode(' ',$image['src']);
	return str_replace('"','',$is[0]);
	} else {
	$feed_sql = mysql_query("SELECT feed_logo FROM feeds WHERE feed_id='$feed_id'");
	$feed_row = mysql_fetch_array($feed_sql);
	if (!empty($feed_row['feed_logo'])) {
	return 'upload/feeds_logos/'.$feed_row['feed_logo'];
	} else {
	return false;
	}
	}
   
}

?>
