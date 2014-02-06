<?php

//select nick from users where id_social=reply_to_user_id
$q_rel1 = $dbh->prepare("SELECT nick FROM users WHERE id_social=:id_social AND city=:w");
$q_rel1->bindParam(':id_social', $id_social1);
$q_rel1->bindParam(':w', $citycode);

//select * from content where id_social=reply_to_content_id
$q_rel2 = $dbh->prepare("SELECT * FROM content WHERE id_social=:id_social AND city=:w");
$q_rel2->bindParam(':id_social', $id_content_social1);
$q_rel2->bindParam(':w', $citycode);

//select * from content where c2.txt LIKE %MID(c1.txt_originale)%
$q_rel3 = $dbh->prepare("SELECT * FROM content WHERE txt LIKE :sub AND NOT id=:id_content AND city=:w");
$q_rel3->bindParam(':sub', $sub);
$q_rel3->bindParam(':id_content', $id_c);
$q_rel3->bindParam(':w', $citycode);

// aggiorna content set processed_relations=1
$q_rel4 = $dbh->prepare("UPDATE content SET processed_relations=1 WHERE id=:id_content ");
$q_rel4->bindParam(':id_content', $id_content);

//select * from relazioni where (nick1=nick1 and nick2=nick2) OR (nick1=nick2 AND nick2=nick1)
$q_rel5 = $dbh->prepare("SELECT * FROM relations WHERE city=:w AND ((nick1=:nick1 and nick2=:nick2) OR (nick1=:nick3 AND nick2=:nick4))");
$q_rel5->bindParam(':w', $citycode);
$q_rel5->bindParam(':nick1', $nick1);
$q_rel5->bindParam(':nick2', $nick2);
$q_rel5->bindParam(':nick3', $nick2);
$q_rel5->bindParam(':nick4', $nick1);

// update count +1
$q_rel6 = $dbh->prepare("UPDATE relations SET c=c+1 WHERE id=:id_rel");
$q_rel6->bindParam(':id_rel', $id_rel);

//insert new relazione
$q_rel7 = $dbh->prepare("INSERT INTO relations(nick1,nick2,c,city) VALUES (:nick1, :nick2, :c, :w)");
$q_rel7->bindParam(':nick1', $nick1);
$q_rel7->bindParam(':nick2', $nick2);
$q_rel7->bindParam(':c', $c);
$q_rel7->bindParam(':w', $citycode);

// users for relations
$q_users = $dbh->prepare("SELECT u.id as id, u.id_social as id_social, u.nick as nick, u.profile_url as profile_url, u.image_url as image_url, u.source as source, count(*) as c FROM content co, users u WHERE co.city=:w AND co.nick=u.nick GROUP BY u.profile_url order by c desc");
$q_users->bindParam(':w', $citycode);

// relations for relations
$q_rels = $dbh->prepare("SELECT c.nick as nick, u.id_social as id_social, c.reply_to_user_id as reply_to, u2.nick as reply_to_nick FROM users u, users u2, content c WHERE c.city=:w AND c.id_user=u.id AND c.reply_to_user_id=u2.id_social");
//$q_rels = $dbh->prepare("SELECT co1.nick as nick1, cc1.id_class as idclass, count(*) as c FROM content co1, content_to_class cc1 WHERE co1.id=cc1.id_content GROUP BY nick1, idclass");
$q_rels->bindParam(':w', $citycode);



// classes for time
$q_time = $dbh->prepare("SELECT u.image_url as image, co.id_social as ids, co.nick as nick, co.link as link, co.reply_to_user_id as ru, co.reply_to_content_id as rc, c.name as class, c.color as color FROM content co, classes c, users u, content_to_class cc WHERE co.city=:w AND u.id=co.id_user AND co.id=cc.id_content AND cc.id_class=c.id ORDER BY co.id DESC LIMIT 0,300");
$q_time->bindParam(':w', $citycode);

// classes for map
$q_classes = $dbh->prepare("SELECT DISTINCT name,color FROM classes WHERE city=:cccode");
$q_classes->bindParam(':cccode', $citycode);

// content for map
$q_map = $dbh->prepare("SELECT *, count(*) as c FROM (SELECT c.lat as lat, c.lng as lng, class.name as name FROM content c, content_to_class cc, classes class WHERE NOT c.lat=-1 AND NOT c.lat=999 AND c.city=:w AND c.id=cc.id_content AND class.id=cc.id_class ORDER BY c.id DESC LIMIT 0,500 ) a GROUP BY lat,lng");
$q_map->bindParam(':w', $citycode);

// controllo se c'e' content
$q_exist_content = $dbh->prepare("SELECT id FROM content WHERE id_social=:id_social");
$q_exist_content->bindParam(':id_social', $id_social);

