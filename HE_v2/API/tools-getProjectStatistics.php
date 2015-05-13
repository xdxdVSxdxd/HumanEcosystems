<?php

require_once('db.php');

$res = array();

$q1 = "SELECT count(*) as c FROM content WHERE research='" . $research_code . "'";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		
		$res["contents"] = $row1["c"];
	}
	$r1->closeCursor();
}

$q1 = "SELECT count(*) as c FROM users WHERE research='" . $research_code . "'";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		
		$res["users"] = $row1["c"];
	}
	$r1->closeCursor();
}

$q1 = "SELECT count(*) as c FROM content WHERE research='" . $research_code . "' AND (NOT lat=999 OR NOT lng=999)";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		
		$res["geocontents"] = $row1["c"];
	}
	$r1->closeCursor();
}

$q1 = "SELECT e.label AS e, COUNT( * ) AS c FROM emotions e, content c, emotions_content ec WHERE e.id = ec.id_emotion AND ec.id_content = c.id AND c.research='" . $research_code . "' GROUP BY e.id ORDER BY c DESC";
$r1 = $dbh->query($q1);
if($r1){
	$rr = array();
	foreach ( $r1 as $row1) {
		$rx = array();
		$rx["label"] = $row1["e"];
		$rx["value"] = $row1["c"];
		$rr[] = $rx;
	}
	$res["emotions"] = $rr;
	$r1->closeCursor();
}



$q1 = "SELECT w.word as w, count(*) as c FROM classes c, content_to_class cc, words w, content co WHERE c.research='" . $research_code . "' AND c.id=cc.id_class AND cc.id_word=w.id AND cc.id_content=co.id AND co.research='" . $research_code . "' GROUP BY w ORDER BY c DESC";
$r1 = $dbh->query($q1);
if($r1){
	$rr = array();
	foreach ( $r1 as $row1) {
		$rx = array();
		$rx["label"] = $row1["w"];
		$rx["value"] = $row1["c"];
		$rr[] = $rx;
	}
	$res["classes"] = $rr;
	$r1->closeCursor();
}


echo( json_encode($res) );
?>