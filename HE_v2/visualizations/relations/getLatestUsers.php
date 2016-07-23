<?php

require_once('../../API/db.php');


function utf8ize($d) {
    if (is_array($d)) 
        foreach ($d as $k => $v) 
            $d[$k] = utf8ize($v);

     else if(is_object($d))
        foreach ($d as $k => $v) 
            $d->$k = utf8ize($v);

     else 
        return utf8_encode($d);

    return $d;
}


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






		$q1 = "SELECT DISTINCT u.id as id, u.nick as nick, u.profile_url as pu FROM users u, content c WHERE c.research='" . $research_code . "' AND u.nick=c.nick ORDER BY id DESC LIMIT 0,2000";

		$r1 = $dbh->query($q1);
		if($r1){
			foreach ( $r1 as $row1) {

				$u = array();
				$u["id"] = $row1["nick"];
				$u["nick"] = $row1["nick"];
				$u["pu"] = $row1["pu"];
				
				$results["nodes"][] = $u;

				$q2 = "SELECT DISTINCT nick1, nick2, c FROM relations WHERE nick1='" . str_replace("'", "''", $row1["nick"]) . "' OR nick2='" . str_replace("'", "''", $row1["nick"]) . "'";
				//echo($q2);
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

									$q3 = "SELECT DISTINCT u.id as id, u.nick as nick, u.profile_url as pu FROM users u WHERE u.research='" . $research_code . "' AND u.nick='" . str_replace("'", "''", $row2["nick1"]) . "'";
		
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

echo(json_encode(utf8ize($results)));
?>