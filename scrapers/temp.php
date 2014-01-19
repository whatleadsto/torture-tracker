<?php
	include('connect.php');

	mysql_query("UPDATE treaties SET location='United States' WHERE 'title' LIKE '%United States%'");
?>