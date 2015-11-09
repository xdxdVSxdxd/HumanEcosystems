<?php

require_once('db.php');

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

$ids = [];

//print_r($_REQUEST);

if(isset($_REQUEST["ids"])){
	$idtmp = $_REQUEST["ids"];
	$ids = explode(",", $idtmp);
}

$res = array();

if(count($ids)>0){
	$q1 = "SELECT u.id as id, u.nick as name, u.profile_url as profile , count(*) as c FROM classifier_corecurrence cc, classifier_corecmessage cco, content c, users u WHERE cc.research='" . $research_code . "' AND (   cc.idw1 IN ("  . (  implode(",", $ids) ) . ")   OR   cc.idw1 IN ("  . (  implode(",", $ids) ) . ")   )   AND cco.idcorr=cc.id AND c.id=cco.idcontent AND u.id=c.id_user GROUP BY u.nick";
	//echo($q1);
	$r1 = $dbh->query($q1);
	if($r1){
		foreach ( $r1 as $row1) {
			$rr = array();
			$rr["id"] = $row1["id"];
			$rr["name"] = $row1["name"];
			$rr["profile"] = $row1["profile"];
			$rr["c"] = $row1["c"];
			$res[] = $rr;
		}
		$r1->closeCursor();
	}	
}//if count ids




echo( json_encode(utf8ize($res) ) );

?>