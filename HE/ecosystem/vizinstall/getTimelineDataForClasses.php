<?php


require_once('../db.php');
require_once('../getWords.php');
require_once('../prepareStatements.php');

$ret = array();

$classfilter = 0;
if(isset($_REQUEST["c"])){
	$classfilter = $_REQUEST["c"];
}


if ($q_extract_timeline_class->execute()){
    while($r1 = $q_extract_timeline_class->fetch()){
        $ret[] = $r1;
    }
}
echo( json_encode($ret) );
?>