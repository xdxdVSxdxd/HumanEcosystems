<?php

require_once('db.php');
require_once('prepareStatements.php');

$res = array();

$fromID = 0;
if(isset($_REQUEST["fromID"])){
	$fromID = $_REQUEST["fromID"];
}

$q1 = "SELECT * FROM " . $prefix . "users WHERE city='" . $citycode . "' AND id>" . $fromID . " ORDER BY id ASC LIMIT 0,1000 ";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		
		$r = array();
		$r["id"] = $row1["id"];
		$r["id_social"] = $row1["id_social"];
		$r["nick"] = $row1["nick"];
		$r["profile_url"] = $row1["profile_url"];
		$r["image_url"] = $row1["image_url"];
		$r["source"] = $row1["source"];
		$r["city"] = $row1["city"];
		$res[] = $r;
	}
}


echo( json_encode($res) );

?>