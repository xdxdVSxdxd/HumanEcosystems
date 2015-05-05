<?php

require_once('db.php');
require_once('prepareStatements.php');

$res = array();


$q1 = "SELECT count( id ) as c FROM content WHERE city='saopaulo'";




$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		
		$r = array();
		$r["c"] = $row1["c"];
		$res[] = $r;
	}
}



echo( json_encode($res) );

?>