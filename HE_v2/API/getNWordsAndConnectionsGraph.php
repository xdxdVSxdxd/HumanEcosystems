<?php

require_once('db.php');

$n = 2;

if(isset($_REQUEST["n"])){
	$n = $_REQUEST["n"];
}

$res = array();
$res["meta"] = array();
$res["graph"] = new stdClass();
$res["graph"]->nodes = array();
$res["graph"]->links = array();

$q1 = "SELECT id,word,n FROM classifier_words WHERE research='" . $research_code . "' ORDER BY RAND() LIMIT 0," . $n;
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		$word = array();
		$word["id"] = $row1["id"];
		$word["word"] = $row1["word"];
		$word["n"] = $row1["n"];
		$word["idx"] = count($res["graph"]->nodes);
		$res["graph"]->nodes[] = $word;
		$res["meta"][] = $word;
	}
	$r1->closeCursor();
}

for($i = 0; $i<count($res["meta"]); $i++){
	$w = $res["meta"][$i];

	$q2 = "SELECT cc.n as weight, cw.id as w2id, cw.word as word2, cw.n as n FROM classifier_corecurrence cc, classifier_words cw WHERE cc.idw1=" . $w["id"] . "  AND cw.id=cc.idw2 ";
	$r2 = $dbh->query($q2);
	if($r2){
		foreach ( $r2 as $row2) {
			$w2= array();

			$value = $row2["weight"];

			$w2["id"] = $row2["w2id"];
			$w2["word"] = $row2["word2"];
			$w2["n"] = $row2["n"];

			$found = false;
			$idx = -1;

			for($j=0; $j<count($res["graph"]->nodes) && !$found; $j++){

				if($res["graph"]->nodes[$j]["id"]==$w2["id"]){
					$found = true;
					$idx = $j;
					$w2 = $res["graph"]->nodes[$j];
				}

			}

			if(!$found){
				$w2["idx"] = count($res["graph"]->nodes);
				$res["graph"]->nodes[] = $w2;
			}

			$link = [   "source"=>$w["idx"] ,  "target"=>$w2["idx"],  "value"=>$value   ];

			$res["graph"]->links[] = $link;


		}
		$r2->closeCursor();
	}

}


echo( json_encode($res) );

?>