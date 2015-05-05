<?php

require_once('db.php');
require_once('prepareStatements.php');

$res = array();


$q1 = "SELECT DISTINCT nick FROM " . $prefix . "users WHERE city='" . $citycode . "' ";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		
		$r = array();
		$r["nick"] = $row1["nick"];
		$res[] = $r;
	}
}


echo( json_encode($res) );

?>