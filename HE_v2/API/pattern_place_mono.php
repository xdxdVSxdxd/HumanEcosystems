<?php

require_once('db.php');

$minL = 4;

$templates = array();
$templates[] = "[nick] will be within 1 mile of the following coordinates ([lat],[lon]) in the next [days] days";


$result = "";

$q1 = "SELECT id, nick FROM users WHERE research='" . $research_code . "' ORDER BY RAND() LIMIT 0,1";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {

		$iduser = $row1["id"];
		$nick = $row1["nick"];
		

		$q2 = "SELECT id,lat,lng FROM content WHERE id_user=" . $iduser . " ORDER BY t DESC LIMIT 0,20";
		$r2 = $dbh->query($q2);
		$lattot = 999;
		$lontot = 999;
		if($r2){
			foreach ( $r2 as $row2) {
				$lat = $row2["lat"];
				$lon = $row2["lng"];
				if(isset($lat) && $lat<>999 && isset($lon) && $lon<>999){
					if($lattot==999){
						$lattot = $lat;
					} else {
						$lattot = ($lattot+$lat)/2;
					}
					if($lontot==999){
						$lontot = $lon;
					} else {
						$lontot = ($lontot+$lon)/2;
					}
				}
			}
			$r2->closeCursor();
		}
		if($lattot<>999 && $lontot<>999){

			// select random template
			$result = $templates[rand(0, count($templates) - 1)];
			$result = str_replace("[nick]", $nick, $result);
			$result = str_replace("[lat]", $lattot, $result);
			$result = str_replace("[lon]", $lontot, $result);
			$result = str_replace("[days]", "" . (rand(0,5)) , $result);

		} else {
			// give alternative answer, because it was not possible to predict
			$result = "The future geographical position of " . $nick . " is unforeseeable, as of now.";
		}
	}
	$r1->closeCursor();	
}

echo($result);

?>