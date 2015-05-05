<?php

require_once('db.php');
require_once('prepareStatements.php');

$res = array();

$q1 = "SELECT lat,lng,count(*) as c FROM (SELECT lat,lng FROM `content` WHERE lat<>999 AND lat<>0 AND city='" . $citycode . "') a GROUP BY lat,lng";

$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		
       

		$r = array();

		//exemplo 1
		//$r["txt"] = $row1["txt"];

		$r["lat"] = $row1["lat"];
		$r["lng"] = $row1["lng"];
		$r["c"] = $row1["c"];
		
		$res[] = $r;
	}
}


echo( json_encode($res) );

?>