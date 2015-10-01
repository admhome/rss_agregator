<?php
// MySQL Database Connection.
$con = mysql_connect($database['db_host'], $database['db_user'], $database['db_pass'])or die("cannot connect");
mysql_select_db($database['db_name'])or die("cannot select DB");
@mysql_query("SET NAMES 'utf8' COLLATE 'utf-8' ");  
@mysql_query("SET character_set_server='utf8'; ");  
@mysql_query("SET character_set_client='utf8'; ");  
@mysql_query("SET character_set_results='utf8'; ");  
@mysql_query("SET character_set_connection='utf8'; ");  
@mysql_query("SET character_set_database='utf8'; ");  
@mysql_query("SET collation_connection='utf8_general_ci'; ");  
@mysql_query("SET collation_database='utf8_general_ci'; ");  
@mysql_query("SET collation_server='utf8_general_ci'; "); 
?>