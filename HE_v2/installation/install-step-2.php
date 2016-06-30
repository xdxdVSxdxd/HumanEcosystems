<html>
<head>
<title>Human Ecosystems Installation</title>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="../visualizations/js/jquery.js"></script>
<script src="js/install-step-2.js"></script>
</head>
<body>
<?php
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


?><?php


	$success = true;
	$errormessages = "";

	// cancella db.php in API
	if(file_exists("../API/db.php")){
		unlink("../API/db.php");
	}
	// cp db.php da templates a API
	if(!copy("templatefiles/db.php","../API/db.php")){
		$success = false;
		$errormessages = "Could not copy DB configuration file to API.";
	}

	if($success){

		// replace su db.php in API con i parametri del db
		$parametersfile = file_get_contents("../API/db.php");

		$parametersfile = str_replace("[HE_DB_HOST]", $_REQUEST["db-host"] ,$parametersfile );
		$parametersfile = str_replace("[HE_DB_NAME]",  $_REQUEST["db-name"] ,$parametersfile );
		$parametersfile = str_replace("[HE_DB_USER]",  $_REQUEST["db-user"] ,$parametersfile );
		$parametersfile = str_replace("[HE_DB_PASSWORD]", $_REQUEST["db-pwd"] ,$parametersfile );

		file_put_contents('../API/db.php', $parametersfile );
		// caricare gli script del database

		$dbms_schema = '../database-schema/schema.sql';

		$sql_query = @fread(@fopen($dbms_schema, 'r'), @filesize($dbms_schema));// or die('problem in opening SQL File');

		if(!$sql_query){
			$success = false;
			$errormessages = $errormessages . "Error opening the database schema file.";
		}

		if($success){

			$sql_query = remove_remarks($sql_query);
			$sql_query = split_sql_file($sql_query, ';');

			$host = $_REQUEST["db-host"];
			$user = $_REQUEST["db-user"];
			$pass = $_REQUEST["db-pwd"];
			$db = $_REQUEST["db-name"];

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
				  	$success = false;
					$errormessages = $errormessages . "Error accessing the database.";
				}

			if($success){
				$i=1;
				foreach($sql_query as $sql){
					$rh = $dbh->query($sql);
					if(!$rh){
						$success = false;
						$errormessages = $errormessages . "Error executing query [" . $sql . "].";
					}
				}
			}

		}// if success di open file


	}
	// if(success)
	


?>

	<div class="page">
		<div class="header">
			<h1>Human Ecosystems : Installation, Step 2</h1>
		</div>
		<div class="row">
			<div class="rowcontent">
				<h2>Load Database Structure</h2>
				<p>Verify database data, then press NEXT.</p>
			</div>
		</div>
		<div class="row">
			<div class="breadcrumbs">
				<a href="index.php" title="installation home">Installation Home</a>
				>
				<a href="install-step-1.php" title="Installation step 1: database">Installation step 1: database</a>
				>
				Installation step 1: load database
			</div>
		</div>
		<div class="row">
			<div class="rowcontent">
				<?php 
					if(!$success){
						?>
						<h2>ERROR Loading Database Structure</h2>
						<p><?php echo($errormessages); ?></p>
						<?
					} else {
						?>
						<h2>SUCCESS: loaded database structure</h2>
						<p>press NEXT to continue.</p>
						<?
					}
				?>
			</div>
		</div>
		<div class="row action-section">
			<div class="rowcontent">
				<a href="install-step-1.php" title="Back to install main page">Back</a>
				<?php 
					if($success){
						?>
							<a href="install-step-3.php" id="submit" title="Next">Next</a>
						<?php
					}
				?>
			</div>
		</div>
	</div>
</body>
</html>