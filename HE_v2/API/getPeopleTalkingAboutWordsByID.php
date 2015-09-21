<?php

require_once('db.php');

$ids = [];

if(isset($_REQUEST["ids"])){
	$idtmp = $_REQUEST["ids"];
	$ids = explode(",", $idtmp);
}

$res = array();

if(count($ids)>0){
	$q1 = "SELECT u.id as id, u.nick as name , count(*) as c FROM classifier_corecurrence cc, classifier_corecmessage cco, content c, users u WHERE cc.research='" . $research_code . "' AND (   cc.idw1 IN ("  . (  implode(",", $ids) ) . ")   OR   cc.idw1 IN ("  . (  implode(",", $ids) ) . ")   )   AND cco.idcorr=cc.id AND c.id=cco.idcontent AND u.id=c.id_user GROUP BY u.nick";
	$r1 = $dbh->query($q1);
	if($r1){
		foreach ( $r1 as $row1) {
			$rr = array();
			$rr["id"] = $row1["id"];
			$rr["name"] = $row1["name"];
			$rr["c"] = $row1["c"];
			$res[] = $rr;
		}
		$r1->closeCursor();
	}	
}//if count ids




echo( json_encode($res) );

?>