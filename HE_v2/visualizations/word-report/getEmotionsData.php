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

$word = "";
if(isset($_REQUEST["word"])){
	$word = $_REQUEST["word"];
}

echo("emotion,n\n");
if($word!=""){
	$q0 = "SET SESSION max_heap_table_size=536870912";
	$r0 = $dbh->query($q0);

	$q0 = "SET SESSION tmp_table_size=536870912;";
	$r0 = $dbh->query($q0);

	$q1 = "SELECT e.label as emotion, count(*) as n FROM content c, emotions_content ec, emotions e WHERE UPPER(c.txt) LIKE '%" .  strtoupper( $word ) . "%' AND c.id=ec.id_content AND ec.id_emotion=e.id GROUP BY e.label";	
	$r1 = $dbh->query($q1);
	if($r1){
		foreach ( $r1 as $row1) {
			echo( $row1["emotion"]);
			echo( "," . $row1["n"] . "\n");
		}
	}

}


//output csv
?>