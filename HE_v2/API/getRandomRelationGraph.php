<?php

require_once('db.php');

$res = new stdClass();
$res->nodes = array();
$res->links = array();


$q1 = "SELECT DISTINCT nick1, nick2, c FROM relations WHERE research='" . $research_code . "' ORDER BY RAND() LIMIT 0,1";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		
		$r = array();
		$r["nick1"] = $row1["nick1"];
		$r["nick2"] = $row1["nick2"];
		$r["c"] = $row1["c"];
		

		$n1 = new stdClass();
		$n1->name = $r["nick1"];
		$n1->idx = count($res->nodes);
		$n1->group = 1; 

		$res->nodes[] = $n1;

		$n2 = new stdClass();
		$n2->name = $r["nick2"];
		$n2->idx = count($res->nodes);
		$n2->group = 1;

		$res->nodes[] = $n2;

		$l1 = new stdClass();
		$l1->source = $n1->idx;
		$l1->target = $n2->idx;
		$l1->value = $r["c"];

		$res->links[] = $l1;

		// da n1 ad altri inizio

		$q2 = "SELECT nick2, c FROM relations WHERE research='" . $research_code . "' AND nick1='" . $n1->name . "' AND NOT nick2='" . $n2->name . "'";
		$r2 = $dbh->query($q2);
		if($r2){
			foreach ( $r2 as $row2) {
				
				$n3 = new stdClass();
				$n3->name = $row2["nick2"];
				$n3->idx = count($res->nodes);
				$n3->group = 1; 

				$found = false;
				for($i = 0; $i<count($res->nodes) && !$found ; $i++){
					if($res->nodes[$i]->name==$n3->name){
						$n3->idx = $i;
						$found = true;
					}
				}

				if(!$found){
					$res->nodes[] = $n3;	
				} else {
					// l'ho trovato e ho gia aggiornato l'indice
				}
				
				$l3 = new stdClass();
				$l3->source = $n1->idx;
				$l3->target = $n3->idx;
				$l3->value = $row2["c"];

				$res->links[] = $l3;

			}
			$r2->closeCursor();
		}

		// da n1 ad altri fine



		// da altri a n1 inizio

		$q2 = "SELECT nick1, c FROM relations WHERE research='" . $research_code . "' AND nick2='" . $n1->name . "' AND NOT nick1='" . $n2->name . "'";
		$r2 = $dbh->query($q2);
		if($r2){
			foreach ( $r2 as $row2) {
				
				$n3 = new stdClass();
				$n3->name = $row2["nick1"];
				$n3->idx = count($res->nodes);
				$n3->group = 1; 

				$found = false;
				for($i = 0; $i<count($res->nodes) && !$found ; $i++){
					if($res->nodes[$i]->name==$n3->name){
						$n3->idx = $i;
						$found = true;
					}
				}

				if(!$found){
					$res->nodes[] = $n3;	
				} else {
					// l'ho trovato e ho gia aggiornato l'indice
				}
				
				$l3 = new stdClass();
				$l3->source = $n3->idx;
				$l3->target = $n1->idx;
				$l3->value = $row2["c"];

				$res->links[] = $l3;

			}
			$r2->closeCursor();
		}

		// da altri  a n1 fine




		// da n2 ad altri inizio

		$q2 = "SELECT nick2, c FROM relations WHERE research='" . $research_code . "' AND nick1='" . $n2->name . "' AND NOT nick2='" . $n1->name . "'";
		$r2 = $dbh->query($q2);
		if($r2){
			foreach ( $r2 as $row2) {
				
				$n3 = new stdClass();
				$n3->name = $row2["nick2"];
				$n3->idx = count($res->nodes);
				$n3->group = 1; 

				$found = false;
				for($i = 0; $i<count($res->nodes) && !$found ; $i++){
					if($res->nodes[$i]->name==$n3->name){
						$n3->idx = $i;
						$found = true;
					}
				}

				if(!$found){
					$res->nodes[] = $n3;	
				} else {
					// l'ho trovato e ho gia aggiornato l'indice
				}
				
				$l3 = new stdClass();
				$l3->source = $n2->idx;
				$l3->target = $n3->idx;
				$l3->value = $row2["c"];

				$res->links[] = $l3;

			}
			$r2->closeCursor();
		}

		// da n2 ad altri fine




		// da altri ad n2 inizio

		$q2 = "SELECT nick1, c FROM relations WHERE research='" . $research_code . "' AND nick2='" . $n2->name . "' AND NOT nick1='" . $n1->name . "'";
		$r2 = $dbh->query($q2);
		if($r2){
			foreach ( $r2 as $row2) {
				
				$n3 = new stdClass();
				$n3->name = $row2["nick1"];
				$n3->idx = count($res->nodes);
				$n3->group = 1; 

				$found = false;
				for($i = 0; $i<count($res->nodes) && !$found ; $i++){
					if($res->nodes[$i]->name==$n3->name){
						$n3->idx = $i;
						$found = true;
					}
				}

				if(!$found){
					$res->nodes[] = $n3;	
				} else {
					// l'ho trovato e ho gia aggiornato l'indice
				}
				
				$l3 = new stdClass();
				$l3->source = $n3->idx;
				$l3->target = $n2->idx;
				$l3->value = $row2["c"];

				$res->links[] = $l3;

			}
			$r2->closeCursor();
		}

		// da altri ad n2 fine

	}
	$r1->closeCursor();
}


echo( json_encode($res) );

?>