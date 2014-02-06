<?php

require_once('db.php');
require_once('getWords.php');
require_once('prepareStatements.php');



$source = "INSTA";
	

$url = "https://api.instagram.com/v1/media/search?lat=" . $mainLat . "&lng=" . $mainLng . "&distance=5000&client_id=CLIENT ID";
$fc = file_get_contents($url);
if(isset($fc) && $fc!=""){
	$js = json_decode($fc,true);
					
	//print_r($js);	
	//echo("<br /><br />" . "<br /><br />");

	for($i = 0; $i<count($js["data"]);$i++){
		$holdFor = array();
		//echo("Text:" . $js["data"][$i]["caption"]["text"] . "<br /><br />");
		foreach ($words as $w) {
				
			if($js["data"][$i]["caption"] && $js["data"][$i]["caption"]["text"] ){
				//if( strpos(  strtoupper( $js["data"][$i]["caption"]["text"] )   ,   strtoupper(  " " . $w["word"] )     ) !== false  ){

				if($w["word"]=="*"){
					$h = array();
					$h["idc"] = $w["id_class"];
					$h["idw"] = $w["id_word"];
					$holdFor[] = $h;
				}
				else if(  preg_match(   "/\b" . strtoupper(  " " . $w["word"] ) . "\b/"     , strtoupper( $js["data"][$i]["caption"]["text"] )   )     ){
					$h = array();
					$h["idc"] = $w["id_class"];
					$h["idw"] = $w["id_word"];
					$holdFor[] = $h;
				}
			}


		}//foreach ($words as $w) {

		//echo("Holding for:<br />");
		//print_r($holdFor);
		//echo("***<br /><br />");

		if(count($holdFor)>0){

			try
			{
  				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$dbh->beginTransaction();

				// controllo se il content e' presente
				$id_social = $js["data"][$i]["id"];
				if ($q_exist_content->execute()){
					if($r1 = $q_exist_content->fetch()){
						// c'e' gia'
						//echo("content presente:<br />");
						//print_r($r1["id"]);
						//echo("***<br /><br />");
					} else {
						//echo("content NON presente<br />");
						// se non lo e':
						//		controllo se c'e' l'user -->user_id
						$user_id_social = $js["data"][$i]["user"]["id"];
						if ($q_exist_user->execute()){
							if($r2 = $q_exist_user->fetch()){
								// c'e' gia'
								$id_user = $r2["id"];
								$nick = $js["data"][$i]["user"]["full_name"];
								$profile_url = $js["data"][$i]["user"]["profile_picture"];
								$image_url = $js["data"][$i]["user"]["profile_picture"];
								//echo("user presente:<br />");
								//print_r($id_user);
								//echo("***<br /><br />");
							} else {
								// se non c'e' lo creo -->user_id
								//echo("content NON presente<br />");
								$nick = $js["data"][$i]["user"]["full_name"];
								$profile_url = $js["data"][$i]["user"]["profile_picture"];
								$image_url = $js["data"][$i]["user"]["profile_picture"];
								$q_insert_user->execute();
								$id_user = $dbh->lastInsertId();
								//echo("user inserito:<br />");
								//print_r($id_user);
								//echo("***<br /><br />");
							}// else di if($r2 = $q_exist_user->fetch()){
						}//if ($q_exist_user->execute()){
						//		memorizzo il content con user_id
						$content_id_social = $js["data"][$i]["id"];
						$content_url = $js["data"][$i]["link"];
						$content_body = $js["data"][$i]["caption"]["text"];
						$reply_to_user_id = "-1";
						$reply_to_content_id = "-1";
						$currLat = 999;
						$currLng = 999;
						if($js["data"][$i]["location"] && $js["data"][$i]["location"]["latitude"] && $js["data"][$i]["location"]["longitude"] ){
							$currLat = $js["data"][$i]["location"]["latitude"];
							$currLng = $js["data"][$i]["location"]["longitude"];
						}
						$q_insert_content->execute();
						$id_content = $dbh->lastInsertId();
						//echo("content inserito:" . $content_body . "<br />");
						//print_r($id_content);
						//echo("***<br /><br />");
						//		memorizzo le relazioni con le keyword
						foreach ($holdFor as $ho) {
							$id_class = $ho["idc"];
							$id_word = $ho["idw"];
							$q_insert_relations->execute();
							//echo("class inserito:<br />");
							//print_r($id_class);
							//echo("***<br /><br />");
						}
					}// else di if($r1 = $q_exist_content->fetch()){
				}//if ($q_exist_content->execute()){

				
				$dbh->commit();

			} catch (Exception $e) {
				$dbh->rollBack();
				//echo "Failed: " . $e->getMessage();
			}//try

		}//if(count($holdFor)>0){



	}//for($i = 0; $i<count($js["data"]);$i++){
	


}//if(isset($fc) && $fc!=""){


?>