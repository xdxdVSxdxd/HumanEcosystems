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
$results["count"] = 0;
$results["users"] = 0;
$results["relations"] = 0;

$word = "";
if(isset($_REQUEST["word"])){
	$word = $_REQUEST["word"];
}


if($word!=""){
	$q0 = "SET SESSION max_heap_table_size=536870912";
	$r0 = $dbh->query($q0);

	$q0 = "SET SESSION tmp_table_size=536870912;";
	$r0 = $dbh->query($q0);

	$q1 = "SELECT count(*) as c FROM content WHERE UPPER(txt) LIKE '%" .  strtoupper( $word ) . "%'";	
	$r1 = $dbh->query($q1);
	if($r1){
		foreach ( $r1 as $row1) {
			$results["count"] = $row1["c"];
		}
	}

	$q1 = "SELECT count(*) as c FROM (SELECT DISTINCT nick FROM content WHERE UPPER(txt) LIKE '%" .  strtoupper( $word ) . "%') a ";	
	$r1 = $dbh->query($q1);
	if($r1){
		foreach ( $r1 as $row1) {
			$results["users"] = $row1["c"];
		}
	}
}


echo(json_encode(utf8ize($results)));
?>