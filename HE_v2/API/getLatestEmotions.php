<?php

require_once('db.php');

$res = array();

$q1 = "SELECT a.label as l, count(*) as c FROM (SELECT e.label as label FROM content c , emotions_content ec, emotions e where c.research='" . $research_code . "' and c.id=ec.id_content and ec.id_emotion=e.id order by c.t DESC LIMIT 0,1000) a GROUP BY a.label";

$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		
       

		$r = array();

		//exemplo 1
		//$r["txt"] = $row1["txt"];

		$r["l"] = $row1["l"];
		$r["c"] = $row1["c"];
		
		$res[] = $r;
	}
}


echo( json_encode($res) );

?>