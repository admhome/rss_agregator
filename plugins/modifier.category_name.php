<?php
function smarty_modifier_category_name($category_id)
{
    $sql = mysql_query("SELECT * FROM categories WHERE category_id='$category_id' LIMIT 1");
	$row = mysql_fetch_array($sql);
	return $row['category_title'];
}

?>
