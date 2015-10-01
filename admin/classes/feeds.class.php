<?php
class Feeds
{
	function get_all_feeds()
	{
	$sql = "SELECT * FROM feeds ORDER BY feed_id DESC";
	$query = mysql_query($sql);
	$check = mysql_num_rows($query);
	if ($check == 0) {
		return 0;
	} else {
		while ($row = mysql_fetch_assoc($query)) {
		$rows[] = $row;
		}
		return $rows;
	}
	}
	
	function get_feed($id)
	{
	$sql = "SELECT * FROM feeds WHERE feed_id='$id' LIMIT 1";
	$query = mysql_query($sql);
	$check = mysql_num_rows($query);
	if ($check == 0) {
		return 0;
	} else {
		$row = mysql_fetch_assoc($query);
		return $row;
	}
	}

}
?>