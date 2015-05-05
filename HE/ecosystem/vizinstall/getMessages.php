<html>
<head>

		<meta charset="utf-8">
		<link rel="profile" href="http://gmpg.org/xfn/11" />

			<!-- Facebook Metadata /-->
		<meta property="fb:page_id" content="79403465956" />
		<meta property="og:image" content="http://artisopensource.net/HE/HE_logo.png" />
		<meta property="og:description" content="Human Ecosystems: the real-time relational ecosystems of cities. Rome, S. Paulo."/>
		<meta property="og:type" content="website" />
		<meta property="og:title" content="Human Ecosystems" />
		<meta property="og:url" content="http://www.artisopensource.net/HE" />
		<meta property="og:site_name" content="Human Ecosystems" />
		

		<!-- Google+ Metadata /-->
		<meta itemprop="name" content="Human Ecosystems">
		<meta itemprop="description" content="Human Ecosystems: the real-time relational ecosystems of cities. Rome, S. Paulo.">
		<meta itemprop="image" content="http://artisopensource.net/HE/HE_logo.png">

		<title>Human Ecosystems</title>
		<meta name="description" content="Human Ecosystems: the real-time relational ecosystems of cities. Rome, S. Paulo." />
		<meta name="keywords" content="Human Ecosystems, smart city, smart cities, smart communities, urban sensing, big data, bigdata, realtime city, real-time city" />
		<meta name="author" content="humans.txt">

		<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />

		<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200' rel='stylesheet' type='text/css'>

		<link href="../../css/style.css" rel="stylesheet">

	
	</style>
</head>
<body>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-387817-3', 'artisopensource.net');
  ga('send', 'pageview');

</script>


	<?php

		require_once('../db.php');

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
			$prep = $dbh->prepare("SELECT nick, link, txt FROM content WHERE city=:w AND t>=:tempo1 AND t<:tempo2");
			$prep->bindParam(':w', $www);
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
			$prep = $dbh->prepare("SELECT content.nick as nick, content.link as link, content.txt as txt FROM content, content_to_class WHERE content.city=:w AND content.t>=:tempo1 AND content.t<:tempo2 AND content_to_class.id_class=:q AND content_to_class.id_content=content.id");
			$prep->bindParam(':w', $www);
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
	

	<script src="js/jquery-2.0.3.min.js"></script>
	
</body>
</html>