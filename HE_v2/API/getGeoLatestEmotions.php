<?php

require_once('db.php');

$res = array();


$q1 = "SELECT c.lat as lat, c.lng as lng, e.label as label FROM content c, emotions_content ec, emotions e WHERE research='" . $research_code . "' AND NOT c.lat=999 AND ec.id_content=c.id AND e.id=ec.id_emotion ORDER BY c.t DESC LIMIT 0,2000 ";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		
		$r = array();
		$r["lat"] = $row1["lat"];
		$r["lng"] = $row1["lng"];
		$r["label"] = $row1["label"];
		$res[] = $r;
	}
}


echo( json_encode($res) );

?>