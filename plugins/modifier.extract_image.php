<?php
function smarty_modifier_extract_image($string) {
preg_match_all('/<img[^>]+>/i',$string, $result); 
if (!empty($result[0][0])) {
//preg_match( '@src="([^"]+)"@',$result[0][0],$match);
$image = $result[0][0];
} else {
$image = '<img src="./include/noimage.jpg" />';
}
return $image;
}

?>
