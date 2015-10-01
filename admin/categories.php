<?php
include('header.php');
include('classes/categories.class.php');
$categories = new Categories;
switch ($do) {
case 'add';
echo '<div class="block_head">
<h3>Add New Category</h3>
<a href="categories.php">Back To Categories</a>
</div>';
if (isset($_POST['submit'])) {
$category_title = $_POST['category_title'];
if (empty($category_title)) {
echo $general->notification('error','Please fill The Required Fields.');
} else {
$add = mysql_query("INSERT INTO categories (category_title) VALUES ('$category_title')");
if ($add) {
echo $general->notification('success','Category is Saved Successfully. <a href="categories.php?do=add">Add Another Category</a> OR <a href="categories.php">Back To Categories.</a>');
} else {
echo $general->notification('error','Error Happened.');
}
}
}
echo '<form method="POST" action="">
<table width="100%" cellpadding="5" cellspacing="0">
<tr>
<td class="label_td">Category Title <span style="color:red;">*</span></td>
<td class="input_td"><input type="text" name="category_title" size="40" /></td>
</tr>
<tr>
<td><span style="color:red; font:italic 12px tahoma;">* required field</span></td>
<td><input type="submit" name="submit" value="Save" class="inputbutton grey" /></td>
</tr>
</table>
</form>';
break;
case 'edit';
$id = abs(intval($_GET['id']));
echo '<div class="block_head">
<h3>Edit Category</h3>
<a href="categories.php">Back To Categories</a>
</div>';
if (isset($_POST['submit'])) {
$category_title = $_POST['category_title'];
if (empty($category_title)) {
echo $general->notification('error','Please fill The Required Fields.');
} else {
$add = mysql_query("UPDATE categories SET category_title='$category_title' WHERE category_id='$id'");
if ($add) {
echo $general->notification('success','Category is Saved Successfully. <a href="categories.php">Back To Categories.</a>');
} else {
echo $general->notification('error','Error Happened.');
}
}
}
$category = $categories->get_category($id);
echo '<form method="POST" action="">
<table width="100%" cellpadding="5" cellspacing="0">
<tr>
<td class="label_td">Category Title <span style="color:red;">*</span></td>
<td class="input_td"><input type="text" name="category_title" size="40" value="'.$category['category_title'].'" /></td>
</tr>
<tr>
<td><span style="color:red; font:italic 12px tahoma;">* required field</span></td>
<td><input type="submit" name="submit" value="Save" class="inputbutton grey" /></td>
</tr>
</table>
</form>';
break;
case 'delete';
$id = abs(intval($_GET['id']));
if (!empty($id)) {
$delete_items = mysql_query("DELETE FROM feeditems WHERE item_category_id='$id'");
$delete_feeds = mysql_query("DELETE FROM feeds WHERE feed_category_id='$id'");
$delete = mysql_query("DELETE FROM categories WHERE category_id='$id'");
if ($delete) {
echo "<meta http-equiv='refresh' content='0;URL=categories.php'>";
} else {
echo "<meta http-equiv='refresh' content='0;URL=categories.php'>";
}
}
break;
default;
echo '<div class="block_head">
<h3>Categories</h3>
<a href="?do=add">Add New Category</a>
</div>';
$all = $categories->get_all_categories();
if ($all == 0) {
echo $general->notification('warning','There is no Categories in Database until now. <a href="?do=add">Add New Category</a>');
} else {
echo '<div id="sort_category" class="sort">
		  <ul>';
		foreach ($all as $result) {
		echo '<li id="records_'.$result['category_id'].'" title="Drag To Re-Order">
				<span class="category_title"><b>'.$result['category_title'].'</b></span>
				<span class="category_tools"><a href="javascript:void();" onClick=ConfirmDelete("categories.php?do=delete&id=","'.$result['category_id'].'","Category") class="delete" title="Delete">Delete</a></span>
				<span class="category_tools"><a href="categories.php?do=edit&id='.$result['category_id'].'" class="edit" title="Edit">Edit</a></span>
			  </li>';
		}
		echo '</ul>
		</div>';
}
}
include('footer.php');
?>