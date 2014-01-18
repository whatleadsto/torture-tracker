<?php
	include('connect.php');
	$mapdata = file_get_contents('mapjson.json');
	$mapdata = json_decode($mapdata, true);

	$mapdata = $mapdata['paths'];
	$countrycodes = [];

	foreach ($mapdata as $key => $value) {

	 $countrycodes[$mapdata[$key]['name']] = $key;
	}

	print_r($countrycodes);
?>