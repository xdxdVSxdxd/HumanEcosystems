<?php


require_once('../db.php');
require_once('../getWords.php');
require_once('../prepareStatements.php');

$ret = array();

	$prep = $dbh->prepare("SELECT DISTINCT name,color FROM classes WHERE city=:w");
	$prep->bindParam(':w', $www);
	
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