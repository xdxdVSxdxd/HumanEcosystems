<?php

	ini_set('memory_limit', '5120M');
	set_time_limit ( 0 );

	$colors = array();
	$colors[] = "0xFF0000";
	$colors[] = "0x00FF00";
	$colors[] = "0x0000FF";
	$colors[] = "0xFFFF00";
	$colors[] = "0xFF00FF";
	$colors[] = "0x00FFFF";
	$colors[] = "0xFF8000";
	$colors[] = "0xFF0080";
	$colors[] = "0x80FF00";
	$colors[] = "0x00FF80";
	$colors[] = "0x8000FF";
	$colors[] = "0x0080FF";
	$colors[] = "0x808000";
	$colors[] = "0x800080";
	$colors[] = "0x008080";

	// functions to parse sql schema file


	//
	// remove_comments will strip the sql comment lines out of an uploaded sql file
	// specifically for mssql and postgres type files in the install....
	//
	function remove_comments(&$output)
	{
	   $lines = explode("\n", $output);
	   $output = "";

	   // try to keep mem. use down
	   $linecount = count($lines);

	   $in_comment = false;
	   for($i = 0; $i < $linecount; $i++)
	   {
	      if( preg_match("/^\/\*/", preg_quote($lines[$i])) )
	      {
	         $in_comment = true;
	      }

	      if( !$in_comment )
	      {
	         $output .= $lines[$i] . "\n";
	      }

	      if( preg_match("/\*\/$/", preg_quote($lines[$i])) )
	      {
	         $in_comment = false;
	      }
	   }

	   unset($lines);
	   return $output;
	}

	//
	// remove_remarks will strip the sql comment lines out of an uploaded sql file
	//
	function remove_remarks($sql)
	{
	   $lines = explode("\n", $sql);

	   // try to keep mem. use down
	   $sql = "";

	   $linecount = count($lines);
	   $output = "";

	   for ($i = 0; $i < $linecount; $i++)
	   {
	      if (($i != ($linecount - 1)) || (strlen($lines[$i]) > 0))
	      {
	         if (isset($lines[$i][0]) && $lines[$i][0] != "#")
	         {
	            $output .= $lines[$i] . "\n";
	         }
	         else
	         {
	            $output .= "\n";
	         }
	         // Trading a bit of speed for lower mem. use here.
	         $lines[$i] = "";
	      }
	   }

	   return $output;

	}

	//
	// split_sql_file will split an uploaded sql file into single sql statements.
	// Note: expects trim() to have already been run on $sql.
	//
	function split_sql_file($sql, $delimiter)
	{
	   // Split up our string into "possible" SQL statements.
	   $tokens = explode($delimiter, $sql);

	   // try to save mem.
	   $sql = "";
	   $output = array();

	   // we don't actually care about the matches preg gives us.
	   $matches = array();

	   // this is faster than calling count($oktens) every time thru the loop.
	   $token_count = count($tokens);
	   for ($i = 0; $i < $token_count; $i++)
	   {
	      // Don't wanna add an empty string as the last thing in the array.
	      if (($i != ($token_count - 1)) || (strlen($tokens[$i] > 0)))
	      {
	         // This is the total number of single quotes in the token.
	         $total_quotes = preg_match_all("/'/", $tokens[$i], $matches);
	         // Counts single quotes that are preceded by an odd number of backslashes,
	         // which means they're escaped quotes.
	         $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$i], $matches);

	         $unescaped_quotes = $total_quotes - $escaped_quotes;

	         // If the number of unescaped quotes is even, then the delimiter did NOT occur inside a string literal.
	         if (($unescaped_quotes % 2) == 0)
	         {
	            // It's a complete sql statement.
	            $output[] = $tokens[$i];
	            // save memory.
	            $tokens[$i] = "";
	         }
	         else
	         {
	            // incomplete sql statement. keep adding tokens until we have a complete one.
	            // $temp will hold what we have so far.
	            $temp = $tokens[$i] . $delimiter;
	            // save memory..
	            $tokens[$i] = "";

	            // Do we have a complete statement yet?
	            $complete_stmt = false;

	            for ($j = $i + 1; (!$complete_stmt && ($j < $token_count)); $j++)
	            {
	               // This is the total number of single quotes in the token.
	               $total_quotes = preg_match_all("/'/", $tokens[$j], $matches);
	               // Counts single quotes that are preceded by an odd number of backslashes,
	               // which means they're escaped quotes.
	               $escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$j], $matches);

	               $unescaped_quotes = $total_quotes - $escaped_quotes;

	               if (($unescaped_quotes % 2) == 1)
	               {
	                  // odd number of unescaped quotes. In combination with the previous incomplete
	                  // statement(s), we now have a complete statement. (2 odds always make an even)
	                  $output[] = $temp . $tokens[$j];

	                  // save memory.
	                  $tokens[$j] = "";
	                  $temp = "";

	                  // exit the loop.
	                  $complete_stmt = true;
	                  // make sure the outer loop continues at the right point.
	                  $i = $j;
	               }
	               else
	               {
	                  // even number of unescaped quotes. We still don't have a complete statement.
	                  // (1 odd and 1 even always make an odd)
	                  $temp .= $tokens[$j] . $delimiter;
	                  // save memory.
	                  $tokens[$j] = "";
	               }

	            } // for..
	         } // else
	      }
	   }

	   return $output;
	}




	function getHtml($url, $post = null) {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	    if(!empty($post)) {
	        curl_setopt($ch, CURLOPT_POST, true);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	    } 
	    $result = curl_exec($ch);
	    curl_close($ch);
	    return $result;
	}

	// functions to parse sql schema file - END






	// get parameters from config file

	echo("[reading configuration file]<br />");
	$configurations = parse_ini_file("config_template.txt");

	// uncomment for debug
	print_r($configurations);



	// create database structure

	echo("[reading database schema]<br />");
	$dbms_schema = 'database-schema/schema.sql';

	$sql_query = @fread(@fopen($dbms_schema, 'r'), @filesize($dbms_schema)) or die('problem in opening SQL File');
	$sql_query = remove_remarks($sql_query);
	$sql_query = split_sql_file($sql_query, ';');

	$host = $configurations["db-host"];
	$user = $configurations["db-user"];
	$pass = $configurations["db-password"];
	$db = $configurations["db-name"];

	$dbh = null;

		try {
		  $dbh = new PDO(
		  					'mysql:host=' . $host . ';dbname=' . $db, 
		  					$user, 
		  					$pass, 
		      				array(PDO::ATTR_PERSISTENT => true)
		      			);

		  //echo "Connected\n";

		} catch (Exception $e) {
		  die("Unable to connect: " . $e->getMessage());
		}

	$i=1;
	foreach($sql_query as $sql){
		//echo $i++;
		//echo ".";
		echo("[executing query]<br />");
		echo("[" . $sql . "]<br /><br />");
		$dbh->query($sql) or die('error in query');
	}


	echo("[performing configurations]<br />");

	// replace parameters in parameter-parser.php and db.php
	$parametersfile = file_get_contents("API/parameter-parser.php");

	$parametersfile = str_replace("[FB_APP_ID]", $configurations["fb-app-id"] ,$parametersfile );
	$parametersfile = str_replace("[FB_APP_SECRET]",  $configurations["fb-ap-secret"] ,$parametersfile );
	$parametersfile = str_replace("[TW_CONSUMER_KEY]", $configurations["tw-consumer-key"] ,$parametersfile );
	$parametersfile = str_replace("[TW_CONSUMER_SECRET]",  $configurations["tw-consumer-secret"] ,$parametersfile );
	$parametersfile = str_replace("[TW_TOKEN]",  $configurations["tw-token"] ,$parametersfile );
	$parametersfile = str_replace("[TW_TOKEN_SECRET]",  $configurations["tw-token-secret"] ,$parametersfile );
	$parametersfile = str_replace("[IN_CLIENT_ID]",  $configurations["in-client-id"] ,$parametersfile );

	file_put_contents('API/parameter-parser.php', $parametersfile );



	$parametersfile = file_get_contents("API/db.php");

	$parametersfile = str_replace("[HE_DB_HOST]", $configurations["db-host"] ,$parametersfile );
	$parametersfile = str_replace("[HE_DB_NAME]",  $configurations["db-name"] ,$parametersfile );
	$parametersfile = str_replace("[HE_DB_USER]",  $configurations["db-user"] ,$parametersfile );
	$parametersfile = str_replace("[HE_DB_PASSWORD]", $configurations["db-password"] ,$parametersfile );

	file_put_contents('API/db.php', $parametersfile );


	// call getTwitterBearerToken.php to get bearer token
	require_once ('API/codebird.php');
	\Codebird\Codebird::setConsumerKey($configurations["tw-consumer-key"], $configurations["tw-consumer-secret"]);

	$cb = \Codebird\Codebird::getInstance();

	$cb->setToken($configurations["tw-token"], $configurations["tw-token-secret"]);
 
	$reply = $cb->oauth2_token();
	$bt = $reply->access_token;

	echo("[got Twitter Bearer Token]<br />");
	echo("[" . $bt . "]<br />");

	// replace bearer toked in parameter-parser.php

	echo("[configuring Twitter Bearer Token]<br />");

	$parametersfile = file_get_contents("API/parameter-parser.php");

	$parametersfile = str_replace("[TW_BEARER_TOKEN]", $bt ,$parametersfile );

	file_put_contents('API/parameter-parser.php', $parametersfile );


	// use parameters to start a new research

	echo("[configuring research]<br />");

	$researchname = $configurations["research-name"];
	$researchlabel = $configurations["research-label"];
	$clat = 999;
	$clng = 999;
	$minlat = 999;
	$minlng = 999;
	$maxlat = 999;
	$maxlng = 999;
	if(isset($configurations["research-geo"]) && $configurations["research-geo"]!="" ){
		$geoparts = explode(",", $configurations["research-geo"]);
		if(count($geoparts)==6){
			$clat = $geoparts[0];
			$clng = $geoparts[1];
			$minlat = $geoparts[2];
			$minlng = $geoparts[3];
			$maxlat = $geoparts[4];
			$maxlng = $geoparts[5];
		}
	}

	$dbh->query(  "INSERT INTO research(name,label,clat,clon,minlat,minlon,maxlat,maxlon) VALUES ('" . $researchname . "','" . $researchlabel . "'," . $clat . "," . $clng . "," . $minlat . "," . $minlng . "," . $maxlat . "," . $maxlng . ")"  );

	$colorindex = 0;

	if(isset($configurations["research-classes"]) && $configurations["research-classes"]!=""){
		$classes = explode(",", $configurations["research-classes"]);
		$words = explode(":",$configurations["research-words"]);
		for($i = 0; $i<count($classes); $i++){
			$class = $classes[$i];
			$classwords = array();
			if(isset($words[$i])){
				$classwords = explode(",", $words[$i]);
			}

			$dbh->query(  "INSERT INTO classes(name,color,research) VALUES ('" . $class . "','" . $colors[$colorindex] . "','" . $researchlabel . "')"  );
			$classid = $dbh->lastInsertId();

			$colorindex++;
			if($colorindex>=count($colors)){ $colorindex = 0; }

			for($j=0; $j<count($classwords); $j++){
				$word =  $classwords[$j] ;
				$dbh->query(  "INSERT INTO words(id_class,word,t,research) VALUES (" . $classid . ",'" . $word . "',NOW(),'" . $researchlabel . "')"  );
			}

		}
	}


	// configure updater

	echo("[configuring updater]<br />");

	$parametersfile = file_get_contents("updater.php");

	$parametersfile = str_replace("[RESEARCH_NAME]", $configurations["research-label"] ,$parametersfile );

	file_put_contents('updater.php', $parametersfile );


?>