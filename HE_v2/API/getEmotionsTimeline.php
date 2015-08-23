<?php

require_once('db.php');

$now = new DateTime();//getdate();

$s = array();


for($i = 0; $i<100; $i++){



	$parts = $now;

	$idx = $now->format("Y") . "" . $now->format("m") . "" . $now->format("d") . "" . $now->format("H") . "" . $now->format("i");

	$s[  $idx  ] = array();

	$s[ $idx ]["Love"] = 0;
	$s[ $idx ]["Anger"] = 0;
	$s[ $idx ]["Disgust"] = 0;
	$s[ $idx ]["Boredom"] = 0;
	$s[ $idx ]["Fear"] = 0;
	$s[ $idx ]["Hate"] = 0;
	$s[ $idx ]["Joy"] = 0;
	$s[ $idx ]["Surprise"] = 0;
	$s[ $idx ]["Trust"] = 0;
	$s[ $idx ]["Sadness"] = 0;
	$s[ $idx ]["Anticipation"] = 0;
	$s[ $idx ]["Violence"] = 0;
	$s[ $idx ]["Terror"] = 0;

	$now = date_sub( $now , date_interval_create_from_date_string('1 minute')  );

}

$a = array();
$a[] = "Love";
$a[] = "Anger";
$a[] = "Disgust";
$a[] = "Boredom";
$a[] = "Fear";
$a[] = "Hate";
$a[] = "Joy";
$a[] = "Surprise";
$a[] = "Trust";
$a[] = "Sadness";
$a[] = "Anticipation";
$a[] = "Violence";
$a[] = "Terror";



$q1 = "SELECT  a.y as y, a.m as m, a.d as d, a.h as h, a.minute as minute , a.label as label, count(*) as c  FROM (SELECT YEAR(c.t) as y, MONTH(c.t) as m, DAY(c.t) as d , HOUR(c.t) as h, MINUTE(c.t) as minute, e.label as label FROM content c, emotions_content ec, emotions e WHERE c.research='" . $research_code . "' AND ec.id_content=c.id AND e.id=ec.id_emotion ORDER BY c.t DESC LIMIT 0,5000) a GROUP BY a.minute, a.h, a.d, a.m, a.y, a.label";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		
		$r = array();
		$r["y"] = $row1["y"];
		$r["m"] = $row1["m"];
		$r["d"] = $row1["d"];
		$r["h"] = $row1["h"];
		$r["minute"] = $row1["minute"];
		$r["label"] = $row1["label"];
		$r["c"] = $row1["c"];

		if(strlen($r["m"])<2){ $r["m"] = "0" . $r["m"]; }
		if(strlen($r["minute"])<2){ $r["minute"] = "0" . $r["minute"]; }
		if(strlen($r["d"])<2){ $r["d"] = "0" . $r["d"]; }
		if(strlen($r["h"])<2){ $r["h"] = "0" . $r["h"]; }

		//print_r($r);

		$idx = $r["y"] . "" . $r["m"] . "" . $r["d"] . "" . $r["h"] . "" . $r["minute"];

		//echo($idx . "\n\n");

		if(isset($s[ $idx ])){
			if(isset($s[ $idx ][$r["label"]])){
				$s[ $idx ][$r["label"]] = $r["c"];
			}
		}


	}
}



// restituire stringa
echo("date\t");
for($i = 0; $i<count($a);$i++){
	echo($a[$i] . "\t");
}
echo("\n");
foreach($s as $k=>$v){

	echo($k . "\t");
	for($i = 0; $i<count($a);$i++){
		echo($v[$a[$i]] . "\t");
	}
	echo("\n");
}
?>