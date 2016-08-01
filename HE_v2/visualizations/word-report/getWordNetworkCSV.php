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

			$regex = "@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?).*$)@";
			$val = preg_replace($regex, ' ', $val);
			$val = preg_replace("/[^[:alnum:][:space:]]/ui", ' ', $val);

			$val = strtoupper($val);

			$val = str_replace("HTTPS", ' ', $val); // remove https
			$val = str_replace("HTTP", ' ', $val); // remove http

			$val = str_replace("\t", ' ', $val); // remove tabs
			$val = str_replace("\n", ' ', $val); // remove new lines
			$val = str_replace("\r", ' ', $val); // remove carriage returns

			$val = strtolower($val);
			$val = preg_replace("#[[:punct:]]#", " ", $val);
			$val = preg_replace("/[^A-Za-z]/", ' ', $val);

			for($i = 0; $i<count($stopwords); $i++){
				$val = preg_replace('/\b' . $stopwords[$i] . '\b/u', ' ', $val);
			}

			$words = explode(" ", $val);

			for($i=0; $i<count($words); $i++){

				if(strpos($words[$i], strtolower($word))===false && trim($words[$i])!="" && strlen($words[$i])>3 ){
					if(isset($results[$words[$i]])){
						$results[$words[$i]] = $results[$words[$i]] + 1;
					} else {
						$results[$words[$i]] = 1;
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