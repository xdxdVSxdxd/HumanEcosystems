<?php

//select nick from users where id_social=reply_to_user_id
$q_rel1 = $dbh->prepare("SELECT nick FROM users WHERE id_social=:id_social AND research=:w");
$q_rel1->bindParam(':id_social', $id_social1);
$q_rel1->bindParam(':w', $research_code);

//select * from content where id_social=reply_to_content_id
$q_rel2 = $dbh->prepare("SELECT * FROM content WHERE id_social=:id_social AND research=:w");
$q_rel2->bindParam(':id_social', $id_content_social1);
$q_rel2->bindParam(':w', $research_code);

//select * from content where c2.txt LIKE %MID(c1.txt_originale)%
$q_rel3 = $dbh->prepare("SELECT * FROM content WHERE txt LIKE :sub AND NOT id=:id_content AND research=:w");
$q_rel3->bindParam(':sub', $sub);
$q_rel3->bindParam(':id_content', $id_c);
$q_rel3->bindParam(':w', $research_code);

// aggiorna content set processed_relations=1
$q_rel4 = $dbh->prepare("UPDATE content SET processed_relations=1 WHERE id=:id_content ");
$q_rel4->bindParam(':id_content', $id_content);

//select * from relazioni where (nick1=nick1 and nick2=nick2) OR (nick1=nick2 AND nick2=nick1)
$q_rel5 = $dbh->prepare("SELECT * FROM relations WHERE research=:w AND ((nick1=:nick1 and nick2=:nick2) OR (nick1=:nick3 AND nick2=:nick4))");
$q_rel5->bindParam(':w', $research_code);
$q_rel5->bindParam(':nick1', $nick1);
$q_rel5->bindParam(':nick2', $nick2);
$q_rel5->bindParam(':nick3', $nick2);
$q_rel5->bindParam(':nick4', $nick1);

// update count +1
$q_rel6 = $dbh->prepare("UPDATE relations SET c=c+1 WHERE id=:id_rel");
$q_rel6->bindParam(':id_rel', $id_rel);

//insert new relazione
$q_rel7 = $dbh->prepare("INSERT INTO relations(nick1,nick2,c,research) VALUES (:nick1, :nick2, :c, :w)");
$q_rel7->bindParam(':nick1', $nick1);
$q_rel7->bindParam(':nick2', $nick2);
$q_rel7->bindParam(':c', $c);
$q_rel7->bindParam(':w', $research_code);

// users for relations
//$q_users = $dbh->prepare("SELECT u.id as id, u.id_social as id_social, u.nick as nick, u.profile_url as profile_url, u.image_url as image_url, u.source as source, count(*) as c FROM content co, users u WHERE u.research=:w AND co.nick=u.nick GROUP BY u.nick order by c desc LIMIT 0,3000");
//$q_users = $dbh->prepare("SELECT u.id as id, u.id_social as id_social, u.nick as nick, u.profile_url as profile_url, u.image_url as image_url, u.source as source, count(*) as c FROM content co, users u WHERE u.research=:w AND co.nick=u.nick AND co.t>DATE_SUB(NOW(), INTERVAL 2 WEEK) GROUP BY u.nick order by c desc");
$q_users = $dbh->prepare("SELECT u.id as id, u.id_social as id_social, u.nick as nick, u.profile_url as profile_url, u.image_url as image_url, u.source as source, count(*) as c FROM content co, users u WHERE u.research=:w AND co.nick=u.nick GROUP BY u.nick order by c desc LIMIT 0,3000");
$q_users->bindParam(':w', $research_code);

// relations for relations
//$q_rels = $dbh->prepare("SELECT u.nick as nick, u.id_social as id_social, u2.id_social as reply_to, u2.nick as reply_to_nick FROM users u, users u2, relations c WHERE c.research=:w AND c.nick1=u.nick AND c.nick2=u2.nick");
$q_rels = $dbh->prepare("SELECT c.nick as nick, u.id_social as id_social, c.reply_to_user_id as reply_to, u2.nick as reply_to_nick FROM users u, users u2, content c WHERE c.research=:w AND c.id_user=u.id AND c.reply_to_user_id=u2.id_social");
//$q_rels = $dbh->prepare("SELECT co1.nick as nick1, cc1.id_class as idclass, count(*) as c FROM content co1, content_to_class cc1 WHERE co1.id=cc1.id_content GROUP BY nick1, idclass");
$q_rels->bindParam(':w', $research_code);



// classes for time
$q_time = $dbh->prepare("SELECT u.image_url as image, co.id_social as ids, co.nick as nick, co.link as link, co.reply_to_user_id as ru, co.reply_to_content_id as rc, c.name as class, c.color as color FROM content co, classes c, users u, content_to_class cc WHERE co.research=:w AND u.id=co.id_user AND co.id=cc.id_content AND cc.id_class=c.id ORDER BY co.id DESC LIMIT 0,300");
$q_time->bindParam(':w', $research_code);

