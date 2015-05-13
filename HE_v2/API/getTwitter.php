<?php

require_once('db.php');
require_once('getWords.php');
require_once ('codebird.php');


$source = "TWIT";
	

	\Codebird\Codebird::setConsumerKey($tw_consumer_key, $tw_consumer_secret);

	$cb = \Codebird\Codebird::getInstance();

	$cb->setToken($tw_token, $tw_token_secret); 


	\Codebird\Codebird::setBearerToken($tw_bearer_token);



$query = "geocode=" . $mainLat . "," . $mainLng . ",6km&result_type=recent&count=100";
 

if($mainLng==999 && $mainLng==999 && $words[0]["word"]!="*"){

	$qq = "";
	for($i=0 ; $i<count($words) ; $i++){
		$qq = $qq . $words[$i]["word"];
		if($i<count($words)-1){
			$qq = $qq . " OR ";
		}
	}

	$query = "q=" . $qq . "&result_type=recent&count=100";
} else if($mainLng==999 && $mainLng==999 && $words[0]["word"]=="*"){
	$query = "q=" . $citycode . "&result_type=recent&count=100";
}


$result = $cb->search_tweets($query, true);


if(isset($result) && $result!=""){
	$js = $result; //json_decode($result,true);

	foreach ($js->statuses as $status) {
		$holdFor = array();
		foreach ($words as $w) {
			if($w["word"]=="*"){
				$h = array();
				$h["idc"] = $w["id_class"];
				$h["idw"] = $w["id_word"];
				$holdFor[] = $h;
			}
			else if( $status->text ){
				if(  preg_match(   "/\b" . strtoupper(  "" . $w["word"] ) . "\b/"    , strtoupper( $status->text )   )     ){
					$h = array();
					$h["idc"] = $w["id_class"];
					$h["idw"] = $w["id_word"];
					$holdFor[] = $h;
				}
			}
		}//foreach ($words as $w) {

		if(count($holdFor)>0){

			try
			{
  				$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$dbh->beginTransaction();

				// controllo se il content e' presente
				$id_social = $status->id;
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
						$user_id_social = $status->user->id_str;
						$language = "";
						if(isset($status->metadata) && isset($status->metadata->iso_language_code)){
							$language = $status->metadata->iso_language_code;
						} else if (isset($status->lang)){
							$language = $status->lang;
						}
						if ($q_exist_user->execute()){
							if($r2 = $q_exist_user->fetch()){
								// c'e' gia'
								$id_user = $r2["id"];
								$nick = $status->user->screen_name;
								$profile_url = "https://twitter.com/" . $status->user->screen_name;
								$image_url = $status->user->profile_image_url;
								//echo("user presente:<br />");
								//print_r($id_user);
								//echo("***<br /><br />");
							} else {
								// se non c'e' lo creo -->user_id
								//echo("user NON presente<br />");
								$nick = $status->user->screen_name;
								$profile_url = "https://twitter.com/" . $status->user->screen_name;
								$image_url = $status->user->profile_image_url;
								//echo("nick:" . $nick . "<br />");
								//echo("profile_url:" . $profile_url . "<br />");
								//echo("image_url:" . $image_url . "<br />");
								//echo("source:" . $source . "<br />");
								//echo("user_id_social:" . $user_id_social . "<br />");
								$q_insert_user->execute();
								$id_user = $dbh->lastInsertId();
								//echo("user inserito:<br />");
								//print_r($id_user);
								//echo("***<br /><br />");
							}// else di if($r2 = $q_exist_user->fetch()){
						}//if ($q_exist_user->execute()){
						//		memorizzo il content con user_id
						$content_id_social = $status->id_str;
						$content_url = "https://twitter.com/" . $status->user->screen_name . "/statuses/" . $status->id_str;
						$content_body = $status->text;
						$reply_to_user_id = "-1";
						$reply_to_content_id = "-1";
						if($status->in_reply_to_status_id_str){
							$reply_to_content_id = $status->in_reply_to_status_id_str;
						}
						if($status->in_reply_to_user_id_str){
							$reply_to_user_id = $status->in_reply_to_user_id_str;
						}
						$currLat = 999;
						$currLng = 999;
						if($status->geo && $status->geo->coordinates ){
							$currLat = $status->geo->coordinates[0];
							$currLng = $status->geo->coordinates[1];
						}
						$q_insert_content->execute();
						$id_content = $dbh->lastInsertId();
						//echo("content inserito:" . $content_body . "<br />");
						//print_r($id_content);
						//echo("***<br /><br />");
						//		memorizzo le relazioni con le keyword


						if($status->entities){
							
							if($status->entities->user_mentions){
								foreach ($status->entities->user_mentions as  $mention ) {
									
									$nick1 = $status->user->screen_name;
									$nick2 = $mention->screen_name;

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

								}
							}

						}//if($status->entities){

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



	}//for($i = 0; $i<count($js["statuses"]);$i++){
	


}//if(isset($fc) && $fc!=""){


?>