// controllo se c'e' user
$q_exist_user = $dbh->prepare("SELECT id,nick,profile_url,image_url FROM users WHERE id_social=:user_id_social");
$q_exist_user->bindParam(':user_id_social', $user_id_social);

// insert user
$q_insert_user = $dbh->prepare("INSERT INTO users(id_social, nick, profile_url, image_url, source,city) VALUES (:user_id_social, :nick, :profile_url, :image_url, :source, :w)");
$q_insert_user->bindParam(':user_id_social', $user_id_social);
$q_insert_user->bindParam(':nick', $nick);
$q_insert_user->bindParam(':profile_url', $profile_url);
$q_insert_user->bindParam(':image_url', $image_url);
$q_insert_user->bindParam(':source', $source);
$q_insert_user->bindParam(':w', $citycode);

// insert content con user
$q_insert_content = $dbh->prepare("INSERT INTO content(id_social,id_user,nick,link,t,txt,lat,lng,source,reply_to_user_id,reply_to_content_id,city) VALUES (:content_id_social,:id_user,:nick,:link,NOW(),:txt,:lat,:lng,:source,:reply_to_user_id,:reply_to_content_id,:w)");
$q_insert_content->bindParam(':content_id_social', $content_id_social);
$q_insert_content->bindParam(':id_user', $id_user);
$q_insert_content->bindParam(':nick', $nick);
$q_insert_content->bindParam(':link', $content_url);
$q_insert_content->bindParam(':txt', $content_body);
$q_insert_content->bindParam(':lat', $currLat);
$q_insert_content->bindParam(':lng', $currLng);
$q_insert_content->bindParam(':source', $source);
$q_insert_content->bindParam(':reply_to_user_id', $reply_to_user_id);
$q_insert_content->bindParam(':reply_to_content_id', $reply_to_content_id);
$q_insert_content->bindParam(':w', $citycode);



// insert relations
$q_insert_relations = $dbh->prepare("INSERT INTO content_to_class(id_content,id_class,id_word,city) VALUES (:id_content,:id_class,:id_word,:w)");
$q_insert_relations->bindParam(':id_content', $id_content);
$q_insert_relations->bindParam(':id_class', $id_class);
$q_insert_relations->bindParam(':id_word', $id_word);
$q_insert_relations->bindParam(':w', $citycode);


// search location by id_social
$q_search_location = $dbh->prepare("SELECT id FROM locations WHERE id_social=:id_social");
$q_search_location->bindParam(':id_social', $id_social_location);

// insert location
$q_insert_location = $dbh->prepare("INSERT INTO locations(id_social,name,street,city,state,country,zip,lat,lng,main_category,citycity) VALUES (:id_social,:name,:street,:city,:state,:country,:zip,:lat,:lng,:main_category,:w)");
$q_insert_location->bindParam(':id_social', $id_social_location);
$q_insert_location->bindParam(':name', $name_location);
$q_insert_location->bindParam(':street', $street_location);
$q_insert_location->bindParam(':city', $city_location);
$q_insert_location->bindParam(':state', $state_location);
$q_insert_location->bindParam(':country', $country_location);
$q_insert_location->bindParam(':zip', $zip_location);
$q_insert_location->bindParam(':lat', $lat_location);
$q_insert_location->bindParam(':lng', $lng_location);
$q_insert_location->bindParam(':main_category', $main_category);
$q_insert_location->bindParam(':w', $citycode);

// search location category by id_social
$q_search_location_category = $dbh->prepare("SELECT id FROM location_categories WHERE id_social=:id_social");
$q_search_location_category->bindParam(':id_social', $id_social_location_category);

// insert category
$q_insert_category = $dbh->prepare("INSERT INTO location_categories(id_social,name) VALUES (:id_social,:name)");
$q_insert_category->bindParam(':id_social', $id_social_location_category);
$q_insert_category->bindParam(':name', $name_category);


// search category of location
$q_search_category_of_location = $dbh->prepare("SELECT id FROM category_of_location WHERE id_category=:id_category AND id_location=:id_location");
$q_search_category_of_location->bindParam(':id_category', $id_category);
$q_search_category_of_location->bindParam(':id_location', $id_location);

// insert category of location
$q_insert_category_of_location = $dbh->prepare("INSERT INTO category_of_location(id_category,id_location,city) VALUES (:id_category,:id_location,:w)");
$q_insert_category_of_location->bindParam(':id_category', $id_category);
$q_insert_category_of_location->bindParam(':id_location', $id_location);
$q_insert_category_of_location->bindParam(':w', $citycode);


?>