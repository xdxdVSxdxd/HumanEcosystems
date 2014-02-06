<html>
<head>
	<title>EMC1</title>
	<script src="viz/js/jquery-2.0.3.min.js"></script>
	<script>

	var timerTwitter, timerFacebook, timerInstagram, timerFBLocations,timerRelater;
	var timeout = 9000;
	var timeout2 = 22000;

	var citycode = "saopaulo";
	

	var startTwitter = function(){
		console.log("getTwitter--");
		$("div#loadTwitter").load("getTwitter.php?w=" + citycode);
		if(timerTwitter){
			clearTimeout(timerTwitter);
		}
		timerTwitter = setTimeout(startTwitter,5000);
	}

	var startFacebook = function(){
		console.log("getFb--");
		$("div#loadFacebook").load("getFacebook.php?w=" + citycode);
		if(timerFacebook){
			clearTimeout(timerFacebook);
		}
		timerFacebook = setTimeout(startFacebook,23000);
	}

	var startFBLocations = function(){
		console.log("getFbLocations--");
		$("div#loadFBLocations").load("getFBLocations.php?w=" + citycode);
		if(timerFBLocations){
			clearTimeout(timerFBLocations);
		}
		timerFBLocations = setTimeout(startFBLocations,51000);
	}

	var startInstagram = function(){
		console.log("getInstagram--");
		$("div#loadInstagram").load("getInstagram.php?w=" + citycode);
		if(timerInstagram){
			clearTimeout(timerInstagram);
		}
		timerInstagram = setTimeout(startInstagram,31000);
	}
	var startRelater = function(){
		console.log("relations--");
		$("div#loadRelater").load("relationer.php?w=" + citycode);
		if(timerRelater){
			clearTimeout(timerRelater);
		}
		timerRelater = setTimeout(startRelater,11000);
	}

	$( document ).ready(function() {
		
		timerFacebook = setTimeout(startFacebook,3000);
		timerFBLocations = setTimeout(startFBLocations,5000);
		timerTwitter = setTimeout(startTwitter,11000);
		timerInstagram = setTimeout(startInstagram,13000);
		timerRelater = setTimeout(startRelater,17000);
		
		
	});

	</script>
</style>
</head>
<body>
	<div id="loadTwitter"></div>
	<div id="loadFacebook"></div>
	<div id="loadInstagram"></div>
	<div id="loadFBLocations"></div>
	<div id="loadRelater"></div>
</body>
</html>