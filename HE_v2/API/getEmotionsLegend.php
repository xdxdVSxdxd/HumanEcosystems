<?php

require_once('db.php');

$res = array();


$q1 = "SELECT e.label as label , e.color as color FROM emotions e ";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		
		$r = array();
		$r["label"] = $row1["label"];
		$r["color"] = $row1["color"];
		$res[] = $r;
	}
}


echo( json_encode($res) );

?>