<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 * @author Manuel Polacek / Hitflip
 */


/**
 * Smarty regex_replace modifier plugin
 *
 * Type:     modifier<br>
 * Name:     substring
 * Purpose:  substring like in php
 * @param string
 * @return string
 */
function smarty_modifier_social_share($url,$title)
{
    $html = "<a href='https://www.facebook.com/share.php?u=$url' target='_BLANK' style='margin-left:5px;'><img src='./common/images/facebook.png' /></a>";
    $html .= "<a href='http://twitter.com/?status=$title $url' target='_BLANK'><img src='./common/images/twitter.png' /></a>";
return $html;
}

?>