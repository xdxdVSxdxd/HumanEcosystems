<?php

require_once('db.php');

$res = array();


$q1 = "SELECT c.lat as lat, c.lng as lng , count(*) as c FROM content c WHERE research='" . $research_code . "' AND NOT c.lat=999 GROUP BY lat, lng";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		
		$r = array();
		$r["lat"] = $row1["lat"];
		$r["lng"] = $row1["lng"];
		$r["c"] = $row1["c"];
		$res[] = $r;
	}
}


echo( json_encode($res) );

?>