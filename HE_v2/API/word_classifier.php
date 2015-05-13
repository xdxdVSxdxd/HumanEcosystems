<?php

require_once('db.php');

$minL = 4;

$q1 = "SELECT id,txt,t,research FROM content WHERE processed_classification=0 LIMIT 0,300";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {

		$txt1 = $row1["txt"];
		$idco = $row1["id"];
		$t1 = $row1["t"];
		$research = $row1["research"];

		// cleanup string and replace chars with spaces

		// remove urls
		$regex = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?).*$)@";
		$txt1 = preg_replace($regex, ' ', $txt1);

		$txt1 = preg_replace("/[^[:alnum:][:space:]]/ui", ' ', $txt1);

		$txt1 = strtoupper($txt1);

		$txt1 = str_replace("\t", ' ', $txt1); // remove tabs
		$txt1 = str_replace("\n", ' ', $txt1); // remove new lines
		$txt1 = str_replace("\r", ' ', $txt1); // remove carriage returns

		// split chars by spaces
		$parts1 = explode(" ",$txt1);

		$idwords = array();


		// take each word (w1), which is longer than minL chars
		for($i = 0; $i<count($parts1); $i++){

			$w1 = $parts1[$i];

			if(strlen($w1)>$minL){

				// see if it is on the db
				$id1 = -1;
				$n1 = -1;
				$q2 = "SELECT id,n FROM classifier_words WHERE word='" . $w1 . "' AND research='" . $research . "' LIMIT 0,1";
				$r2 = $dbh->query($q2);
				if($r2){
					foreach ( $r2 as $row2) {
						// yes --> add 1 to n
						$id1 = $row2["id"];
						$n1 = $row2["n"];
						$n1 = $n1 + 1;
						$q3 = "UPDATE classifier_words SET n=" . $n1 . " WHERE id=" . $id1;
						$r3 = $dbh->query($q3);
					}
				}
				$r2->closeCursor();	
				// no --> add it
				if($id1==-1 && $n1==-1){
					$n1 = 1;
					$q3 = "INSERT INTO classifier_words(word,n,research) VALUES('" . $w1 . "'," . $n1 . ",'" . $research . "')";
					$r3 = $dbh->query($q3);

					$id1 = $dbh->lastInsertId();
				}
					
				$idwords[] = $id1;
				
			}
		}

		for($i = 0 ; $i<count($idwords); $i++){
			$id1 = $idwords[$i];
			for($j = $i+1 ; $j<count($idwords); $j++){
				$id2 = $idwords[$j];
				$q3 = "SELECT id,n FROM classifier_corecurrence WHERE ((idw1=" . $id1 . " AND idw2=" . $id2 . ") OR (idw1=" . $id2 . " AND idw2=" . $id1 . ")) AND research='" . $research . "'  LIMIT 0,1";
				$r3 = $dbh->query($q3);
				$idcorr = -1;
				$ncorr = -1;
				if($r3){
					foreach ( $r3 as $row3) {
						$idcorr = $row3["id"];
						$ncorr = $row3["n"];
						$ncorr = $ncorr + 1;
						$q4 = "UPDATE classifier_corecurrence SET n=" . $ncorr . " WHERE id=" . $idcorr;
						$r4 = $dbh->query($q4);
					}
				}
				$r3->closeCursor();	
				if($idcorr==-1 && $ncorr==-1){
					$ncorr = 1;
					$q4 = "INSERT INTO classifier_corecurrence(idw1,idw2,n,research) VALUES(" . $id1 . "," . $id2 . "," . $ncorr . ",'" . $research . "')";
					$r4 = $dbh->query($q4);
					$idcorr = $dbh->lastInsertId();
				}

				$idcome = -1;
				$ncome = -1;
				$q5 = "SELECT id,n FROM classifier_corecmessage WHERE idcorr=" . $idcorr . " AND idcontent=" . $idco . " AND research='" . $research . "' LIMIT 0,1";
				$r5 = $dbh->query($q5);
				if($r5){
					foreach ($r5 as $row5) {
						$idcome = $row5["id"];
						$ncome = $row5["n"];
						$ncome = $ncome + 1;
						$q6 = "UPDATE classifier_corecmessage SET n=" . $ncome . " WHERE id=" . $idcome;
						$r6 = $dbh->query($q6);
					}
				}
				if($idcome==-1 && $ncome==-1){
					$ncome = 1;
					$q6 = "INSERT INTO classifier_corecmessage(idcorr,idcontent,t,n,research) VALUES(" . $idcorr . "," . $idco . ",'" . $t1 . "'," . $ncome . ",'" . $research . "')";
					$r6 = $dbh->query($q6);
				}
			}			
		}

		// mark with processed_classification=1
		$q7 = "UPDATE content SET processed_classification=1 WHERE id=" . $idco;
		$r7 = $dbh->query($q7);

	}
	$r1->closeCursor();	
}

?>