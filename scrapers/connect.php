<?php
 $db_host = "localhost";
 $db_username = "rewiredstate";
 $db_pass = "pass";
 $db_name = "rewiredstate";
 
 mysql_connect("$db_host","$db_username","$db_pass") or die ("Could not connect to MySQL");
 mysql_select_db("$db_name") or die ("No Database");
?>