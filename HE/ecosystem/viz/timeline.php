<html>
<head>
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

	?>

	<div id="emc1container">
		<h1>Main Timeline</h1>
		<div id="mainTimeline" class="timelines">
		</div>
	</div>
	<div id="classescontainer"></div>
	<div id="navContainer">
		<a href='/HE/index.php' title='Human Ecosystems'>
			<img src='img/HE_logo_transparent.png' title='Human Ecosystems' />
		</a>
		<a href='index.php?w=<?php echo($www); ?>' title='Space'>
			SPACE
		</a>
		<a href='time.php?w=<?php echo($www); ?>' title='Time'>
			TIME
		</a>
		<a href='timeline.php?w=<?php echo($www); ?>' title='TimeLine'>
			TIMELINE
		</a>
		<a href='relations.php?w=<?php echo($www); ?>' title='Relations'>
			RELATIONS
		</a>
	</div>



	<script src="js/jquery-2.0.3.min.js"></script>
	<script type="text/javascript" src="js/d3/d3.v3.min.js"></script>
	<script type="text/javascript">
		var maxval = 0;
		var mh = 100;

		d3.json("getTimelineData.php?w=<?php echo($citycode); ?>",function(e,dataset){

			for(var i = 0; i<dataset.length; i++){
				if(eval(dataset[i].c)>maxval){
					maxval = eval(dataset[i].c);
				}
			}


			d3.select("div#mainTimeline")
				.selectAll("p")
				.data(dataset)
				.enter()
				.append("a")
				.attr("href",function(d){
					return "javascript:openpopup('<?php echo($citycode); ?>','all'," + d.y + "," + d.mo + "," + d.d + "," + d.h + ")";
				})
				.append("div")
				.attr("class","bargraphbar")
				.attr("title", function(d){
					return "" + d.y + "/" + d.mo + "/" + d.d + " " + d.h + ":00";	
				})
				.style("width", ((Math.floor(960/dataset.length)) -2) + "px")
				.style("height", function(d) {
				    return Math.floor( mh*d.c/maxval ) + "px";
				});
		});



		<?php

			$prep = $dbh->prepare("SELECT DISTINCT id, name,color FROM classes WHERE city=:w");
			$prep->bindParam(':w', $citycode);
			
			if($prep->execute()){
				while ($row = $prep->fetch()){
					//$row["name"];
			        //$row["color"];
			        
					$iddom = $row["name"] . "-" . $row["id"];

					?>
					$("div#emc1container").append("<h1><?php echo($row["name"]); ?> Timeline</h1><div id='<?php echo($iddom); ?>' class='timelines'></div>");
					timelineindiv('<?php echo($iddom); ?>','<?php echo($row["id"]); ?>','<?php echo($row["color"]); ?>');
					<?php

				}
			}

		?>


		function openpopup(w,q,y,m,d,h){
			window.open( "getMessages.php?w=" + w + "&q=" + q + "&y=" + y + "&m=" + m + "&d=" + d + "&h=" + h );
		}


		function timelineindiv(iddiv,idclass,colore){

			

			d3.json("getTimelineDataForClasses.php?w=<?php echo($citycode); ?>&c=" + idclass,function(e,dataset){

				var mmaxval=0;

				for(var i = 0; i<dataset.length; i++){
					if(eval(dataset[i].c)>mmaxval){
						mmaxval = eval(dataset[i].c);
					}
				}

				//console.log("[" + idclass + "][" + iddiv + "][" + mmaxval + "]");
				//console.log( "[" + colore + "]-->" + parseInt(colore,16) );

				d3.select("div#" + iddiv)
					.selectAll("p")
					.data(dataset)
					.enter()
					.append("a")
					.attr("href",function(d){
						return "javascript:openpopup('<?php echo($citycode); ?>'," + idclass + "," + d.y + "," + d.mo + "," + d.d + "," + d.h + ")";
					})
					.append("div")
					.attr("class","bargraphbar")
					.style("background-color","#" + colore.substring(2))
					.attr("title", function(d){
						return "" + d.y + "/" + d.mo + "/" + d.d + " " + d.h + ":00";	
					})
					.style("width", ((Math.floor(960/dataset.length)) -2) + "px")
					.style("height", function(d) {
					    return Math.floor( mh*d.c/mmaxval ) + "px";
					});
			});
		}
    	
    </script>

</body>
</html>