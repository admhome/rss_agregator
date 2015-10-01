<?php
class General
{
	function notification($type,$message)
	{
	return '<div class="notification '.$type.'">'.$message.'</div>';
	}
	
	function get_feed($id)
	{
	$sql = "SELECT * FROM feeds WHERE feed_id='$id'";
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	return $row['feed_title'];
	}
	
	function count_hits()
	{
	$sql = "SELECT SUM(item_hits) AS allhits, COUNT(item_hits) AS allitems, item_feed_id FROM feeditems WHERE item_published='1' GROUP BY item_feed_id ORDER BY allhits DESC";
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
	
	function count_all_hits()
	{
	$sql = "SELECT SUM(item_hits) AS allhits FROM feeditems WHERE item_published='1'";
	$query = mysql_query($sql);
	$row = mysql_fetch_array($query);
	return $row['allhits'];
	}
	
	function count_all_items()
	{
	$sql = "SELECT item_id FROM feeditems WHERE item_published='1'";
	$query = mysql_query($sql);
	$number = mysql_num_rows($query);
	return $number;
	}
	
	function percentage($item_hits) {
	$per = $item_hits*100;
	$percent = $per/$this->count_all_hits();
	return round($percent);
	}
	
	function resultcolor($percent)
	{
		if ($percent <= 25) {
			return 'bad';
		} elseif ($percent <= 50) {
			return 'normal';
		} elseif ($percent <= 75) {
			return 'good';
		} else {
			return 'best';
		}
	}
}
?>