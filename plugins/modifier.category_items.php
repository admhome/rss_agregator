<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty get_category modifier plugin
 *
 * Type:     modifier<br>
 * Name:     get_category<br>
 * Purpose:  strip html tags from text
 * @link http://smarty.php.net/manual/en/language.modifier.strip.tags.php
 *          get_category (Smarty online manual)
 * @author   Monte Ohrt <monte at ohrt dot com>
 * @param string
 * @param boolean
 * @return string
 */
function smarty_modifier_category_items($id,$number) {
$sql = "SELECT * FROM feeditems WHERE item_category_id='$id' AND item_published='1' ORDER BY item_id DESC LIMIT $number";
$query = mysql_query($sql);
while ($row = mysql_fetch_array($query)) {
$items[] = $row;
}
return $items;
}
/* vim: set expandtab: */

?>
