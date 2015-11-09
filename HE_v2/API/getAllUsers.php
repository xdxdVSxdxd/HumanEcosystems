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



$res = array();


$q1 = "SELECT DISTINCT nick FROM users WHERE research='" . $research_code . "' ";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		
		$r = array();
		$r["nick"] = $row1["nick"];
		$res[] = $r;
	}
}


echo( json_encode(utf8ize($res)) );

?>