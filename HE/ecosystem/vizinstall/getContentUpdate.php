<?php


require_once('../db.php');
require_once('../getWords.php');
require_once('../prepareStatements.php');

$ret = array();

if ($q_time->execute()){
    while($r1 = $q_time->fetch()){
        $ret[] = $r1;
    }
}
echo( json_encode($ret) );
?>