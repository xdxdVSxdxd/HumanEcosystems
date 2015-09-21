<?php

require_once('db.php');

$meta = array();

$res = new stdClass();
$res->nodes = array();
$res->links = array();

$q1 = "SELECT id,word,n FROM classifier_words WHERE research='" . $research_code . "' ORDER BY n DESC LIMIT 0,100";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		$word = array();
		$word["id"] = $row1["id"];
		$word["name"] = $row1["word"];
		$word["n"] = $row1["n"];
		$word["group"] = $row1["n"];
		$word["idx"] = count($res->nodes);
		$res->nodes[] = $word;
		$meta[] = $word;
	}
	$r1->closeCursor();
}

for($i = 0; $i<count($meta); $i++){
	$w1 = $meta[$i];
	for($j = 0; $j<count($meta); $j++){
		$w2 = $meta[$j];

		$q2 = "SELECT cc.n as weight FROM classifier_corecurrence cc WHERE cc.idw1=" . $w1["id"] . "  AND cc.idw2=" . $w1["id"] . " ";
		$r2 = $dbh->query($q2);
		if($r2){
			foreach ( $r2 as $row2) {
				$value = $row2["weight"];

				$link = [   "source"=>$w1["idx"] ,  "target"=>$w2["idx"],  "value"=>$value   ];

				$res->links[] = $link;
			}
			$r2->closeCursor();
		}

	}

}


echo( json_encode($res) );

?>