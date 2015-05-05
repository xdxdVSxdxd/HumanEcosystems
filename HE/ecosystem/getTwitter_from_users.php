<?php

require_once('db.php');
require_once('getWords.php');
require_once('prepareStatements.php');
require_once ('codebird.php');


$source = "TWIT";
	

\Codebird\Codebird::setConsumerKey('QItNKKw9TguAgnHyKVG11Q', '3J3kgnnymIYAsOCMSas4TyKPPFrzsdgc5zkNL67fEsU'); // static, see 'Using multiple Codebird instances'

$cb = \Codebird\Codebird::getInstance();

$cb->setToken('15755206-ubKqRLYyJNUMLkSpRhBW6NAv7EoKqCpYv3X0ugSOA', 'UZZylp1eLFlWJK3PkQt8Rg7A6oRi6frFBdKjEre0fw');
 

/*
$reply = $cb->oauth2_token();
$bearer_token = $reply->access_token;

echo($bearer_token);
*/


\Codebird\Codebird::setBearerToken('AAAAAAAAAAAAAAAAAAAAALtcTAAAAAAAyuGXkNaQLQptKoE6WRumvuhVSOg%3DhO2N7Nq84J56rEP9uHBr2RfRmDbq0jQ4E46KhQfg');


$q1 = "SELECT id_social FROM " . $prefix . "users WHERE processuser=1 AND city=" . $dbh->quote($citycode) . " ORDER BY RAND() LIMIT 0,1";

//echo($q1 . "<br /><br />");

$stat = $dbh->query($q1);
if($stat){
	foreach ( $stat as $rooo) {


$useridsocial = $rooo["id_social"];

$query = "user_id=" . $useridsocial . "&result_type=recent&count=100";
 
 //echo($query . "<br /><br />");

$result = $cb->statuses_userTimeline($query, true);


if(isset($result) && $result!=""){
	$js = $result; //json_decode($result,true);
					
	//print_r($js);	
	//echo("<br /><br />" . "<br /><br />");


	if($js->statuses && is_array($js->statuses) && count($js->statuses)>0){

	foreach ($js->statuses as $status) {
		$holdFor = array();
		//echo("Text:" . $status->text . "<br /><br />");
		foreach ($words as $w) {

			if($w["word"]=="*"){
				$h = array();
				$h["idc"] = $w["id_class"];
				$h["idw"] = $w["id_word"];
				$holdFor[] = $h;
			}
			else if( $status->text ){
				//if( strpos(  strtoupper( $status["caption"]["text"] )   ,   strtoupper(  " " . $w["word"] )     ) !== false  ){

				if(  preg_match(   "/\b" . strtoupper(  " " . $w["word"] ) . "\b/"    , strtoupper( $status->text )   )     ){
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
							$reply_to_content_id = $status->n_reply_to_status_id_str;
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
	}


}//if(isset($fc) && $fc!=""){


}
$stat->closeCursor();
}



/*

		echo '<script type="text/javascript">';
        echo 'window.location.href="http://artisopensource.net/emc1/getTwitter.php";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url=http://artisopensource.net/emc1/getTwitter.php" />';
        echo '</noscript>';
*/



?>