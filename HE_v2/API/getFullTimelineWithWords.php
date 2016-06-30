<?php

require_once('db.php');

$word = "";
if( isset($_REQUEST["word"])){
	$word = $_REQUEST["word"];
}

echo("date,total");
if($word!=""){
	echo("," . $word);
}
echo("\n");

//$currentdate = new DateTime('09/21/2015');
$currentdate = new DateTime('6 months ago');
$dateinterval = new DateInterval('P1D');

$nextdate = new DateTime('6 months ago');
$nextdate->add($dateinterval);

$now = new DateTime();

while($now > $nextdate){

	$q1 = "select CONCAT( YEAR(t), LPAD(MONTH(t),2,'0'), LPAD(DAY(t),2,0)) as date, count(*) as c from content WHERE research='" . $research_code . "' AND (t BETWEEN '" . $currentdate->format('Y-m-d') . " 00:00:00' AND '" . $nextdate->format('Y-m-d') . " 00:00:00') group by YEAR(t), MONTH(t), DAY(t) ORDER BY t ASC LIMIT 0,1";

	//echo($q1 . "\n");

	$r1 = $dbh->query($q1);
	if($r1){
		foreach ( $r1 as $row1) {			
			$d = $row1["date"];
			$c = $row1["c"];

			if($word!=""){

				$q2 = "select CONCAT( YEAR(t), LPAD(MONTH(t),2,'0'), LPAD(DAY(t),2,0)) as date, count(*) as c from content WHERE research='" . $research_code . "' AND (t BETWEEN '" . $currentdate->format('Y-m-d') . " 00:00:00' AND '" . $nextdate->format('Y-m-d') . " 00:00:00')  AND UCASE(txt) LIKE '%" . $word . "%' group by YEAR(t), MONTH(t), DAY(t) ORDER BY t ASC LIMIT 0,1";

				$r2 = $dbh->query($q2);
				if($r2){
					foreach ( $r2 as $row2) {			
						$d2 = $row2["date"];
						$c2 = $row2["c"];
					}
				}

				echo($d . "," . $c . "," . $c2);

			} else {
				echo($d . "," . $c);
			}

			echo("\n");

		}
	}

	$currentdate->add($dateinterval);
	$nextdate->add($dateinterval);

}


?>