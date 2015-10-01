<?php
include('header.php');
include('classes/feeditems.class.php');
$feeditems = new FeedItems;
switch ($do) {
case 'delete';
$id = abs(intval($_GET['id']));
if (!empty($id)) {
$delete = mysql_query("UPDATE feeditems SET item_published='0' WHERE item_id='$id'");
if ($delete) {
echo "<meta http-equiv='refresh' content='0;URL=feeditems.php'>";
} else {
echo "<meta http-equiv='refresh' content='0;URL=feeditems.php'>";
}
}
break;

case 'deleted_items';
if (isset($_POST['restore']) AND isset($_POST['id'])) {
	$ids = $_POST['id'];
	$count= count($ids);
	for($i=0;$i<$count;$i++){
	$del_id = $ids[$i];
	$sql = "UPDATE feeditems SET item_published='1' WHERE item_id='$del_id'";
	$res = mysql_query($sql);
	if ($res) {
	$message = $general->notification('success','The Selected Items Was Restored Successfully.');
	} else {
	$message = $general->notification('error','Error Happened');
	}
	}
}
echo '<div class="block_head">
<h3>Deleted Items</h3>
<a href="feeditems.php">Back To Feed Items</a>
</div>';
$items_number = mysql_num_rows(mysql_query("SELECT item_id FROM feeditems WHERE item_published='0'"));
if ($items_number == 0) {
echo $general->notification('warning','There is no Deleted Feed Items in Database until now.');
} else {
$page = 1;
$size = 10;
if (isset($_GET['page'])){ $page = abs(intval($_GET['page'])); }
$pagination = new Pagination();
$pagination->setLink("?do=deleted_items&page=%s");
$pagination->setPage($page);
$pagination->setSize($size);
$pagination->setTotalRecords($items_number);
$sql = "SELECT 
feeditems.item_id,
feeditems.item_title,
feeditems.item_feed_id,
feeditems.item_category_id,
feeditems.item_published,
feeditems.item_url,
feeditems.item_datetime,
feeditems.item_pinned,
feeds.feed_id,
feeds.feed_title,
feeds.feed_url
FROM feeditems JOIN feeds
ON feeditems.item_feed_id=feeds.feed_id
WHERE feeditems.item_published='0'
ORDER BY feeditems.item_pinned DESC, feeditems.item_id DESC ". $pagination->getLimitSql();
$query = mysql_query($sql);
echo '<form method="POST" action="">';
if (isset($message)) {echo $message;}
echo '<table width="100%" cellpadding="5" cellspacing="0">
<tr>
<td class="feeds_th"><input type="checkbox" class="parentCheckBox" /></td>
<td class="feeds_th">Item Title</td>
</tr>';
		while ($result = mysql_fetch_assoc($query)) {
		echo '<tr>
				<td class="feeds_td" width="10" valign="top"><input type="checkbox" name="id[]" class="childCheckBox" value="'.$result['item_id'].'" /></td>
				<td class="feeds_td" valign="top">
				<a href="'.$result['item_url'].'" target="_BLANK" style="display:block; color:#444; margin-bottom:4px;"><b>'.$result['item_title'].'</b></a>
				<span style="color:#999;">Source : <a href="'.$result['feed_url'].'" target="_BLANK" style="color:#777;">'.$result['feed_title'].'</a></span>
				</td>
			  </tr>';
		}
		echo '</table>';
		echo '<div class="feeds_tools">
		<div class="delete_form"><input type="submit" name="restore" value="Restore Selected Items" class="inputbutton grey" style="font-weight:bold;" /></div>
		'.$pagination->create_links().'
		</div>
		</form>';
		
}
break;
default;
if (isset($_POST['delete']) AND isset($_POST['id'])) {
	$ids = $_POST['id'];
	$count= count($ids);
	for($i=0;$i<$count;$i++){
	$del_id = $ids[$i];
	$sql = "UPDATE feeditems SET item_published='0' WHERE item_id='$del_id'";
	$res = mysql_query($sql);
	if ($res) {
	$message = $general->notification('success','The Selected Items Was Deleted Successfully.');
	} else {
	$message = $general->notification('error','Error Happened');
	}
	}
}
echo '<div class="block_head">
<h3>Feed Items</h3>
<a href="?do=deleted_items">Deleted Items</a>
</div>';
$items_number = mysql_num_rows(mysql_query("SELECT item_id FROM feeditems WHERE item_published='1'"));
if ($items_number == 0) {
echo $general->notification('warning','There is no Feed Items in Database until now.');
} else {
$page = 1;
$size = 10;
if (isset($_GET['page'])){ $page = abs(intval($_GET['page'])); }
$pagination = new Pagination();
$pagination->setLink("?page=%s");
$pagination->setPage($page);
$pagination->setSize($size);
$pagination->setTotalRecords($items_number);
$sql = "SELECT 
feeditems.item_id,
feeditems.item_title,
feeditems.item_feed_id,
feeditems.item_category_id,
feeditems.item_published,
feeditems.item_url,
feeditems.item_datetime,
feeditems.item_pinned,
feeds.feed_id,
feeds.feed_title,
feeds.feed_url
FROM feeditems JOIN feeds
ON feeditems.item_feed_id=feeds.feed_id
WHERE feeditems.item_published='1'
ORDER BY feeditems.item_pinned DESC, feeditems.item_id DESC ". $pagination->getLimitSql();
$query = mysql_query($sql);
echo '<form method="POST" action="">';
if (isset($message)) {echo $message;}
echo '<table width="100%" cellpadding="5" cellspacing="0">
<tr>
<td class="feeds_th"><input type="checkbox" class="parentCheckBox" /></td>
<td class="feeds_th">Item Title</td>
<td class="feeds_th" align="center">Actions</td>
</tr>';
		while ($result = mysql_fetch_assoc($query)) {
		echo '<tr>
				<td class="feeds_td" width="10" valign="top"><input type="checkbox" name="id[]" class="childCheckBox" value="'.$result['item_id'].'" /></td>
				<td class="feeds_td" valign="top">
				<a href="'.$result['item_url'].'" target="_BLANK" style="display:block; color:#444; margin-bottom:4px;"><b>'.$result['item_title'].'</b></a>
				<span style="color:#999;">Published On : '.$result['item_datetime'].' | Source : <a href="'.$result['feed_url'].'" target="_BLANK" style="color:#777;">'.$result['feed_title'].'</a></span>
				</td>
				<td align="right" class="feeds_td" width="110">';
				if ($result['item_pinned'] == 0) {
				echo '<a href="javascript:void();" class="pin_tools" id="'.$result['item_id'].'" title="Pin Item" style="color:#555;">Pin Item</a> | ';
				} else {
				echo '<a href="javascript:void();" class="pin_tools" id="'.$result['item_id'].'" title="UnPin Item" style="color:#555;">UnPin Item</a> | ';
				}
				echo '<a href="javascript:void();" onClick=ConfirmDelete("feeditems.php?do=delete&id=","'.$result['item_id'].'","Item") class="delete" title="Delete">Delete</a>
				</td>
			  </tr>';
		}
		echo '</table>';
		echo '<div class="feeds_tools">
		<div class="delete_form"><input type="submit" name="delete" value="Delete Selected Items" class="inputbutton grey" style="font-weight:bold;" /></div>
		'.$pagination->create_links().'
		</div>
		</form>';
		
}
}
include('footer.php');
?>