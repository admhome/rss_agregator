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
function smarty_modifier_slug($title)
{
$slugged = url_slug(
	"$title", 
	array(
		'delimiter' => '-',
		'limit' => 40,
		'lowercase' => true
	)
);
return $slugged;
}

?>