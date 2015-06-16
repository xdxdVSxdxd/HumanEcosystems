<?php

require_once('db.php');

$res = array();

$lat = 999;
$lng = 999;
$rad = 0.4;

if(isset($_REQUEST["lat"])){
	$lat = $_REQUEST["lat"];
}

if(isset($_REQUEST["lng"])){
	$lng = $_REQUEST["lng"];
}

if(isset($_REQUEST["rad"])){
	$rad = $_REQUEST["rad"];
}


if($lat!=999 && $lng!=999){
	$q1 = "SELECT distinct nick, txt, link FROM content WHERE research='" . $research_code . "' AND lat>=" . ($lat-$rad) . " AND lat<=" . ($lat+$rad) . " AND lng>=" . ($lng-$rad) . " AND lng<=" . ($lng+$rad) . " ORDER BY t DESC LIMIT 0,5";


	$r1 = $dbh->query($q1);
	if($r1){
		foreach ( $r1 as $row1) {
			
			$r = array();
			$r["nick"] = $row1["nick"];
			$r["txt"] = $row1["txt"];
			$r["link"] = $row1["link"];
			$res[] = $r;
		}
	}

}



echo( json_encode($res) );

?>