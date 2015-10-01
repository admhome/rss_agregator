<?php
function smarty_modifier_extract_domain($url) {
$link = parse_url($url);
$domain = $link['scheme'].'://'.$link['host'];
return $domain;
}
?>
