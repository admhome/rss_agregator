<?php
include('header.php');
	echo '<div class="block_head"><h3>Top Feed Sources</h3>
	<a href="feeditems.php">Total '.$general->count_all_items().' items</a>
	</div>';
		$feeds = $general->count_hits();
			if ($feeds != 0) {
				echo '<table width="100%" cellpadding="5" cellspacing="0">
						<tr>
							<td class="feeds_th">Source title</td>
							<td class="feeds_th">All Items</td>
							<td class="feeds_th">All Hits</td>
							<td class="feeds_th" colspan="2" width="250">Hits Percent</td>
						</tr>';
						foreach ($feeds AS $feed) {
						echo '<tr>
							<td class="feeds_td"><b>'.$general->get_feed($feed['item_feed_id']).'</b></td>
							<td class="feeds_td" width="60">'.$feed['allitems'].'</td>
							<td class="feeds_td" width="60">'.$feed['allhits'].'</td>
							<td class="feeds_td" width="50">'.$general->percentage($feed['allhits']).'%</td>
							<td class="feeds_td" width="200"><div class="all_percent"><span class="part_percent '.$general->resultcolor($general->percentage($feed['allhits'])).'" style="width:'.$general->percentage($feed['allhits']).'%;"></span></div></td>
						</tr>';
						}
				echo '</table>';
			}
include('footer.php');
?>