// classes for map
$q_classes = $dbh->prepare("SELECT DISTINCT name,color FROM classes WHERE research=:cccode");
$q_classes->bindParam(':cccode', $research_code);

// content for map
$q_map = $dbh->prepare("SELECT *, count(*) as c FROM (SELECT c.lat as lat, c.lng as lng, class.name as name FROM content c, content_to_class cc, classes class WHERE NOT c.lat=-1 AND NOT c.lat=999 AND c.research=:w AND c.id=cc.id_content AND class.id=cc.id_class ORDER BY c.id DESC LIMIT 0,500 ) a GROUP BY lat,lng");
$q_map->bindParam(':w', $research_code);

// controllo se c'e' content
$q_exist_content = $dbh->prepare("SELECT id FROM content WHERE id_social=:id_social");
$q_exist_content->bindParam(':id_social', $id_social);

// controllo se c'e' user
$q_exist_user = $dbh->prepare("SELECT id,nick,profile_url,image_url FROM users WHERE id_social=:user_id_social");
$q_exist_user->bindParam(':user_id_social', $user_id_social);

// insert user
$q_insert_user = $dbh->prepare("INSERT INTO users(id_social, nick, profile_url, image_url, source,research) VALUES (:user_id_social, :nick, :profile_url, :image_url, :source, :w)");
$q_insert_user->bindParam(':user_id_social', $user_id_social);
$q_insert_user->bindParam(':nick', $nick);
$q_insert_user->bindParam(':profile_url', $profile_url);
$q_insert_user->bindParam(':image_url', $image_url);
$q_insert_user->bindParam(':source', $source);
$q_insert_user->bindParam(':w', $research_code);

// insert content con user
$q_insert_content = $dbh->prepare("INSERT INTO content(id_social,language,id_user,nick,link,t,txt,lat,lng,source,research,reply_to_user_id,reply_to_content_id) VALUES (:content_id_social,:language,:id_user,:nick,:link,NOW(),:txt,:lat,:lng,:source,:w,:reply_to_user_id,:reply_to_content_id)");
$q_insert_content->bindParam(':content_id_social', $content_id_social);
$q_insert_content->bindParam(':language', $language);
$q_insert_content->bindParam(':id_user', $id_user);
$q_insert_content->bindParam(':nick', $nick);
$q_insert_content->bindParam(':link', $content_url);
$q_insert_content->bindParam(':txt', $content_body);
$q_insert_content->bindParam(':lat', $currLat);
$q_insert_content->bindParam(':lng', $currLng);
$q_insert_content->bindParam(':source', $source);
$q_insert_content->bindParam(':w', $research_code);
$q_insert_content->bindParam(':reply_to_user_id', $reply_to_user_id);
$q_insert_content->bindParam(':reply_to_content_id', $reply_to_content_id);



// insert relations
$q_insert_relations = $dbh->prepare("INSERT INTO content_to_class(id_content,id_class,id_word,research) VALUES (:id_content,:id_class,:id_word,:w)");
$q_insert_relations->bindParam(':id_content', $id_content);
$q_insert_relations->bindParam(':id_class', $id_class);
$q_insert_relations->bindParam(':id_word', $id_word);
$q_insert_relations->bindParam(':w', $research_code);



// query for timeline
$q_extract_timeline = $dbh->prepare("SELECT YEAR(t) as y , MONTH(t) as mo, DAY(t) as d, HOUR(t) as h, count(*) as c FROM (SELECT * FROM content WHERE research=:w AND t>DATE_SUB(NOW(),INTERVAL 2 DAY) ORDER BY t DESC ) a GROUP BY YEAR(t), MONTH(t), DAY(t), HOUR(t) ORDER BY y,mo,d,h");
$q_extract_timeline->bindParam(':w', $research_code);


$q_extract_timeline_class = $dbh->prepare("SELECT YEAR(t) as y , MONTH(t) as mo, DAY(t) as d, HOUR(t) as h, count(*) as c FROM (SELECT content.* FROM content, content_to_class WHERE content.research=:w AND content.t>DATE_SUB(NOW(),INTERVAL 2 DAY) AND content_to_class.id_content=content.id AND content_to_class.id_class=:c ORDER BY t DESC ) a GROUP BY YEAR(t), MONTH(t), DAY(t), HOUR(t) ORDER BY y,mo,d,h");
$q_extract_timeline_class->bindParam(':w', $research_code);
$q_extract_timeline_class->bindParam(':c', $classfilter);

?>