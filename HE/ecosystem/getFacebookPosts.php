<?php


require_once('db.php');
require_once('getWords.php');
require_once('prepareStatements.php');

require_once("facebook.php");

$config = array();
$config['appId'] = 'APP ID';
$config['secret'] = 'APP SECRET';
$config['cookie'] = true;

$source = "FB";

$facebook = new Facebook($config);
$access_token = $facebook->getAccessToken();
$user = $facebook->getUser();

//echo( $access_token . "<br /><br />");
//echo( $user . "<br /><br />");


if(!$facebook->getUser())
{
		//echo("[2]");
		$u = "Location:{$facebook->getLoginUrl(array(‘req_perms’ => ‘user_status,publish_stream,user_photos’))}";
		//echo($u);
        header($u);
        
        exit;
}


foreach ($words as $w) {

    echo("***********searching for : " . $w["word"] . "\n\n<br /><br />\n");
    $ret = $facebook->api("/search?q=" . $w["word"] . "%20" . $location . "&type=post&access_token=" . $access_token);
    //print_r($ret);

    foreach ($ret["data"] as $post) {
        
        

        if(  preg_match(   "/\b" . strtoupper(  " " . $location ) . "\b/"    , strtoupper( $post["message"] )   )     ){

                    //print_r($post);

                    //echo("getting user: " . "/" . $post["from"]["id"] . "<br />");
                    $user = $facebook->api("/" . $post["from"]["id"]);
                    $user_id_social = $post["from"]["id"];
                    $nick = $post["from"]["name"];
                    $id_user;

                        try
                        {
                            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $dbh->beginTransaction();

                            if ($q_exist_user->execute()){
                                if($r2 = $q_exist_user->fetch()){
                                    // c'e' gia'
                                    $id_user = $r2["id"];
                                    $nick = $r2["nick"];
                                    $profile_url = $r2["profile_url"];
                                    $image_url = $r2["image_url"];
                                } else {
                                    // se non c'e' lo creo -->user_id
                                    $profile_url = $user["link"];
                                    $image_url = "http://graph.facebook.com/" . $user["username"] . "/picture";
                                    $q_insert_user->execute();
                                    $id_user = $dbh->lastInsertId();
                                }// else di if($r2 = $q_exist_user->fetch()){
                            }//if ($q_exist_user->execute()){


                            $id_content;
                            $content_id_social = $post["id"];
                            $id_social = $post["id"];
                            if ($q_exist_content->execute()){
                                if($r2 = $q_exist_content->fetch()){
                                    // c'e' gia'
                                } else {
                                    // se non c'e' lo creo -->user_id
                                    $nick = $user["name"];
                                    $content_url = "https://www.facebook.com/" . $post["id"];
                                    $content_body = $post["message"];
                                    $currLat = -1;
                                    $currLng = -1;
                                    $reply_to_user_id = -1;
                                    $reply_to_content_id = -1;
                                    $q_insert_content->execute();
                                    $id_content = $dbh->lastInsertId();

                                    $id_class = $w["id_class"];
                                    $id_word = $w["id_word"];
                                    $q_insert_relations->execute();

                                }// else di if($r2 = $q_exist_user->fetch()){
                            }//if ($q_exist_user->execute())

                            echo("immesso content:" . $content_id_social . " di user:" . $user_id_social . "<br /><br /><br />");


                            $dbh->commit();
                        } catch (Exception $e) {
                            $dbh->rollBack();
                            //echo "Failed: " . $e->getMessage();
                        }//try
            } // if(  preg_match(   "/\b" . strtoupper(  " " . $location ) . "\b/"    , strtoupper( $post["message"] )   )     )

    }//foreach ($ret as $post) 



}//foreach ($words as $w) 


?>