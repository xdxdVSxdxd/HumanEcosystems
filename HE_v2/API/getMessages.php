<html>
<head>

		<title>Human Ecosystems – Messages</title>

		<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200' rel='stylesheet' type='text/css'>

		<link href="../visualizations/css/style.css" rel="stylesheet">

	
	</style>
</head>
<body>


	<?php

		require_once('db.php');

		$querylist = "all";
		if(isset($_REQUEST["q"])){
			$querylist = $_REQUEST["q"];
		}


		$y = 0;
		if(isset($_REQUEST["y"])){
			$y = $_REQUEST["y"];
		}

		$m = 0;
		if(isset($_REQUEST["m"])){
			$m = $_REQUEST["m"];
		}

		$d = 0;
		if(isset($_REQUEST["d"])){
			$d = $_REQUEST["d"];
		}

		$h = 0;
		if(isset($_REQUEST["h"])){
			$h = $_REQUEST["h"];
		}


		$prep;

	
		if($querylist=="all"){
			$prep = $dbh->prepare("SELECT DISTINCT nick, link, txt FROM content WHERE research=:w AND t>=:tempo1 AND t<:tempo2");
			$prep->bindParam(':w', $research_code);
			$t1 = $y . "-" . $m . "-" . $d . " " . $h . ":00:00";
			$t2 = $y . "-" . $m . "-" . $d . " " . $h . ":59:59";
			$prep->bindParam(':tempo1', $t1);
			$prep->bindParam(':tempo2', $t2);

			/*
			echo("[w=" . $www . "]");
			echo("[t1=" . $t1 . "]");
			echo("[t2=" . $t2 . "]");
			*/

	
		} else {
			$prep = $dbh->prepare("SELECT DISTINCT content.nick as nick, content.link as link, content.txt as txt FROM content, content_to_class WHERE content.research=:w AND content.t>=:tempo1 AND content.t<:tempo2 AND content_to_class.id_class=:q AND content_to_class.id_content=content.id");
			$prep->bindParam(':w', $research_code);
			$t1 = $y . "-" . $m . "-" . $d . " " . $h . ":00:00";
			$t2 = $y . "-" . $m . "-" . $d . " " . $h . ":59:59";
			$prep->bindParam(':tempo1', $t1);
			$prep->bindParam(':tempo2', $t2);
			$prep->bindParam(':q', $querylist);

		}

	?>

	<div id="emc1container">
		<h1>Messages from <?php echo(  $y . "-" . $m . "-" . $d . " " . $h . ":00:00" ); ?> to <?php echo(  $y . "-" . $m . "-" . $d . " " . $h . ":59:59" ); ?></h1>
		<?php 

			if($prep->execute()){
				while ($row = $prep->fetch()){
					echo("<p>");
					echo("<strong>" . $row["nick"] . ":</strong> " . $row["txt"] . "<a href='" . $row["link"] . "' target='_blank'>OPEN</a>");
					echo("</p>");		
				}
			}

		?>
	</div>
	

	<script src="../visualizations/js/jquery-2.0.3.min.js"></script>
	
</body>
</html>