<?php

require_once('db.php');

$word = "";

if(isset($_REQUEST["word"])){
	$word = $_REQUEST["word"];
}

$res = array();

if($word!=""){

	$q1 = "SELECT id,word,n FROM classifier_words WHERE research='" . $research_code . "' AND UPPER(word) LIKE '" . strtoupper($word) . "%' ORDER BY n DESC";
	$r1 = $dbh->query($q1);
	if($r1){
		foreach ( $r1 as $row1) {
			
			$rr = array();
			$rr["id"] = $row1["id"];
			$rr["word"] = $row1["word"];
			$rr["n"] = $row1["n"];

			$rr["corec"] = array();

			$q2 = "SELECT cc.n as n, cw.id as crecid, cw.word as word FROM classifier_corecurrence cc, classifier_words cw WHERE  cc.research='" . $research_code . "' AND cc.idw1=" . $rr["id"] . " AND cw.id=cc.idw2 ORDER BY cc.n DESC LIMIT 0,20" ;
			$r2 = $dbh->query($q2);
			if($r2){
				foreach ( $r2 as $row2) {
					$rco = array();
					$rco["n"] = $row2["n"];
					$rco["crecid"] = $row2["crecid"];
					$rco["word"] = $row2["word"];

					$rr["corec"][] = $rco;
				}
				$r2->closeCursor();
			}


			$res[] = $rr;
		}
		$r1->closeCursor();
	}

}

echo( json_encode($res) );

?>