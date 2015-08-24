<?php

require_once('db.php');

$res = array();


$q1 = "SELECT c.id as id, c.txt as txt, u.id as uid, u.nick as nick, u.image_url as iurl, GROUP_CONCAT(e.label SEPARATOR ',') as emotion, GROUP_CONCAT(e.color SEPARATOR ',') as color FROM content c, users u, emotions_content ec, emotions e WHERE c.id_user=u.id AND c.research='" . $research_code . "' AND c.id=ec.id_content AND ec.id_emotion=e.id GROUP BY c.id ORDER BY c.t DESC LIMIT 0,100";
$r1 = $dbh->query($q1);
if($r1){
	if($r1->rowCount()>0){
		foreach ( $r1 as $row1) {
				$r = array();
				$r["txt"] = $row1["txt"];
				$r["uid"] = $row1["uid"];
				$r["nick"] = $row1["nick"];
				$r["iurl"] = $row1["iurl"];
				$r["emotion"] = $row1["emotion"];
				$r["color"] = $row1["color"];
				$res[] = $r;	
			$i++;
		
		}	
	}
	
}


echo( json_encode($res) );

?>