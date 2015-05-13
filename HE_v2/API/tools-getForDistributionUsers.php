<?php

require_once('db.php');

$heading = "word,c,cw\n";

echo( $heading );


		$q1 = "SELECT a.w as w, a.c as c, count(*) as cw FROM ( SELECT w.word as w, c.id_user as idu, c.nick as nick, count(*) as c FROM content c, words w, content_to_class cc WHERE c.research='" . $research_code . "' AND c.id=cc.id_content AND cc.id_word=w.id GROUP BY c.nick, w.word) a GROUP BY a.w, a.c ORDER BY a.w ASC";

		$r1 = $dbh->query($q1);
		if($r1){
			foreach ( $r1 as $row1) {

				echo(  $row1["w"] . "," . $row1["c"] . "," . $row1["cw"] . "\n" );
				
			}
			$r1->closeCursor();
		}



?>