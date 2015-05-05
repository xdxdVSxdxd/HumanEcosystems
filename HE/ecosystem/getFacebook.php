<?php


require_once('db.php');
require_once('getWords.php');
require_once('prepareStatements.php');

require_once("facebook.php");

$config = array();
$config['appId'] = '430384557078554';
$config['secret'] = '1aa3cdd537c589de7a24c637e4b4bd0e';
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



//https://graph.facebook.com/search?type=event&center=41.8947400,12.4839000&distance=5000&access_token=

//$events = 'SELECT pic_big, name, venue, location, start_time, eid FROM event WHERE eid IN (SELECT eid FROM event_member WHERE uid IN (SELECT uid2 FROM friend WHERE uid1 = me()) AND start_time > '. $created_time .' OR uid = me()) AND start_time > '. $created_time .' AND venue.longitude < \''. ($long+$offset) .'\' AND venue.latitude < \''. ($lat+$offset) .'\' AND venue.longitude > \''. ($long-$offset) .'\' AND venue.latitude > \''. ($lat-$offset) .'\' ORDER BY start_time ASC '. $limit;

$fql = "SELECT 
            name, pic, start_time, end_time, location, description 
        FROM 
            event 
        WHERE 
            eid IN ( SELECT eid FROM event_member WHERE uid = " . $facebook->getUser() . " ) 
        ORDER BY 
            start_time desc";

//echo($fql);

$ret = $facebook->api(


					/*
                    array(
						'method'    => 'fql.query',
						'query'     => $fql,
						'callback'  => ''
					)
                    */
					//"SELECT eid, host, location, name, start_time, venue FROM event WHERE NOT name=''" 
					//"SELECT eid FROM event_member WHERE uid IN (SELECT page_id FROM place WHERE distance(latitude, longitude, " . $mainLat . ',' . $mainLng . ") < 50000)"
					//"/search?q=Roma%20&type=event&center=" . $mainLat . ',' . $mainLng . "&distance=5000&access_token=" . $access_token
                    "/search?q=" . $cityname . "%20&type=event&access_token=" . $access_token
					/*
					array(
                         'method' => '/search',
                         'type' => 'event',
                         'center' => '' . $mainLat . ',' . $mainLng,
                         'distance' => '5000'
                     )
                     */
					);

//print_r($ret);

$i=0;

