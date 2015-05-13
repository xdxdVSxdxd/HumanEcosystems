<?php

require_once('db.php');

$res = array();

$q1 = "SELECT * FROM relations WHERE research='" . $research_code . "' ORDER BY id DESC LIMIT 0,1000";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		
		$r = array();
		$r["nick1"] = $row1["nick1"];
		$r["nick2"] = $row1["nick2"];
		$r["c"] = $row1["c"];
		$res[] = $r;
	}
}


echo( json_encode($res) );

?>