<?php


require_once('db.php');
require_once('getWords.php');

$ret = array();

	$prep = $dbh->prepare("SELECT DISTINCT name,color FROM classes WHERE research=:w");
	$prep->bindParam(':w', $research_code);
	
	if($prep->execute()){
		while ($row = $prep->fetch()){
			$rr = array();
	        $rr["name"] = $row["name"];
	        $rr["color"] = $row["color"];
	        $ret[] = $rr;
		}
	}


echo( json_encode($ret) );
?>