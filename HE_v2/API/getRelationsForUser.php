<?php

require_once('db.php');

$res = array();

$u1 = '';
if(isset($_REQUEST["nick"])){
	$u1 = str_replace("'", "\'", $_REQUEST["nick"]);
}


$q1 = "SELECT DISTINCT nick2,c FROM relations WHERE research='" . $research_code . "' and nick1='" . $u1 . "'";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		
		$r = array();
		$r["nick2"] = $row1["nick2"];
		$r["c"] = $row1["c"];
		$res[] = $r;
	}
}


echo( json_encode($res) );

?>