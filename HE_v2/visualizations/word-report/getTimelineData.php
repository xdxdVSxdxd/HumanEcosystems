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

echo("date,close\n");
if($word!=""){
	$q0 = "SET SESSION max_heap_table_size=536870912";
	$r0 = $dbh->query($q0);

	$q0 = "SET SESSION tmp_table_size=536870912;";
	$r0 = $dbh->query($q0);

	$q1 = "SELECT  DAY(t) as d, MONTH(t) as m , YEAR(t) as y,   count(*) as c FROM content WHERE UPPER(txt) LIKE '%" .  strtoupper( $word ) . "%' GROUP BY YEAR(t), MONTH(t), DAY(t) ORDER BY t desc";	
	$r1 = $dbh->query($q1);
	if($r1){
		foreach ( $r1 as $row1) {
			if($row1["d"]<10){ echo("0");}
			echo( $row1["d"]);
			echo("-");
			if($row1["m"]<10){ echo("0");}
			echo( $row1["m"]);
			echo("-");
			echo( $row1["y"]);
			echo( "," . $row1["c"] . "\n");
		}
	}

}


//output csv
?>