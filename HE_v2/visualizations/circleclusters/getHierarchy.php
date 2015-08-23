<?php

require_once('../../API/db.php');


$results = array();




		$q1 = "SELECT DISTINCT id,nick FROM users WHERE research='" . $research_code . "' AND NOT nick='' ORDER BY nick asc";


		$r1 = $dbh->query($q1);
		if($r1){
			foreach ( $r1 as $row1) {

								
					$u1 = array();

					//echo($row1["nick"] . "<br />");

					$u1["name"] = 'users.' . $row1["id"];
					$u1["nick"] = $row1["nick"];
					$u1["size"] = 1;

					$imp = array();

					$cc = 0;

					$q2 = "SELECT DISTINCT u.id as id, r.c as c FROM relations r , users u WHERE nick1='" . $row1["nick"] . "' AND u.nick=r.nick2";
					$r2 = $dbh->query($q2);
					if($r2){
						foreach ( $r2 as $row2) {
							$imp[] = 'users.' . $row2["id"];
							$cc = $cc + $row2["c"];
						}
						$r2->closeCursor();
					}
					


					$q2 = "SELECT DISTINCT u.id as id, r.c as c FROM relations r , users u WHERE nick2='" . $row1["nick"] . "' AND u.nick=r.nick1";
					$r2 = $dbh->query($q2);
					if($r2){
						foreach ( $r2 as $row2) {
							$imp[] = 'users.' . $row2["id"];
							$cc = $cc + $row2["c"];
						}
						$r2->closeCursor();
					}
					

					$u1["size"] = $cc;

					$u1["imports"] = $imp;


					$results[] = $u1;
				
			}
			$r1->closeCursor();
			
		}

echo(json_encode($results));
?>