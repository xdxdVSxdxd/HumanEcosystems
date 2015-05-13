<?php

require_once('db.php');

$res = array();

$fromID = 0;
if(isset($_REQUEST["fromID"])){
	$fromID = $_REQUEST["fromID"];
}

$q1 = "SELECT * FROM users WHERE research='" . $research_code . "' AND id>=" . $fromID . " ORDER BY id ASC LIMIT 0,1000 ";
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
		$r["research"] = $row1["research"];
		$res[] = $r;
	}
}


echo( json_encode($res) );

?>