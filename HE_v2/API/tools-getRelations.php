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

$result = array();


		$reflinks = array();
		$nodes = array();
		$i=0;
		$q1 = "SELECT id,nick,profile_url FROM users WHERE research='" . $research_code . "'";

		$r1 = $dbh->query($q1);
		if($r1){
			foreach ( $r1 as $row1) {

				$n = array();
				$n["index"] = $i;
				$n["id"] = $row1["id"];
				$n["nick"] = $row1["nick"];
				if($n["nick"]==""){ $n["nick"] = "a"; }
				$n["profile_url"] = $row1["profile_url"];

				$reflinks[$n["nick"]] = $i;
				
				$i++;

				$nodes[] = $n;
			}
			$r1->closeCursor();
		}

		$result["nodes"] = $nodes;


		$links = array();
		$q1 = "SELECT nick1 as source, nick2 as target, c as weight FROM relations WHERE research='" . $research_code . "'";

		$r1 = $dbh->query($q1);
		if($r1){
			foreach ( $r1 as $row1) {

				$s = $row1["source"];				

				$t = $row1["target"];

				if(isset($reflinks[$s]) && isset($reflinks[$t]) ) {
					$l = array();
					$l["source"] = $reflinks[$s];
					$l["target"] = $reflinks[$t];
					$l["weight"] = $row1["weight"];	
					$links[] = $l;
				}
				
				
				
			}
			$r1->closeCursor();
		}

		$result["links"] = $links;




echo(json_encode(utf8ize($result)  ));

?>