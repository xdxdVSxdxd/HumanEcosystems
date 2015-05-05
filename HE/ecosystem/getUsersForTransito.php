<?php

require_once('db.php');
require_once('prepareStatements.php');

$res = array();

//exemplo construido no WORKSHOP  Usando conteudo de arquivos de texto da cidade de sao paulo com limete de linhas 0 - 100.
//$q1 = "SELECT txt FROM  content  WHERE city = 'saopaulo' LIMIT 0,100";

//contando txt sem limites. O resultado será chamado de "c"
$q1 = "SELECT distinct nick,id_user FROM  content  WHERE city = 'saopaulo' AND ( UPPER(txt) LIKE '%TRANSITO%' )";

$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		
       

		$r = array();

		//exemplo 1
		//$r["txt"] = $row1["txt"];

		$r["nick"] = $row1["nick"];
		$r["id_user"] = $row1["id_user"];
		
		$res[] = $r;
	}
}


echo( json_encode($res) );

?>