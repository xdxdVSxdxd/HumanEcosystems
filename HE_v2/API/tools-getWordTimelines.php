<?php

require_once('db.php');

echo("word,date,count\n");

$q1 = "SELECT count(*) as c, w.word as w, YEAR(c.t) as y, MONTH(c.t) as m, DAY(c.t) as d, HOUR(c.t) as h, MINUTE(c.t) as mi FROM content c, content_to_class cc, words w WHERE c.research='" . $research_code . "' AND cc.id_content=c.id AND w.id=cc.id_word GROUP BY w.word, YEAR(c.t), MONTH(c.t), DAY(c.t), HOUR(c.t), MINUTE(c.t) ORDER BY word,y,m,d,h,mi";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {

		$m = $row1["m"];
		if($row1["m"]<10){ $m = "0" . $m; }

		$d = $row1["d"];
		if($row1["d"]<10){ $d = "0" . $d; }

		$h = $row1["h"];
		if($row1["h"]<10){ $h = "0" . $h; }

		$mi = $row1["mi"];
		if($row1["mi"]<10){ $mi = "0" . $mi; }
		
		echo( $row1["w"] . "," . $row1["y"] . " " . $m . " " . $d . " " . $h . ":" . $mi . "," . $row1["c"] . "\n" );
		
	}
	$r1->closeCursor();
}

?>