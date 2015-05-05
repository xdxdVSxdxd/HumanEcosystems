<?php

require_once('db.php');
require_once('prepareStatements.php');

$res = array();

$words = "";
if(isset($_REQUEST["words"])){
	$words = strtoupper(trim($_REQUEST["words"]));
}

$q1 = "SELECT distinct nick, txt, link FROM " . $prefix . "content WHERE city='" . $citycode . "' ";

if($words!=""){
	$wa = explode(" ",$words);
	foreach( $wa as $wo){
		$q1 = $q1 . " AND UPPER(txt) LIKE '%" . $wo . "%' ";
	}
}

$q1 = $q1 . " ORDER BY id DESC LIMIT 0,1000 ";


$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		
		$r = array();
		$r["nick"] = $row1["nick"];
		$r["txt"] = $row1["txt"];
		$r["link"] = $row1["link"];
		$res[] = $r;
	}
}


echo( json_encode($res) );

?>