<?php

require_once('../../API/db.php');
require_once('../../API/stopwords.php');



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





$results = array();

$word = "";
if(isset($_REQUEST["word"])){
	$word = $_REQUEST["word"];
}

if($word!=""){
	$q0 = "SET SESSION max_heap_table_size=536870912";
	$r0 = $dbh->query($q0);

	$q0 = "SET SESSION tmp_table_size=536870912;";
	$r0 = $dbh->query($q0);

	$q1 = "SELECT txt FROM content WHERE UPPER(txt) LIKE '%" .  strtoupper( $word ) . "%'";	
	$r1 = $dbh->query($q1);
	if($r1){
		foreach ( $r1 as $row1) {

			$val = $row1["txt"];

			
			preg_match_all("/(#\w+)/", $val, $words);

			
			if(isset($words[0])){
				for($i=0; $i<count($words[0]); $i++){

					if(strpos($words[0][$i], strtolower($word))===false && trim($words[0][$i])!="" ){
						if(isset($results[$words[0][$i]])){
							$results[$words[0][$i]] = $results[$words[0][$i]] + 1;
						} else {
							$results[$words[0][$i]] = 1;
						}
					}
				}
			}

		}
	}

}

arsort($results);

foreach ($results as $key => $value) {
	echo($key . "," . $value . "\n");
}

?>