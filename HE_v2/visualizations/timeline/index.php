<html>
<head>

		<title>Human Ecosystems – timeline</title>

		<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200' rel='stylesheet' type='text/css'>

		<link href="../css/style.css" rel="stylesheet">

	
	</style>
</head>
<body>


	<?php

		require_once('../../API/db.php');

	?>

	<div id="emc1container">
		<h1>Main Timeline</h1>
		<div id="mainTimeline" class="timelines">
		</div>
	</div>
	<div id="classescontainer"></div>



	<script src="js/jquery-2.0.3.min.js"></script>
	<script type="text/javascript" src="js/d3/d3.v3.min.js"></script>
	<script type="text/javascript">
		var maxval = 0;
		var mh = 100;

		d3.json("../../API/getTimelineData.php?w=<?php echo($research_code); ?>",function(e,dataset){

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
					return "javascript:openpopup('<?php echo($research_code); ?>','all'," + d.y + "," + d.mo + "," + d.d + "," + d.h + ")";
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

			$prep = $dbh->prepare("SELECT DISTINCT id, name,color FROM classes WHERE research=:w");
			$prep->bindParam(':w', $research_code);
			
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
			window.open( "../../API/getMessages.php?w=" + w + "&q=" + q + "&y=" + y + "&m=" + m + "&d=" + d + "&h=" + h );
		}


		function timelineindiv(iddiv,idclass,colore){

			

			d3.json("../../API/getTimelineDataForClasses.php?w=<?php echo($research_code); ?>&c=" + idclass,function(e,dataset){

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
						return "javascript:openpopup('<?php echo($research_code); ?>'," + idclass + "," + d.y + "," + d.mo + "," + d.d + "," + d.h + ")";
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