while ($i<20 && $ret!=0) {

    foreach ($ret["data"] as $e) {
        $evento = $facebook->api("/" . $e["id"]);
        //print_r($evento);
        //echo("\n\n\n<br /><br /><br /><br />");

        if( strtoupper( $evento["venue"]["city"] ) == strtoupper($cityname) ){


            // aggiungo venue
            $venue = $facebook->api("/" . $evento["venue"]["id"]);


            try
            {
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $dbh->beginTransaction(); 


                $language = "";

                $id_location;
                $id_social_location = $venue["id"];
                $name_location = $venue["name"];
                $street_location = $venue["location"]["street"];
                $city_location = $venue["location"]["city"];
                $state_location = $venue["location"]["state"];
                $country_location = $venue["location"]["country"];
                $zip_location = $venue["location"]["zip"];
                $lat_location = $venue["location"]["latitude"];
                $lng_location = $venue["location"]["longitude"];
                $main_category = $venue["category"];
                if ($q_search_location->execute()){
                    if($r1 = $q_search_location->fetch()){
                        $id_location = $r1["id"];
                    }//if($r1 = $q_exist_user->fetch())
                    else {
                        $q_insert_location->execute();
                        $id_location = $dbh->lastInsertId();
                    }// else di if($r1 = $q_exist_user->fetch())
                }//if ($q_search_location->execute())

                foreach ($venue["category_list"] as $categories) {
                    $id_social_location_category = $categories["id"];
                    $name_category = $categories["name"];
                    $id_category;
                    if ($q_search_location_category->execute()){
                        if($r2 = $q_search_location_category->fetch()){
                            $id_category = $r2["id"];
                        }//if($r2 = $q_search_location_category->fetch())
                        else {
                            $q_insert_category->execute();
                            $id_category = $dbh->lastInsertId();
                        }// else di if($r2 = $q_search_location_category->fetch())
                    }//if ($q_search_location->execute())

                    if ($q_search_category_of_location->execute()){
                        if($r2 = $q_search_category_of_location->fetch()){
                            //ok, c'e'
                        }//if($r2 = $q_search_category_of_location->fetch())
                        else {
                            $q_insert_category_of_location->execute();
                        }// else di if($r2 = $q_search_category_of_location->fetch())
                    }//if ($q_search_category_of_location->execute())


                }//foreach ($place->category_list as $categories)



                $dbh->commit();

            } catch (Exception $e) {
                $dbh->rollBack();
                //echo "Failed: " . $e->getMessage();
            }//try


            // aggiungo user FB

            $user = $facebook->api("/" . $evento["owner"]["id"]);
            $id_user;

            try
            {
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $dbh->beginTransaction();

                
                $user_id_social = $evento["owner"]["id"];
                if ($q_exist_user->execute()){
                    if($r2 = $q_exist_user->fetch()){
                        // c'e' gia'
                        $id_user = $r2["id"];
                        $nick = $r2["nick"];
                        $profile_url = $r2["profile_url"];
                        $image_url = $r2["image_url"];
                    } else {
                        // se non c'e' lo creo -->user_id
                        $nick = $user["name"];
                        $profile_url = $user["link"];
                        $image_url = "http://graph.facebook.com/" . $user["username"] . "/picture";
                        $q_insert_user->execute();
                        $id_user = $dbh->lastInsertId();
                    }// else di if($r2 = $q_exist_user->fetch()){
                }//if ($q_exist_user->execute()){


                $dbh->commit();

            } catch (Exception $e) {
                $dbh->rollBack();
                //echo "Failed: " . $e->getMessage();
            }//try




            // aggiungo content FB
            try
            {
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $dbh->beginTransaction();

                $id_content;
                $content_id_social = $evento["id"];
                $id_social = $evento["id"];
                if ($q_exist_content->execute()){
                    if($r2 = $q_exist_content->fetch()){
                        // c'e' gia'
                    } else {
                        // se non c'e' lo creo -->user_id
                        $nick = $user["name"];
                        $content_url = "https://www.facebook.com/" . $evento["id"];
                        $content_body = $evento["name"] . " | " . $evento["description"];
                        $currLat = $venue["location"]["latitude"];
                        $currLng = $venue["location"]["longitude"];
                        $reply_to_user_id = -1;
                        $reply_to_content_id = -1;
                        $q_insert_content->execute();
                        $id_content = $dbh->lastInsertId();


                        $holdFor = array();

                        foreach ($words as $w) {
                    
                    
                                if($w["word"]=="*"){
                                    $h = array();
                                    $h["idc"] = $w["id_class"];
                                    $h["idw"] = $w["id_word"];
                                    $holdFor[] = $h;
                                }
                                else if(  preg_match(   "/\b" . strtoupper(  " " . $w["word"] ) . "\b/"    , strtoupper( $content_body )   )     ){
                                    $h = array();
                                    $h["idc"] = $w["id_class"];
                                    $h["idw"] = $w["id_word"];
                                    $holdFor[] = $h;
                                }
                    

                        }//foreach ($words as $w) {

                        if(count($holdFor)>0){
                            foreach ($holdFor as $ho) {
                                $id_class = $ho["idc"];
                                $id_word = $ho["idw"];
                                $q_insert_relations->execute();
                            }
                        }



                    }// else di if($r2 = $q_exist_user->fetch()){
                }//if ($q_exist_user->execute()){


                $dbh->commit();

            } catch (Exception $e) {
                $dbh->rollBack();
                //echo "Failed: " . $e->getMessage();
            }//try

        }

    }


    $i++;
    if($ret["paging"]["next"]){
        //echo("next page = <br />" . $ret["paging"]["next"] . "<br />");
        $rets = file_get_contents($ret["paging"]["next"]);
        $ret = json_decode($rets, TRUE);
        //print_r($ret);
        //echo("<br /><br /><br />");
    } else {
        $ret = 0;
    }


} //while($i<20 && $ret!=0)

?>