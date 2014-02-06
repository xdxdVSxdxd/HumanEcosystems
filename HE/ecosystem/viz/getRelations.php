<?php


require_once('../db.php');
require_once('../getWords.php');
require_once('../prepareStatements.php');

$ret = array();

if ($q_rels->execute()){
    while($r1 = $q_rels->fetch()){
        $ret[] = $r1;
    }
}
echo( json_encode($ret) );
?>