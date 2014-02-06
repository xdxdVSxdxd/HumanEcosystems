<?php


require_once('db.php');
require_once('getWords.php');
require_once('prepareStatements.php');

require_once("facebook.php");

$config = array();
$config['appId'] = 'APP ID';
$config['secret'] = 'APP Secret';
$config['cookie'] = true;

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

/*
$fql = "SELECT 
            name, pic, start_time, end_time, location, description 
        FROM 
            event 
        WHERE 
            eid IN ( SELECT eid FROM event_member WHERE uid = " . $facebook->getUser() . " ) 
        ORDER BY 
            start_time desc";

echo($fql);
*/

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
					"/search?type=place&center=" . $mainLat . ',' . $mainLng . "&distance=5000&limit=100&access_token=" . $access_token
					
                    /*
					array(
                         'method' => '/search',
                         'type' => 'place',
                         'center' => '' . $mainLat . ',' . $mainLng,
                         'distance' => '5000'
                     )
                     */
                     
					);

//print_r($ret);

$i = 0;

while($ret!=0 && $i<20){


    foreach ($ret["data"] as $place) {
        
        try
        {
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $dbh->beginTransaction();        
    
            $id_location;
            $id_social_location = $place["id"];
            $name_location = $place["name"];
            $street_location = $place["location"]["street"];
            $city_location = $place["location"]["city"];
            $state_location = $place["location"]["state"];
            $country_location = $place["location"]["country"];
            $zip_location = $place["location"]["zip"];
            $lat_location = $place["location"]["latitude"];
            $lng_location = $place["location"]["longitude"];
            $main_category = $place["category"];
            if ($q_search_location->execute()){
                if($r1 = $q_search_location->fetch()){
                    $id_location = $r1["id"];
                }//if($r1 = $q_exist_user->fetch())
                else {
                    $q_insert_location->execute();
                    $id_location = $dbh->lastInsertId();
                }// else di if($r1 = $q_exist_user->fetch())
            }//if ($q_search_location->execute())

            foreach ($place["category_list"] as $categories) {
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
            echo "Failed: " . $e->getMessage();
        }//try

    }//foreach ($ret->data as $place) 


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
}//while($ret!=0 && $i<20)
    

?>