<?php

require_once('db.php');

$minL = 4;

$templates = array();
$templates[] = "These users [[nicks]] will find themselves within 1 mile of each other around the following coordinates ([lat],[lon]) in the next [days] days.";


$result = "";

$nicks = array();

		

		$q2 = "SELECT id,nick,lat,lng FROM content WHERE research='" . $research_code . "' ORDER BY t DESC LIMIT 0,80";
		$r2 = $dbh->query($q2);
		$lattot = 999;
		$lontot = 999;
		if($r2){
			foreach ( $r2 as $row2) {
				$lat = $row2["lat"];
				$lon = $row2["lng"];
				$nick = $row2["nick"];
				if(!in_array($nick, $nicks)){
					$nicks[] = $nick;
				}
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
		if($lattot<>999 && $lontot<>999 && count($nicks)>0 ){

			// select random template
			$result = $templates[rand(0, count($templates) - 1)];
			$result = str_replace("[nicks]", implode(", ", $nicks) , $result);
			$result = str_replace("[lat]", $lattot, $result);
			$result = str_replace("[lon]", $lontot, $result);
			$result = str_replace("[days]", "" . (rand(0,5)) , $result);

		} else {
			// give alternative answer, because it was not possible to predict
			$result = "The future geographical positions these users [" . implode(", ", $nicks) . "] are not correlated.";
		}
	

echo($result);

?>