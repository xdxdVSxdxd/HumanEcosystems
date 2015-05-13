<?php

require_once('db.php');

$heading = "word,";

$emotions = array();
$q1 = "SELECT id,label FROM emotions ORDER BY label";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {

		$em = array();
		$em["id"] = $row1["id"];
		$em["label"] = $row1["label"];
		
		$emotions[] = $em;

	}
	$r1->closeCursor();
}


$words = array();
$q1 = "SELECT id,word FROM words WHERE research='" . $research_code . "' ORDER BY word";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {

		$em = array();
		$em["id"] = $row1["id"];
		$em["word"] = $row1["word"];
		
		$words[] = $em;

	}
	$r1->closeCursor();
}


for($i=0; $i<count($emotions); $i++){
	$heading = $heading . $emotions[$i]["label"];
	if( $i < (count($emotions)-1) ){
		$heading = $heading . ",";
	}
}

echo($heading . "\n");


for($i = 0; $i<count($words); $i++){
	echo($words[$i]["word"] . ",");
	for($j = 0; $j<count($emotions); $j++){
		$q1 = "SELECT e.label as emo, count(*) as c FROM content c, words w, content_to_class cc, emotions_content ec, emotions e WHERE c.research='" . $research_code . "' AND w.word='" . str_replace("'", "\'", $words[$i]["word"]) . "' AND e.id=" . $emotions[$j]["id"] . " AND c.id=cc.id_content AND c.id=ec.id_content AND cc.id_word=w.id AND ec.id_emotion=e.id GROUP BY e.label LIMIT 0,1";

		//echo("\n\n" . $q1 . "\n\n");

		$count = 1;

		$r1 = $dbh->query($q1);
		if($r1){
			foreach ( $r1 as $row1) {

				$count = $row1["c"] + 1;
				
			}
			$r1->closeCursor();
		}
		echo($count);
		if($j<(count($emotions)-1) ){
			echo(",");
		}
	}	
	echo("\n");
}



?>