<?php
class FeedItems
{
	function get_item($id)
	{
	$sql = "SELECT * FROM feeditems WHERE item_id='$id' LIMIT 1";
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