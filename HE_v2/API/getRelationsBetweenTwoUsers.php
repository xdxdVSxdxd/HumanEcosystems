<?php

require_once('db.php');


$n1 = $_REQUEST["n1"];
$n2 = $_REQUEST["n2"];

$res = array();

//exemplo construido no WORKSHOP  Usando conteudo de arquivos de texto da cidade de sao paulo com limete de linhas 0 - 100.
//$q1 = "SELECT txt FROM  content  WHERE city = 'saopaulo' LIMIT 0,100";

//contando txt sem limites. O resultado será chamado de "c"
$q1 = "SELECT c FROM  relations  WHERE research='" . $research_code . "' AND (  (nick1='"  . $n1 .  "' AND nick2='"  . $n2 .  "')  OR  (nick1='"  . $n2 .  "' AND nick2='"  . $n1 .  "')   ) ";

$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		
       

		$r = array();

		$r["c"] = $row1["c"];
		
		$res[] = $r;
	}
}


echo( json_encode($res) );

?>