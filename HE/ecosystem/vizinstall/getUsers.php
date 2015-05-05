<?php


require_once('../db.php');
require_once('../getWords.php');
require_once('../prepareStatements.php');

$ret = array();

if ($q_users->execute()){
    while($r1 = $q_users->fetch()){
        $ret[] = $r1;
    }
}
echo( json_encode($ret) );
?>