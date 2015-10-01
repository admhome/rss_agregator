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
function smarty_modifier_get_hour($date) {
if (date('A',$date) == 'PM') {
$ampm = 'م';
} else {
$ampm = 'ص';
}
return date('h:i',$date).' '.$ampm;
}
?>
