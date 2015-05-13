<?php

require_once('db.php');

$minL = 4;

$templates = array();
$templates[] = "[nick] will be dealing with [subject1] and [subject2] within 1 mile of the following coordinates ([lat],[lon]) in the next [days] days";

$templates2 = array();
$templates2[] = "[nick] will be dealing with [subject1] and [subject2] in the next [days] days";


$result = "";

$q1 = "SELECT id, nick FROM users WHERE research='" . $research_code . "' ORDER BY RAND() LIMIT 0,1";
//$q1 = "SELECT id, nick FROM users WHERE processuser=1 AND city='" . $citycode . "' ORDER BY RAND() LIMIT 0,1";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {

		$iduser = $row1["id"];
		$nick = $row1["nick"];
		
		//echo("[" . $nick . "]<br />");

		$q2 = "SELECT id,lat,lng FROM content WHERE id_user=" . $iduser . " ORDER BY t DESC LIMIT 0,20";
		$r2 = $dbh->query($q2);
		$lattot = 999;
		$lontot = 999;
		$corecurrences = array();
		if($r2){
			foreach ( $r2 as $row2) {

				$idco = $row2["id"]; 
				$lat = $row2["lat"];
				$lon = $row2["lng"];

				//echo("contentid->[" . $idco . "]<br />");

				if(isset($lat) && $lat<>999 && isset($lon) && $lon<>999){
					if($lattot==999){
						$lattot = $lat;
					} else {
						$lattot = ($lattot+$lat)/2;
					}
					if($lontot==999){
						$lontot = $lon;
					} else {
						$lontot = ($lontot+$lon)/2;
					}
				}


				// cercare messaggio su co-recurrences
				$q3 = "SELECT idcorr, n FROM classifier_corecmessage WHERE idcontent=" . $idco . " ORDER BY n DESC LIMIT 0,3";
				$r3 = $dbh->query($q3);
				if($r3){
					// se c'è, annotare id delle corecurrences e loro n
					foreach ( $r3 as $row3) {
						//echo("(idcorr,n)[" . $row3["idcorr"] . "," . $row3["n"] . "]<br />");
						if(isset($corecurrences[$row3["idcorr"]])){
							$corecurrences[$row3["idcorr"]] = $corecurrences[$row3["idcorr"]] + $row3["n"];
						}
						else {
							$corecurrences[$row3["idcorr"]] = $row3["n"];
						}
					}
				}
				$r3->closeCursor();
			}
			$r2->closeCursor();
		}


		// se ci sono co-recurrences
		if($corecurrences && count($corecurrences)>0){
			// ordinarle per n-accumulato
			asort($corecurrences);
			//echo("(count corecurrences)[" . count($corecurrences) . "]<br />");
			// prendere un random tra i primi 3
			$idx = mt_rand(0, intval(count($corecurrences)/3) );
			if($idx>(count($corecurrences))-1  ){
				$idx = count($corecurrences) - 1;
			}
			//echo("(idx)[" . $idx . "]<br />");
			$keys = array_keys($corecurrences);
			$idcorecurrence = $keys[$idx];
			$ncorecurrence = $corecurrences[$idcorecurrence];
			//echo("(idcorecurrence)[" . $idcorecurrence . "]<br />");
			$q4 = "SELECT w1.word as word1 , w2.word as word2 FROM classifier_corecurrence corec, classifier_words w1, classifier_words w2 WHERE corec.id=" . $idcorecurrence . " AND w1.id=corec.idw1 AND w2.id=corec.idw2 LIMIT 0,1";
			
			// usarlo nel template
			// se c'e' anche una coordinata->usare un template differente
			$r4 = $dbh->query($q4);
			if($r4){
				foreach ( $r4 as $row4) {
					$word1 = $row4["word1"];
					$word2 = $row4["word2"];
					//echo("(word1,word2)[" . $word1 . "," . $word2 . "]<br />");
					if($lattot<>999 && $lontot<>999){
						// usare il template con le coordinate
						$result = $templates[rand(0, count($templates) - 1)];
						$result = str_replace("[nick]", $nick, $result);
						$result = str_replace("[lat]", $lattot, $result);
						$result = str_replace("[lon]", $lontot, $result);
						$result = str_replace("[subject1]", $word1, $result);
						$result = str_replace("[subject2]", $word2, $result);
						$result = str_replace("[days]", "" . (rand(0,5)) , $result);
					}
					else {
						// usare il template senza coordinate
						$result = $templates2[rand(0, count($templates) - 1)];
						$result = str_replace("[nick]", $nick, $result);
						$result = str_replace("[subject1]", $word1, $result);
						$result = str_replace("[subject2]", $word2, $result);
						$result = str_replace("[days]", "" . (rand(0,5)) , $result);
					}

				}
				$r4->closeCursor();
			}
			else {
				// mettere template standard
				$result = "The future interests of " . $nick . " are unforeseeable, as of now.";
			}

		}
		else {
			$result = "Nothing can be foreseen about the future interests of " . $nick . ", as of now.";
		}
		
	}
	$r1->closeCursor();	
}

echo($result);

?>