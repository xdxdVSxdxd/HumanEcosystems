<?php


require_once('db.php');
require_once('getWords.php');

$ret = array();

if ($q_map_upd->execute()){
    while($r1 = $q_map_upd->fetch()){
        $rr = array();
        $rr["lat"] = $r1["lat"];
        $rr["lng"] = $r1["lng"];
        $rr["name"] = $r1["name"];
        $rr["c"] = $r1["c"];
        $ret[] = $rr;
    }
}
echo( json_encode($ret) );
?>