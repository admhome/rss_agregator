<?php
include('header.php');
	echo '<div class="block_head"><h3>Script Setting</h3></div>';
	if (isset($_POST['submit'])) {
		$seo_title = $_POST['seo_title'];
		$facebook = $_POST['facebook'];
		$twitter = $_POST['twitter'];
		$google_plus = $_POST['google_plus'];
		$friendly_urls = $_POST['friendly_urls'];
		$display_rss = $_POST['display_rss'];
		$display_category_rss = $_POST['display_category_rss'];
		$pagination_style = $_POST['pagination_style'];
		$seo_keywords = $_POST['seo_keywords'];
		$seo_description = $_POST['seo_description'];
		$site_template = $_POST['site_template'];
		$google_analytics = htmlspecialchars($_POST['google_analytics'],ENT_QUOTES);
		$display_calendar = abs(intval($_POST['display_calendar']));
		if (empty($_POST['direct_links']) OR !isset($_POST['direct_links'])) {
		$direct_links = 0;
		} else {
		$direct_links = 1;
		}
		$new_items_number = abs(intval($_POST['new_items_number']));
		if (!empty($new_items_number)) {
		} else {
		$new_items_number = 10;
		}
		$top_hits_items_number = abs(intval($_POST['top_hits_items_number']));
		if (!empty($top_hits_items_number)) {
		} else {
		$top_hits_items_number = 10;
		}
		$rss_items_number = abs(intval($_POST['rss_items_number']));
		if (!empty($rss_items_number)) {
		} else {
		$rss_items_number = 10;
		}
		$category_items_number = abs(intval($_POST['category_items_number']));
		if (!empty($category_items_number)) {
		} else {
		$category_items_number = 10;
		}
		$ad_slot_728 = htmlspecialchars($_POST['ad_slot_728'],ENT_QUOTES);
		$ad_slot_300 = htmlspecialchars($_POST['ad_slot_300'],ENT_QUOTES);
		$update = mysql_query("UPDATE setting SET
		seo_title='$seo_title',
		seo_keywords='$seo_keywords',
		seo_description='$seo_description',
		site_template='$site_template',
		direct_links='$direct_links',
		new_items_number='$new_items_number',
		top_hits_items_number='$top_hits_items_number',
		category_items_number='$category_items_number',
		ad_slot_728='$ad_slot_728',
		ad_slot_300='$ad_slot_300',
		friendly_urls='$friendly_urls',
		pagination_style='$pagination_style',
		display_rss='$display_rss',
		display_category_rss='$display_category_rss',
		display_calendar='$display_calendar',
		rss_items_number='$rss_items_number',
		facebook='$facebook',
		twitter='$twitter',
		google_plus='$google_plus',
		google_analytics='$google_analytics'
		WHERE id='1'");	
		if ($update) {
		echo empty_templates_cache('../cache/');
		echo $general->notification('success','Setting Is Saved Successfully.');
		} else {
		echo $general->notification('error','Error Happened.');
		}
	}
	$get = mysql_query("SELECT * FROM setting WHERE id='1'");
	$row = mysql_fetch_array($get);
		echo '<form method="POST" action="">
				<table width="100%" cellpadding="5" cellspacing="0">
						<tr>
							<td class="feeds_th" colspan="2">SEO Setting</td>
						</tr>
						<tr>
							<td class="label_td" width="200">Site Title</td>
							<td class="input_td"><input type="text" name="seo_title" size="40" value="'.$row['seo_title'].'" /></td>
						</tr>
						<tr>
							<td class="label_td" width="200">Site Keywords</td>
							<td class="input_td"><textarea rows="2" style="width:99%;" name="seo_keywords">'.$row['seo_keywords'].'</textarea><br /><span>separated by comma ,</span></td>
						</tr>
						<tr>
							<td class="label_td" width="200">Site Description</td>
							<td class="input_td"><textarea rows="2" style="width:99%;" name="seo_description">'.$row['seo_description'].'</textarea></td>
						</tr>
						<tr>
							<td class="feeds_th" colspan="2">Display Setting</td>
						</tr>
						<tr>
							<td class="label_td" width="200">Friendly URL\'s</td>
							<td class="input_td"><input type="checkbox" name="friendly_urls" value="1"'; if ($row['friendly_urls'] == 1) {echo 'CHECKED';} echo '/><span style="padding-left:10px;">if you check this. the links will be displayed in friendly mode using htaccess.</span></td>
						</tr>
						<tr>
							<td class="label_td" width="200">Direct Links</td>
							<td class="input_td"><input type="checkbox" name="direct_links" value="1"'; if ($row['direct_links'] == 1) {echo 'CHECKED';} echo '/><span style="padding-left:10px;">if you check this. the item links will point to source directly.</span></td>
						</tr>
						<tr>
							<td class="label_td" width="200">Pagination Style</td>
							<td class="input_td">
							<input type="radio" name="pagination_style" value="1"'; if ($row['pagination_style'] == 1) {echo 'CHECKED';} echo '/><span style="padding-left:10px;">PHP pagination</span><br />
							<input type="radio" name="pagination_style" value="2"'; if ($row['pagination_style'] == 2) {echo 'CHECKED';} echo '/><span style="padding-left:10px;">load more (twitter & facebook like pagination)</span><br />
							<input type="radio" name="pagination_style" value="3"'; if ($row['pagination_style'] == 3) {echo 'CHECKED';} echo '/><span style="padding-left:10px;">Infinite Scroll pagination</span>
							</td>
						</tr>
						<tr>
							<td class="label_td" width="200">Site Theme</td>
							<td class="input_td"><select name="site_template">';
							$path = '../templates/';
							$results = scandir($path);
							foreach ($results as $result) {
								if ($result === '.' or $result === '..') continue;
								if (is_dir($path.$result)) {
								echo '<option value="'.$result.'"';
								if ($result == $row['site_template']) {echo 'SELECTED';}
								echo '>'.$result.'</option>';
								}
							}
							echo '</select></td>
						</tr>
						<tr>
							<td class="label_td" width="200">New Items Number</td>
							<td class="input_td"><input type="text" name="new_items_number" size="5" value="'.$row['new_items_number'].'" /><span style="padding-left:10px;">if you leave it blank. the default value is <b>10</b> items</span></td>
						</tr>
						<tr>
							<td class="label_td" width="200">Top Hits Items Number</td>
							<td class="input_td"><input type="text" name="top_hits_items_number" size="5" value="'.$row['top_hits_items_number'].'" /><span style="padding-left:10px;">if you leave it blank. the default value is <b>10</b> items</span></td>
						</tr>
						<tr>
							<td class="label_td" width="200">Category Items Number</td>
							<td class="input_td"><input type="text" name="category_items_number" size="5" value="'.$row['category_items_number'].'" /><span style="padding-left:10px;">if you leave it blank. the default value is <b>10</b> items</span></td>
						</tr>
						<tr>
							<td class="label_td" width="200">Display Site RSS</td>
							<td class="input_td"><input type="checkbox" name="display_rss" value="1"'; if ($row['display_rss'] == 1) {echo 'CHECKED';} echo '/><span style="padding-left:10px;">if you check this. the rss link icon will be appeared.</span></td>
						</tr>
						<tr>
							<td class="label_td" width="200">Display Category RSS</td>
							<td class="input_td"><input type="checkbox" name="display_category_rss" value="1"'; if ($row['display_category_rss'] == 1) {echo 'CHECKED';} echo '/><span style="padding-left:10px;">if you check this. the rss link icon will be appeared in each category.</span></td>
						</tr>
						<tr>
							<td class="label_td" width="200">RSS Items Number</td>
							<td class="input_td"><input type="text" name="rss_items_number" size="5" value="'.$row['rss_items_number'].'" /><span style="padding-left:10px;">if you leave it blank. the default value is <b>10</b> items</span></td>
						</tr>
						<tr>
							<td class="label_td" width="200">Display Calendar</td>
							<td class="input_td"><input type="checkbox" name="display_calendar" value="1"'; if ($row['display_calendar'] == 1) {echo 'CHECKED';} echo '/><span style="padding-left:10px;">if you check this. the calendar widget will appear in the sidebar.</span></td>
						</tr>
						<tr>
							<td class="feeds_th" colspan="2">Social Setting</td>
						</tr>
						<tr>
							<td class="label_td" width="200">Facebook</td>
							<td class="input_td"><input type="text" name="facebook" size="70" value="'.$row['facebook'].'" /></td>
						</tr>
						<tr>
							<td class="label_td" width="200">Twitter</td>
							<td class="input_td"><input type="text" name="twitter" size="70" value="'.$row['twitter'].'" /></td>
						</tr>
						<tr>
							<td class="label_td" width="200">Google+</td>
							<td class="input_td"><input type="text" name="google_plus" size="70" value="'.$row['google_plus'].'" /></td>
						</tr>
						<tr>
							<td class="feeds_th" colspan="2">Ads Setting</td>
						</tr>
						<tr>
							<td class="label_td" width="200">Ad Slot 728/90 px</td>
							<td class="input_td"><textarea rows="2" style="width:99%;" name="ad_slot_728">'.$row['ad_slot_728'].'</textarea><br /><span>You can add html code or adsense code</span></td>
						</tr>
						<tr>
							<td class="label_td" width="200">Ad Slot 300/250 px</td>
							<td class="input_td"><textarea rows="2" style="width:99%;" name="ad_slot_300">'.$row['ad_slot_300'].'</textarea><br /><span>You can add html code or adsense code</span></td>
						</tr>
						<tr>
							<td class="feeds_th" colspan="2">Google Analytics</td>
						</tr>
						<tr>
							<td class="label_td" width="200">Google Analytics Code</td>
							<td class="input_td"><textarea rows="2" style="width:99%;" name="google_analytics">'.$row['google_analytics'].'</textarea></td>
						</tr>
						<tr>
							<td colspan="2"><input type="submit" name="submit" value="Save Setting" class="inputbutton grey" /></td>
						</tr>
					</table>
				</form>';
include('footer.php');
?>