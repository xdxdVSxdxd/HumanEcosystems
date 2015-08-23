<?php

require_once('db.php');

$res = array();


$q1 = "SELECT DISTINCT nick FROM users WHERE research='" . $research_code . "' ";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		
		$r = array();
		$r["nick"] = $row1["nick"];
		$r["relations"] = array();

		$q2 = "SELECT DISTINCT nick2,c FROM relations WHERE research='" . $research_code . "' and nick1='" . $r["nick"] . "'";
		$r2 = $dbh->query($q2);
		if($r2){
			foreach ( $r2 as $row2) {

				$rr = array();
				$rr["nick2"] = $row2["nick2"];
				$rr["c"] = $row2["c"];
				$r["relations"][] = $rr;
			}
			$r2->closeCursor();
		}

		$res[] = $r;
	}
}


echo( json_encode($res) );

?>