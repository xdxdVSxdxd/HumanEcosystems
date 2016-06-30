<?php

require_once('db.php');


$res = new stdClass();
$res->children = array();

$q1 = "SELECT DISTINCT w.id as id, w.word as word, w.n as n FROM content c, classifier_corecmessage ccm, classifier_corecurrence cc, classifier_words w WHERE language='it' AND ccm.idcontent=c.id AND cc.id=ccm.idcorr AND ( w.id=cc.idw1 OR w.id=cc.idw2 ) ORDER BY w.n DESC LIMIT 0,1000";

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