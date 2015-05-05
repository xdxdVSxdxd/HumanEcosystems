<?php

require_once ("db.php");

$con = mysql_connect($DB_HOST,$DB_USER,$DB_PWD);

mysql_select_db($DB_NAME);

$isfirst = true;

$q = "SELECT * FROM content WHERE lat<>999 AND lng<>999 AND " . $_REQUEST['words'];
$r = mysql_query($q);

if($r){

	if(mysql_num_rows($r)>0){


?>
{"results" : [
<?php
	
		while($row=mysql_fetch_assoc($r)){
			if($isfirst){
				$isfirst=false;
			} else {
				echo(", ");
			}
			echo( json_encode($row) );
		}
?>
]}
<?php
	
	}


	mysql_free_result($r);
}


mysql_close($con);

?>