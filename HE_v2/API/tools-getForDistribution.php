<?php

require_once('db.php');

$heading = "word,emotion,c\n";

echo( $heading );


		$q1 = "SELECT w.word as w, e.label as e, count(*) as c FROM content c, words w, content_to_class cc, emotions_content ec, emotions e WHERE c.research='" . $research_code . "' AND c.id=cc.id_content AND c.id=ec.id_content AND cc.id_word=w.id AND ec.id_emotion=e.id GROUP BY e.label,w.word ORDER BY e.label ASC, w.word ASC";

		$r1 = $dbh->query($q1);
		if($r1){
			foreach ( $r1 as $row1) {

				echo(  $row1["w"] . "," . $row1["e"] . "," . $row1["c"] . "\n" );
				
			}
			$r1->closeCursor();
		}



?>