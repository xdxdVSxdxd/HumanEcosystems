<?php

require_once('../../API/db.php');


$results = array();

$results["nodes"] = array();
$results["links"] = array();


function findUser($un,$dbh){
	$found = false;

	for($i = 0; $i<count($results["nodes"]) && !$found ; $i++ ){
		if($results["nodes"][$i]==$un){
			$found = true;
		}
	}
	return $found;
}


$searchString = "";
if(isset($_REQUEST["search"])){
	$searchString = $_REQUEST["search"];
}



if($searchString!=""){
		$q1 = "SELECT DISTINCT u.id as id, u.nick as nick, u.profile_url as pu FROM users u WHERE u.research='" . $research_code . "' AND UPPER(u.nick) LIKE '%" . strtoupper( str_replace("'", "\'", $searchString)) . "%'";

		$r1 = $dbh->query($q1);
		if($r1){
			foreach ( $r1 as $row1) {

				$u = array();
				$u["id"] = $row1["nick"];
				$u["nick"] = $row1["nick"];
				$u["pu"] = $row1["pu"];
				
				$results["nodes"][] = $u;

				$q2 = "SELECT DISTINCT nick1, nick2, c FROM relations WHERE nick1='" . $row1["nick"] . "' OR nick2='" . $row1["nick"] . "'";
				$r2 = $dbh->query($q2);
				if($r2){
					foreach ( $r2 as $row2) {
						$l = array();
						$l["source"] = $row2["nick1"];
						$l["target"] = $row2["nick2"];
						$l["weight"] = $row2["c"];
						$results["links"][] = $l;

						if(!findUser($row2["nick1"],$dbh)){
							//aggiungi user1 a users

									$q3 = "SELECT DISTINCT u.id as id, u.nick as nick, u.profile_url as pu FROM users u WHERE u.research='" . $research_code . "' AND u.nick='" . $row2["nick1"] . "'";
		
									$r3 = $dbh->query($q3);
									if($r3){
										foreach ( $r3 as $row3) {

											$u = array();
											$u["id"] = $row3["nick"];
											$u["nick"] = $row3["nick"];
											$u["pu"] = $row3["pu"];
											
											$results["nodes"][] = $u;
										}
										$r3->closeCursor();
									}


						}

						if(!findUser($row2["nick2"],$dbh)){
							//aggiungi user1 a users
									$q3 = "SELECT DISTINCT u.id as id, u.nick as nick, u.profile_url as pu FROM users u WHERE u.research='" . $research_code . "' AND u.nick='" . $row2["nick2"] . "'";
		
									$r3 = $dbh->query($q3);
									if($r3){
										foreach ( $r3 as $row3) {

											$u = array();
											$u["id"] = $row3["nick"];
											$u["nick"] = $row3["nick"];
											$u["pu"] = $row3["pu"];
											
											$results["nodes"][] = $u;
										}
										$r3->closeCursor();
									}
						}
					}
					$r2->closeCursor();
				}

			}
			$r1->closeCursor();
		}
} else {
	// non ci sono risultati
}

echo(json_encode($results));
?>