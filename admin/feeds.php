<?php
include('header.php');
include('classes/categories.class.php');
include('classes/feeds.class.php');
include('classes/upload.class.php');
$feeds = new Feeds;
$categories = new Categories;
switch ($do) {
case 'add';
echo '<div class="block_head">
<h3>Add New Feed Source</h3>
<a href="feeds.php">Back To Feeds</a>
</div>';
if (isset($_POST['submit'])) {
$feed_url = $_POST['feed_url'];
if (strpos($feed_url,'feedburner.com') == false) {
$feed_url = $_POST['feed_url'];
} else {
if (strpos($feed_url,'?format=xml') == false) {
$feed_url = $_POST['feed_url'].'?format=xml';
} else {
$feed_url = $_POST['feed_url'];
}
}
$feed_title = $_POST['feed_title'];
$feed_category_id = $_POST['feed_category_id'];
if (isset($_POST['feed_items'])) {
$feed_items = abs(intval($_POST['feed_items']));
} else {
$feed_items = 5;
}
if (!empty($_FILES['file']['name'])) {
$up = new fileDir('../upload/feeds_logos/');
$logo_filename = $up->upload($_FILES['file']);
} else {
$logo_filename = '';
}
if (empty($feed_title)) {
echo $general->notification('error','Please fill The <b>Source Title</b> Field.');
} elseif (empty($feed_url)) {
echo $general->notification('error','Please fill The <b>Source Url</b> Field.');
} else {
$add = mysql_query("INSERT INTO feeds (feed_url,feed_title,feed_logo,feed_category_id,feed_items) VALUES ('$feed_url','$feed_title','$logo_filename','$feed_category_id','$feed_items')");
if ($add) {
echo $general->notification('success','Feed Source is Saved Successfully. <a href="feeds.php?do=add">Add Another Feed Source</a> OR <a href="feeds.php">Back To feeds.</a>');
} else {
echo $general->notification('error','Error Happened.');
}
}
}
echo '<form method="POST" action="" enctype="multipart/form-data">
<table width="100%" cellpadding="5" cellspacing="0">
<tr>
<td class="label_td" width="200">Source Title <span style="color:red;">*</span></td>
<td class="input_td"><input type="text" name="feed_title" size="40" /></td>
</tr>
<tr>
<td class="label_td">Feed Source Url <span style="color:red;">*</span></td>
<td class="input_td">
<input type="text" name="feed_url" id="feed_url" size="60" />
<a href="javascript:void();" class="validate_rss">Check Validation</a>
<span id="validate_result"></span>
</td>
</tr>
<tr>
<td class="label_td">Feed Source Logo <span style="color:red;">*</span></td>
<td class="input_td">
<input type="file" name="file" size="40" />
</td>
</tr>
<tr>
<td class="label_td">Source Category <span style="color:red;">*</span></td>
<td class="input_td"><select name="feed_category_id">';
$all = $categories->get_all_categories();
foreach ($all AS $category) {
echo '<option value="'.$category['category_id'].'">'.$category['category_title'].'</option>';
}
echo '</select></td>
</tr>
<tr>
<td class="label_td">Items Per Grab <span style="color:red;">*</span></td>
<td class="input_td">
<select name="feed_items">';
for ($i=1;$i<11;$i++) {
echo '<option value="'.$i.'">'.$i.'</option>';
}
echo '</select>
</td>
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
<h3>Edit Feed Source</h3>
<a href="feeds.php">Back To Feeds</a>
</div>';
if (isset($_POST['submit'])) {
$feed_url = $_POST['feed_url'];
if (strpos($feed_url,'feedburner.com') == false) {
$feed_url = $_POST['feed_url'];
} else {
if (strpos($feed_url,'?format=xml') == false) {
$feed_url = $_POST['feed_url'].'?format=xml';
} else {
$feed_url = $_POST['feed_url'];
}
}
$feed_category_id = abs(intval($_POST['feed_category_id']));
$feed_title = $_POST['feed_title'];
if (isset($_POST['feed_items'])) {
$feed_items = $_POST['feed_items'];
} else {
$feed_items = 5;
}
if (!empty($_FILES['file']['name'])) {
$up = new fileDir('../upload/feeds_logos/');
$logo_filename = $up->upload($_FILES['file']);
if (!empty($_POST['feed_logo'])) {
$up->delete("$_POST[feed_logo]");
}
} else {
if (!empty($_POST['feed_logo'])) {
$logo_filename = $_POST['feed_logo'];
} else {
$logo_filename = '';
}
}
if (empty($feed_title)) {
echo $general->notification('error','Please fill The <b>Source Title</b> Field.');
} elseif (empty($feed_url)) {
echo $general->notification('error','Please fill The <b>Source Url</b> Field.');
} else {
$add = mysql_query("UPDATE feeds SET feed_url='$feed_url',feed_title='$feed_title',feed_category_id='$feed_category_id',feed_logo='$logo_filename',feed_items='$feed_items' WHERE feed_id='$id'");
if ($add) {
mysql_query("UPDATE feeditems SET item_category_id='$feed_category_id' WHERE item_feed_id='$id'");
echo $general->notification('success','Feed Source is Saved Successfully. <a href="feeds.php">Back To feeds.</a>');
} else {
echo $general->notification('error','Error Happened.');
}
}
}
$feed = $feeds->get_feed($id);
echo '<form method="POST" action="" enctype="multipart/form-data">
<table width="100%" cellpadding="5" cellspacing="0">
<tr>
<td class="label_td" width="200">Source Title <span style="color:red;">*</span></td>
<td class="input_td"><input type="text" name="feed_title" size="40" value="'.$feed['feed_title'].'" /></td>
</tr>
<tr>
<td class="label_td">Feed Source Url <span style="color:red;">*</span></td>
<td class="input_td">
<input type="text" name="feed_url" id="feed_url" size="60" value="'.$feed['feed_url'].'" />
<a href="javascript:void();" class="validate_rss">Check Validation</a>
<span id="validate_result"></span>
</td>
</tr>
<tr>
<tr>
<td class="label_td">Feed Source Logo <span style="color:red;">*</span></td>
<td class="input_td">
<input type="file" name="file" size="40" />';
if (!empty($feed['feed_logo'])) {
echo '<a href="javascript:void();" id="'.$feed['feed_id'].'" class="delete_feed_logo" title="click to remove logo"><img src="../upload/feeds_logos/'.$feed['feed_logo'].'" width="50" style="float:right;" /></a>';
}
echo '</td>
</tr>
<td class="label_td">Source Category <span style="color:red;">*</span></td>
<td class="input_td"><select name="feed_category_id">';
$all = $categories->get_all_categories();
foreach ($all AS $category) {
echo '<option value="'.$category['category_id'].'"';
if ($feed['feed_category_id'] == $category['category_id']) {echo 'SELECTED';}
echo '>'.$category['category_title'].'</option>';
}
echo '</select></td>
</tr>
<tr>
<td class="label_td">Items Per Grab <span style="color:red;">*</span></td>
<td class="input_td">
<select name="feed_items">';
for ($i=1;$i<11;$i++) {
echo '<option value="'.$i.'"';
if ($feed['feed_items'] == $i) {echo 'SELECTED';}
echo '>'.$i.'</option>';
}
echo '</select>
</td>
</tr>
<tr>
<td><span style="color:red; font:italic 12px tahoma;">* required field</span></td>
<td>
<input type="hidden" name="feed_logo" value="'.$feed['feed_logo'].'" />
<input type="submit" name="submit" value="Save" class="inputbutton grey" /></td>
</tr>
</table>
</form>';
break;
case 'delete';
$id = abs(intval($_GET['id']));
if (!empty($id)) {
$delete_items = mysql_query("DELETE FROM feeditems WHERE item_feed_id='$id'");
$delete = mysql_query("DELETE FROM feeds WHERE feed_id='$id'");
if ($delete) {
echo "<meta http-equiv='refresh' content='0;URL=feeds.php'>";
} else {
echo "<meta http-equiv='refresh' content='0;URL=feeds.php'>";
}
}
break;
default;
echo '<div class="block_head">
<h3>Feed Sources</h3>
<a href="?do=add">Add New Feed Source</a>
</div>';
$all = $feeds->get_all_feeds();
if ($all == 0) {
echo $general->notification('warning','There is no Feed Sources in Database until now. <a href="?do=add">Add New Feed Source</a>');
} else {
echo '<table width="100%" cellpadding="5" cellspacing="0">
<tr>
<td class="feeds_th">Source title</td>
<td class="feeds_th">Last Update</td>
<td class="feeds_th"></td>
</tr>';
		foreach ($all as $result) {
		echo '<tr>
				<td class="feeds_td" width="250"><b>'.$result['feed_title'].'</b></td>
				<td class="feeds_td" width="120">'; if ($result['feed_last_update'] == 0) {echo 'not updated yet';} else {echo date('Y-n-j h:i',$result['feed_last_update']);} echo '</td>
				<td align="right" class="feeds_td">
				<a href="javascript:void();" class="grab_feed_items" id="'.$result['feed_id'].'" title="Grab Feed Items">Grab Feed Items</a> | 
				<a href="feeds.php?do=edit&id='.$result['feed_id'].'" class="edit" title="Edit">Edit</a> | 
				<a href="javascript:void();" onClick=ConfirmDelete("feeds.php?do=delete&id=","'.$result['feed_id'].'","Source") class="delete" title="Delete">Delete</a>
				</td>
			  </tr>';
		}
		echo '</table>';
}
}
include('footer.php');
?>