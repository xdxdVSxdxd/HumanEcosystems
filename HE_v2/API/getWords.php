<?php

$words = array();

$q1 = "SELECT c.id as id_class, c.name as class, w.id as id_word, w.word as word , c.isgeodependent as isgeo FROM classes c, words w WHERE c.id=w.id_class AND c.research=" . $dbh->quote($research_code) . "";


$stat = $dbh->query($q1);
if($stat){
	foreach ( $stat as $row) {
		$ww = array();
		$ww["id_class"] = $row["id_class"];
		$ww["class"] = $row["class"];
		$ww["id_word"] = $row["id_word"];
		$ww["word"] = $row["word"];
		$ww["isgeo"] = $row["isgeo"];
		$words[] = $ww;
	}
	$stat->closeCursor();	
}

?>