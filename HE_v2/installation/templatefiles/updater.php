<html>
<head>
	<title>Human Ecosystems Updater [RESEARCH_NAME]</title>
	<script src="visualizations/js/jquery-2.0.3.min.js"></script>
	<script>

	var timerTwitter, timerFacebook, timerInstagram, timerFBLocations,timerRelater, timerWordClassifier, timerEmotioner,twitteruser;
	var timeout = 9000;
	var timeout2 = 22000;

	var citycode = "[RESEARCH_NAME]";
	

	var startWordClassifier = function(){
		$("div#loadWordClassifier").load("API/word_classifier.php", function(){
			if(timerWordClassifier){
				clearTimeout(timerWordClassifier);
			}
			timerWordClassifier = setTimeout(startWordClassifier,5000);	
		});
		
	}


	var startTwitterUser = function(){
		$("div#loadTwitterUser").load("API/getTwitter_from_users.php?w=" + citycode, function(){
			if(twitteruser){
				clearTimeout(twitteruser);
			}
			twitteruser = setTimeout(startTwitterUser,9000);	
		});
		
	}


	var startEmotioner = function(){
		$("div#loadEmotioner").load("API/emotioner.php", function(){
			if(timerEmotioner){
				clearTimeout(timerEmotioner);
			}
			timerEmotioner = setTimeout(startEmotioner,5000);	
		});
		
	}


	var startTwitter = function(){
		$("div#loadTwitter").load("API/getTwitter.php?w=" + citycode, function(){
			if(timerTwitter){
				clearTimeout(timerTwitter);
			}
			timerTwitter = setTimeout(startTwitter,5000);	
		});
		
	}

	var startFacebook = function(){
		$("div#loadFacebook").load("API/getFacebook.php?w=" + citycode,function(){
			if(timerFacebook){
				clearTimeout(timerFacebook);
			}
			timerFacebook = setTimeout(startFacebook,23000);	
		});
		
	}

	var startFBLocations = function(){
		$("div#loadFBLocations").load("API/getFBLocations.php?w=" + citycode,function(){
			if(timerFBLocations){
				clearTimeout(timerFBLocations);
			}
			timerFBLocations = setTimeout(startFBLocations,51000);	
		});
		
	}

	var startInstagram = function(){
		$("div#loadInstagram").load("API/getInstagram.php?w=" + citycode,function(){
			if(timerInstagram){
				clearTimeout(timerInstagram);
			}
			timerInstagram = setTimeout(startInstagram,8000);	
		});
	}
	var startRelater = function(){
		$("div#loadRelater").load("API/relationer.php?w=" + citycode,function(){
			if(timerRelater){
				clearTimeout(timerRelater);
			}
			timerRelater = setTimeout(startRelater,11000);	
		});
	}

	$( document ).ready(function() {
		
		//timerFacebook = setTimeout(startFacebook,3000);
		//timerFBLocations = setTimeout(startFBLocations,5000);
		timerTwitter = setTimeout(startTwitter,11000);
		timerInstagram = setTimeout(startInstagram,13000);
		timerRelater = setTimeout(startRelater,17000);
		timerEmotioner = setTimeout(startEmotioner,12000);
		timerWordClassifier = setTimeout(startWordClassifier,14000);
		twitteruser = setTimeout(startTwitterUser,9000);
		
		
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
	<div id="loadWordClassifier"></div>
	<div id="loadEmotioner"></div>
	<div id="loadTwitterUser"></div>
</body>
</html>