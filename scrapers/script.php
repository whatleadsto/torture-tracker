<?php
 $db_host = "localhost";
 $db_username = "rewiredstate";
 $db_pass = "pass";
 $db_name = "rewiredstate";
 
 mysql_connect("$db_host","$db_username","$db_pass") or die ("Could not connect to MySQL");
 mysql_select_db("$db_name") or die ("No Database");

	function get_string_between($string, $start, $end){
	    $string = " ".$string;
	    $ini = strpos($string,$start);
	    if ($ini == 0) return "";
	    $ini += strlen($start);
	    $len = strpos($string,$end,$ini) - $ini;
	    return substr($string,$ini,$len);
	}
	redohere:
	$request = file_get_contents('http://treaties.fco.gov.uk/treaties/treatyrecord.htm?tid='.$_GET['tid']);

	if($request==' '){
		$request = file_get_contents('http://treaties.fco.gov.uk/treaties/treatyrecord.htm?tid='.$_GET['tid']);
		if($request==' '){
			echo 'ERROR SCANNING '.$_GET['tid'];
			exit;
		}
	}

	$string = get_string_between($request, '<div id="content" class="results">','<div class="contentFooter">');
	$treatytitle = get_string_between($string, '<strong>','</strong>');
	$treatytype = get_string_between($string, '<strong>Treaty Type:</strong>&nbsp; ','<br><br>');
	$treatylocation = get_string_between($string, '<strong>Place Of Signature:</strong>&nbsp; ','<br><br>');
	$treatydate = get_string_between($string, '<strong>Date Of Signature:</strong>&nbsp; ','<br><br>');

	if($treatytitle=='<font color="red">Invalid Treaty Id supplied, please run another search</font>'){
		goto redohere;
	}
	$tid = $_GET['tid'];
	mysql_query("INSERT INTO treaties (tid,title,type,location,cdate) VALUES('$tid','$treatytitle','$treatytype','$treatylocation','$treatydate') ");
	echo 'Scraped treaty '.$_GET['tid'].' successfully';
?>