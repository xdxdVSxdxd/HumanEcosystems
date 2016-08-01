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

$users = array();

$word = "";
if(isset($_REQUEST["word"])){
	$word = $_REQUEST["word"];
}

if($word!=""){
	$q0 = "SET SESSION max_heap_table_size=536870912";
	$r0 = $dbh->query($q0);

	$q0 = "SET SESSION tmp_table_size=536870912;";
	$r0 = $dbh->query($q0);

	$q0 = "SELECT nick as n1, count(*) as c FROM content c WHERE UPPER(c.txt) LIKE '%" .  strtoupper( $word ) . "%' GROUP BY nick ORDER BY c desc LIMIT 0,2000";
	$r0 = $dbh->query($q0);
	if($r0){
		foreach($r0 as $row0){
			$u = array();
			$u["name"] = $row0["n1"];
			$u["value"] = $row0["c"];
			$users[] = $u;
			
		}
	}

}

function cmp($a, $b)
{
	$result = 0;
	if ($a["value"]==$b["value"]){
		$result = 0;	
	} else {
		$result = ($a["value"]>$b["value"])?-1:1;
	}
    return $result;
}

usort($users, "cmp");

$res = new stdClass();
$res->children = $users;

echo( json_encode(  utf8ize(  $res  )  ) );

//output csv
?>