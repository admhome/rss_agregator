<?php
function smarty_modifier_items_number($feed_id) {
	$sql = mysql_query("SELECT COUNT(*) AS total FROM feeditems WHERE item_feed_id='$feed_id' AND item_published='1' GROUP BY item_feed_id");
	$row = mysql_fetch_array($sql);
	if ($row == 0) {
	$total = 0;
	} else {
	$total = $row['total'];
	}
	return $total;
}
?>
