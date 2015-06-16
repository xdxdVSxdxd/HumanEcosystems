<?php

require_once('db.php');

$res = array();


$q1 = "SELECT c.txt as txt, u.id as uid, u.nick as nick, u.image_url as iurl, lat as lat, lng as lng FROM content c, users u WHERE c.id_user=u.id AND c.research='" . $research_code . "' AND NOT lat=999 ORDER BY RAND() LIMIT 0,1";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		
		$r = array();
		$r["txt"] = $row1["txt"];
		$r["uid"] = $row1["uid"];
		$r["nick"] = $row1["nick"];
		$r["iurl"] = $row1["iurl"];
		$r["lat"] = $row1["lat"];
		$r["lng"] = $row1["lng"];
		$r["c"] = rand(1,2);
		$res[] = $r;
	}
}


echo( json_encode($res) );

?>