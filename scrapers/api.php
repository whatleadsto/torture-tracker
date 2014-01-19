<?php
	include('connect.php');

 	function delete_all_between($beginning, $end, $string) {
	  $beginningPos = strpos($string, $beginning);
	  $endPos = strpos($string, $end);
	  if (!$beginningPos || !$endPos) {
	    return $string;
	  }

	  $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

	  return str_replace($textToDelete, '', $string);
	}

	$home = 'United Kingdom';

	$homedb = mysql_query("SELECT * FROM memberships WHERE country='$home'");
	$homedb = mysql_fetch_assoc($homedb);

	$homememberships = explode('; ',$homedb['memberships']);
	for($i=0;$i<count($homememberships);$i++){
		$homememberships[$i] = delete_all_between(' (',')',$homememberships[$i]);
	}

	$results = mysql_query("SELECT * FROM memberships WHERE country!='$home'");
	while ($row = mysql_fetch_array($results)) {
		$memberships = explode('; ',$row['memberships']);
		$array[$row['country']]['country_name'] = $row['country'];
		$array[$row['country']]['short_name'] = '';
		$array[$row['country']]['shared_memberships'] = 1;
		$array[$row['country']]['treaties_signed'] = 1;
		$array[$row['country']]['investment_fdi'] = 1;
		$array[$row['country']]['score'] = 0;
	    for($i=0;$i<count($memberships);$i++){
			$memberships[$i] = delete_all_between(' (',')',$memberships[$i]);
			if(in_array($memberships[$i],$homememberships)){
				$array[$row['country']]['shared_memberships'] += 1;
			}
		}
	}

	$results = mysql_query("SELECT * FROM treaties GROUP BY location");
	while ($row = mysql_fetch_array($results)) {
		$location = ucfirst(strtolower($row['location']));
		if($array[$location]['country_name']!=''){
			$result = mysql_query("SELECT * FROM treaties WHERE location='$location'");
			$totaltreaties = mysql_num_rows($result);
			$array[$location]['treaties_signed'] += $totaltreaties;
		}
	}

	$results = mysql_query("SELECT * FROM investment");
	while ($row = mysql_fetch_array($results)) {
		$location = ucfirst(strtolower($row['location']));
		if($array[$location]['country_name']!=''){
			$array[$location]['investment_fdi'] += $row['vari'];
			$array[$location]['score'] = $array[$location]['shared_memberships'] * $array[$location]['treaties_signed'] * $array[$location]['investment_fdi'];
		}
	}
	
	$mapdata = file_get_contents('mapjson.json');
	$mapdata = json_decode($mapdata, true);

	$mapdata = $mapdata['paths'];
	$countrycodes = [];

	foreach ($mapdata as $key => $value) {
		$array[$mapdata[$key]['name']]['short_name'] = $key;
	}

	$array = array_values($array);

	$json = '[';
	foreach($array as $country) {
		if($country['country_name']!='' && $country['short_name']!='' && $country['shared_memberships']!=''){
			$json .= '{';
			$json .= '"long_name": "'.$country['country_name'].'",';
			$json .= '"short_name": "'.$country['short_name'].'",';
			$json .= '"shared_memberships": '.$country['shared_memberships'].',';
			$json .= '"treaties_signed": '.$country['treaties_signed'].',';
			$json .= '"investment_fdi": '.$country['investment_fdi'].',';
			$json .= '"score": '.$country['score'].'';
			$json .= '},';
		}
	}
	$json = rtrim($json, ",");
	$json .= ']';

	echo $json;
?>