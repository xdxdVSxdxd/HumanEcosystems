<?php

require_once('db.php');
require_once('prepared_statements.php');

$emowords = array();
$q0 = "SELECT word, idemotion FROM emotions_words";
$r0 = $dbh->query($q0);
if($r0){
	foreach ( $r0 as $row0) {
		$emowords[] = $row0;
	}
	$r0->closeCursor();	
}

//print_r($emowords);

$q1 = "SELECT id,txt FROM content WHERE processed_emotions=0 LIMIT 0,10000";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {

		foreach ($emowords as $emo ) {
			
			$rrr = $row1["txt"];
			$rrr = str_replace("#", " ", $rrr);

			if (   (strpos($rrr, " " . $emo["word"]) !== false)   || (strpos($rrr, $emo["word"] . " " ) !== false)  ) {
			    
				$q2 = "INSERT INTO emotions_content(id_content,id_emotion) VALUES( " . $row1["id"] . " , " . $emo["idemotion"] . ")";
				$r2 = $dbh->query($q2);

			}


		}

		$q3 = "UPDATE content SET processed_emotions=1 WHERE id=" . $row1["id"] ;
		$r3 = $dbh->query($q3);



	}
	$r1->closeCursor();	
}

?>