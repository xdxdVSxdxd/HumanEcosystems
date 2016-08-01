<?php

header('Content-Type: text/html; charset=utf-8');

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





$word = "";
if(isset($_REQUEST["word"])){
	$word = $_REQUEST["word"];
}

if($word!=""){
	$q0 = "SET SESSION max_heap_table_size=536870912";
	$r0 = $dbh->query($q0);

	$q0 = "SET SESSION tmp_table_size=536870912;";
	$r0 = $dbh->query($q0);

	$q1 = "SELECT DISTINCT txt FROM content WHERE UPPER(txt) LIKE '%" .  strtoupper( $word ) . "%'";	
	$r1 = $dbh->query($q1);
	if($r1){
		foreach ( $r1 as $row1) {

			$val = $row1["txt"];

			echo($val . "\n");
		}
	}

}
?>