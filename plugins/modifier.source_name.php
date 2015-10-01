<?php
function smarty_modifier_source_name($feed_id)
{
    $sql = mysql_query("SELECT * FROM feeds WHERE feed_id='$feed_id' LIMIT 1");
	$row = mysql_fetch_array($sql);
	return $row['feed_title'];
}

?>
