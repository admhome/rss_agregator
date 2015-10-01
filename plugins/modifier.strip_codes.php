<?php
function smarty_modifier_strip_codes($string) {
       return strip_tags($string,'<img><p><a><br /><br>');
}

?>