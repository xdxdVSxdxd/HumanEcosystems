<?php

require_once('db.php');
require_once('prepareStatements.php');


//select * from content where processed_relations=0
$q1 = "SELECT * FROM " . $prefix . "content WHERE processed_relations=0 LIMIT 0,100";
$r1 = $dbh->query($q1);
if($r1){
	foreach ( $r1 as $row1) {
		try
			{
  				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$dbh->beginTransaction();
				//	if(reply_to_user_id!=NULL && reply_to_user_id!=-1){
				if($row1["reply_to_user_id"] && $row1["reply_to_user_id"]!=-1){
					//		select nick from users where id_social=reply_to_user_id
					$id_social1 = $row1["reply_to_user_id"];
					if ($q_rel1->execute()){
						if($row2 = $q_rel1->fetch()){
							//			aggiorna_relazioni(nick1,nick2)
							$nick1 = $row1["nick"];
							$nick2 = $row2["nick"];




	/*qui*/
	//	select * from relazioni where (nick1=nick1 and nick2=nick2) OR (nick1=nick2 AND nick2=nick1)
	//	if(exists){
	if ($q_rel5->execute()){
		if($found = $q_rel5->fetch() ){
			$c = $found["c"];
			$id_rel = $found["id"];
			$q_rel6->execute();
		} else {
			$c = 1;
			$q_rel7->execute();
		}

	}
	/*qui*/








							//		}
						}
					}
				}

				//	if(reply_to_content_id!=NULL && reply_to_content_id!=-1){
				if($row1["reply_to_content_id"] && $row1["reply_to_content_id"]!=-1){
					//		select * from content where id_social=reply_to_content_id
					$id_content_social1 = $row1["reply_to_user_id"];
					if ($q_rel2->execute()){
						//		if(exists){
						if($row2 = $q_rel2->fetch()){
							//			aggiorna_relazioni(nick1,nick2)
							$nick1 = $row1["nick"];
							$nick2 = $row2["nick"];



	/*qui*/

	//	select * from relazioni where (nick1=nick1 and nick2=nick2) OR (nick1=nick2 AND nick2=nick1)
	//	if(exists){
	if ($q_rel5->execute()){

		if($found = $q_rel5->fetch() ){
			$c = $found["c"];
			$id_rel = $found["id"];
			$q_rel6->execute();
		} else {
			$c = 1;
			$q_rel7->execute();
		}

	}
	/*qui*/





							//		}
						}
					}
				}

				$sub = substr($row1["txt"], 4);
				if($sub){
					$sub = substr($sub, -4);
					if($sub && strlen($sub)>=6){
						$sub = "%" . $sub . "%";
						$id_c = $row1["id"];
						//	select * from content where c2.txt LIKE %MID(c1.txt_originale)%
						if ($q_rel3->execute()){
						//		if(exists){
							while($row2 = $q_rel3->fetch()){
								//			aggiorna_relazioni(nick1,nick2)
								$nick1 = $row1["nick"];
								$nick2 = $row2["nick"];


	/*qui*/
	
	//	select * from relazioni where (nick1=nick1 and nick2=nick2) OR (nick1=nick2 AND nick2=nick1)
	//	if(exists){
	if ($q_rel5->execute()){
		if($found = $q_rel5->fetch() ){
			$c = $found["c"];
			$id_rel = $found["id"];
			$q_rel6->execute();
		} else {
			$c = 1;
			$q_rel7->execute();
		}

	}

	/*qui*/



								//		}
							}
						}
					}
				}
				
				// metti processed_relations=1
				$id_content = $row1["id"];
				$res = $q_rel4->execute();

				$dbh->commit();

		} catch (Exception $e) {
			$dbh->rollBack();
			echo "Failed: " . $e->getMessage();
		}//try


	}
	$r1->closeCursor();	
}


	



?>