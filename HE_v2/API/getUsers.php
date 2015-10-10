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

$fromID = 0;
if(isset($_REQUEST["fromID"])){
	$fromID = $_REQUEST["fromID"];
}

$q1 = "SELECT * FROM users WHERE research='" . $research_code . "' AND id>=" . $fromID . " ORDER BY id DESC LIMIT 0,1000 ";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		
		$r = array();
		$r["id"] = $row1["id"];
		$r["id_social"] = $row1["id_social"];
		$r["nick"] = $row1["nick"];
		$r["profile_url"] = $row1["profile_url"];
		$r["image_url"] = $row1["image_url"];
		$r["source"] = $row1["source"];
		$r["research"] = $row1["research"];
		$res[] = $r;
	}
}


echo( json_encode(utf8ize($res)) );

?>