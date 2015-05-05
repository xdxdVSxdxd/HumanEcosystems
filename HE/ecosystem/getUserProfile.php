<?php

require_once('db.php');
require_once('prepareStatements.php');

$res = array();

//select * from content where processed_relations=0
$q1 = "SELECT * FROM " . $prefix . "users WHERE nick='" . $_REQUEST["n"] . "' LIMIT 0,1";
$found = false;
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		$found = true;
		$res["user"] = $row1;
	}
}

if(!$found){
	$res["user"]["image_url"] = "blank.png";
	$res["user"]["nick"] = $_REQUEST["n"];
}

$relations = array();

$q2 = "SELECT r.nick1 as n1, r.nick2 as n2, r.c as c FROM relations r WHERE r.nick1='"  . $_REQUEST["n"] . "' OR r.nick2='"  . $_REQUEST["n"] . "' ORDER BY c DESC LIMIT 0,50";
$r2 = $dbh->query($q2);
if($r1){
	foreach ( $r2 as $row2) {
		$relations[] = $row2;
	}
}

$res["relations"] = $relations;

echo( json_encode($res) );

?>