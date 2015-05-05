<?php

require_once('db.php');
require_once('prepareStatements.php');

$res = array();


$q1 = "SELECT DISTINCT nick1,nick2,c FROM " . $prefix . "relations WHERE city='" . $citycode . "' ";
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