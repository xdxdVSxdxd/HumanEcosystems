<?php

require_once('db.php');

$ids = [];

if(isset($_REQUEST["ids"])){
	$idtmp = $_REQUEST["ids"];
	$ids = explode(",", $idtmp);

	for($i = 0; $i<count($ids); $i++){
		$ids[$i] = str_replace("'", "\'", $ids[$i]);

		$ids[$i] = "'" . $ids[$i] . "'";
	}
}

$res = array();

$res2 = new stdClass();
$res2->nodes = array();
$res2->links = array();

if(count($ids)>0){
	$q1 = "SELECT r.nick1 as n1, r.nick2 as n2, r.c as c  FROM relations r WHERE r.research='" . $research_code . "' AND (   r.nick1 IN ("  . (  implode(",", $ids) ) . ")   OR   r.nick2 IN ("  . (  implode(",", $ids) ) . ")   )";
	$r1 = $dbh->query($q1);
	if($r1){
		foreach ( $r1 as $row1) {
			$rr = array();
			$rr["n1"] = $row1["n1"];
			$rr["n2"] = $row1["n2"];
			$rr["c"] = $row1["c"];
			$res[] = $rr;
		}
		$r1->closeCursor();
	}

	for($i = 0; $i<count($res); $i++){
		
		$n1 = new stdClass();
		$n1->name =  str_replace( "\'", "'",  $res[$i]["n1"] );
		$n1->group = 1;
		$n1->n = 1;

		$found = false;
		$idx = -1;
		for($j = 0; $j<count($res2->nodes ) && !$found; $j++  ){
			if($n1->name==$res2->nodes[$j]->name){
				$found = true;
				$idx = $j;
			}
		}

		if(!$found){
			$n1->idx = count($res2->nodes);
			$res2->nodes[] = $n1;
		} else {
			$n1->idx = $idx;
		}




		$n2 = new stdClass();
		$n2->name =  str_replace( "\'", "'",  $res[$i]["n2"] );
		$n1->group = 1;
		$n2->n = 1;

		$found = false;
		$idx = -1;
		for($j = 0; $j<count($res2->nodes ) && !$found; $j++  ){
			if(  $n2->name == $res2->nodes[$j]->name ){
				$found = true;
				$idx = $j;
			}
		}

		if(!$found){
			$n2->idx = count($res2->nodes);
			$res2->nodes[] = $n2;
		} else {
			$n2->idx = $idx;
		}

		$linko = new stdClass();
		$linko->source = $n1->idx;
		$linko->target = $n2->idx;
		$linko->value = $res[$i]["c"];

		$res2->links[] = $linko;

	}

}//if count ids

echo( json_encode($res2) );

?>