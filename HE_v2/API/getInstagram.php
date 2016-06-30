<?php

require_once('db.php');
require_once('getWords.php');


function Slug($string)
{
    return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
}


$source = "INSTA";

$url = array();
	
//$url = "https://api.instagram.com/v1/tags/" . $w["word"] . "/media/recent?client_id=b60d33ad3da0461dbe7e7bd898eee193";

if($mainLng==999 && $mainLng==999){

	
	for($i=0 ; $i<count($words) ; $i++){
		$qq = "https://api.instagram.com/v1/tags/";
		$qq = $qq . Slug(str_replace(" ", "", $words[$i]["word"]) );
		$qq = $qq . "/media/recent?client_id=" . $in_client_id;
		$url[] = $qq;
	}

} else {

	$url[] = "https://api.instagram.com/v1/media/search?lat=" . $mainLat . "&lng=" . $mainLng . "&distance=5000&client_id=" . $in_client_id;

}



for($urlc = 0; $urlc<count($url) ; $urlc++){

	//echo( $url[$urlc] . "<br/>" );

$fc = file_get_contents($url[$urlc]);
if(isset($fc) && $fc!=""){
	$js = json_decode($fc,true);
					
	//print_r($js);	
	//echo("<br /><br />" . "<br /><br />");

	//echo("quanti:" . count($js["data"]) . "<br /><br />");

	for($i = 0; $i<count($js["data"]);$i++){

		//echo("[1]:<br /><br />");

		$holdFor = array();
		//echo("Text:" . $js["data"][$i]["caption"]["text"] . "<br /><br />");
		foreach ($words as $w) {
				
			if($js["data"][$i]["caption"] && $js["data"][$i]["caption"]["text"] ){
				//if( strpos(  strtoupper( $js["data"][$i]["caption"]["text"] )   ,   strtoupper(  " " . $w["word"] )     ) !== false  ){

				//echo("[" . $js["data"][$i]["caption"]["text"] . "]");

				if($w["word"]=="*"){
					$h = array();
					$h["idc"] = $w["id_class"];
					$h["idw"] = $w["id_word"];
					$holdFor[] = $h;
				}
				else {


					$wos =  explode(" ", $w["word"]);
					$foundw = true;
					for($i = 0 ; $i<count($wos)&&$foundw;$i++){
						if(  
							preg_match(   "/\b" . strtoupper(  "" . $wos[$i] ) . "\b/"    , strtoupper( $js["data"][$i]["caption"]["text"] )   )   || 
							preg_match(   "/" . strtoupper(  "" . $wos[$i] ) . "\b/"    , strtoupper( $js["data"][$i]["caption"]["text"] )   ) ||
							preg_match(   "/\b" . strtoupper(  "" . $wos[$i] ) . "/"    , strtoupper( $js["data"][$i]["caption"]["text"] )   )  ||

							preg_match(   "/\b" . strtoupper(  " " . $wos[$i] ) . "\b/"    , strtoupper( $js["data"][$i]["caption"]["text"] )   )   || 
							preg_match(   "/" . strtoupper(  " " . $wos[$i] ) . "\b/"    , strtoupper( $js["data"][$i]["caption"]["text"] )   ) ||
							preg_match(   "/\b" . strtoupper(  " " . $wos[$i] ) . "/"    , strtoupper( $js["data"][$i]["caption"]["text"] )   )  	

						){
							$foundw = true;
						} else {
							$foundw = false;
						}
					}

					if(  

						$foundw==true

					  ){

						
						$h = array();
						$h["idc"] = $w["id_class"];
						$h["idw"] = $w["id_word"];
						$holdFor[] = $h;
					}
				}

			}

		}//foreach ($words as $w) {

		//echo("Holding for:<br />");
		//print_r($holdFor);
		//echo("***<br /><br />");

		if(count($holdFor)>0){

			//echo("lo tengo<br /><br />");

			try
			{
  				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$dbh->beginTransaction();

				// controllo se il content e' presente
				$id_social = $js["data"][$i]["id"];
				$language = "";
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
								$profile_url = "https://instagram.com/" . $js["data"][$i]["user"]["username"];
								$image_url = $js["data"][$i]["user"]["profile_picture"];
								//echo("user presente:<br />");
								//print_r($id_user);
								//echo("***<br /><br />");
							} else {
								// se non c'e' lo creo -->user_id
								//echo("content NON presente<br />");
								$nick = $js["data"][$i]["user"]["full_name"];
								$profile_url = "https://instagram.com/" . $js["data"][$i]["user"]["username"];
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

}//for $urlc


?>