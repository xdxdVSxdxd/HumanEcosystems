<?php

require_once('db.php');


$res = new stdClass();
$res->children = array();

$q1 = "SELECT id,word,n FROM classifier_words WHERE research='" . $research_code . "' ORDER BY n DESC LIMIT 0,1000";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		
		$rr = array();
		$rr["name"] = $row1["word"];
		$rr["value"] = $row1["n"];
		$res->children[] = $rr;

	}
	$r1->closeCursor();
}


echo( json_encode($res) );

?>