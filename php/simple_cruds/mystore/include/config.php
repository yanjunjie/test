<?php
$host="localhost";
$user="root";
$password="";
$store="store";

function connect_db()
{
global $host, $user, $password, $store;
 $link=mysql_pconnect($host,$user, $password);
 if(!$link)
 {
 die('Not connected :'.mysql_error());
 }
 $db_selected=mysql_select_db($store,$link);
 if(!$db_selected)
 {
 die('Could not connect :'.mysql_error());
 }
return $link;
}
?>
