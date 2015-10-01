<?php
// function to prevent duplicate items
function check_item_url($url) {
	$check = mysql_num_rows(mysql_query("SELECT item_url FROM feeditems WHERE item_url='$url' LIMIT 1"));
	return $check;
}

// function to clear template's cache
function empty_templates_cache($str){
         if(is_file($str)){
             return @unlink($str);
         }
         elseif(is_dir($str)){
             $scan = glob(rtrim($str,'/').'/*');
             foreach($scan as $index=>$path){
			 if (str_replace($str,'',$path) === 'index.html') continue;
                 empty_templates_cache($path);
             }
         }
}

?>