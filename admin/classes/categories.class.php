<?php
class Categories
{
	function get_all_categories()
	{
	$sql = "SELECT category_id,category_title,category_order FROM categories ORDER BY category_order ASC";
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
	
	function get_category($id)
	{
	$sql = "SELECT category_id,category_title,category_order FROM categories WHERE category_id='$id' LIMIT 1";
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