<?php

require_once('db.php');

$heading = "word,time,c\n";

echo( $heading );


		$q1 = "SELECT w.word as w, HOUR(c.t) as h, count(*) as c FROM content c, words w, content_to_class cc WHERE c.research='" . $research_code . "' AND c.id=cc.id_content AND cc.id_word=w.id GROUP BY HOUR(c.t), w.word ORDER BY w.word ASC, HOUR(c.t) ASC";

		$r1 = $dbh->query($q1);
		if($r1){
			foreach ( $r1 as $row1) {

				echo(  $row1["w"] . "," . $row1["h"] . "," . $row1["c"] . "\n" );
				
			}
			$r1->closeCursor();
		}



?>