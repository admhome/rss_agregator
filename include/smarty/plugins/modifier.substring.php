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
function smarty_modifier_substring($sString, $dFirst = 0, $dLast = 0) {
    if($dLast == 0) {
       return mb_substr($sString, $dFirst,'UTF-8');
    } else {
	if (mb_strlen($sString,'UTF-8') > $dLast) {
	   return mb_substr($sString, $dFirst, $dLast,'UTF-8').' .. ';
	} else { 
       return mb_substr($sString, $dFirst, $dLast,'UTF-8');
	}
    }
}

?>