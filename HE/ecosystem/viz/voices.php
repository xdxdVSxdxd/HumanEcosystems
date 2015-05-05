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

		<script src="js/jquery-2.0.3.min.js"></script>
		<!--script src="bower_components/webcomponentsjs/webcomponents.min.js"></script>
		<link rel="import" href="src/voice-player.html">
    	<link rel="import" href="src/voice-recognition.html"-->

    	<style>
    		div.instructions{
    			width: 300px;
    			height: 80px;
    			margin: auto;
    			overflow: hidden;
    		}
    		div.instructions textarea{
    			border: 0px;
    			background: #FFFFFF;
    			color: #868D96;
    			font: 16px 'Titillium Web', sans-serif;
    		}
    		div#contentcontainer{
    			width: 80%;
    			margin: auto;
    			padding-top: 5px;
    			padding-bottom: 30px;
    		}
    		div.resultrow{
    			float: left;
    			font: 10px 'Titillium Web', sans-serif;
    			width: 100%;
    		}
    		div.nickresult{
    			float: left;
    			margin-right: 20px;
    			font-weight: bold;
    			font-size: 12px;
    		}
    		div.txtresult{
    			float: left;
    		}
    		a.linkresult, a.linkresult:visited{
    			display: block;
    			float: left;
    			width: 100%;
    			margin: 0px;
    			margin-bottom: 10px;
    			padding: 0px;
    			text-decoration: none;
    			color: #868D96;
    		}
    		a.linkresult:hover{
    			color: #FFFFFF;	
    		}
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
		<h1>Voices Browser</h1>
		<div>
			


			<!--
			<voice-recognition id="recognition-element"></voice-recognition>
                <script>
                window.addEventListener('polymer-ready', function(e) {
                    var form = document.querySelector('#recognition-form'),
                        input = document.querySelector('#recognition-input'),
                        element = document.querySelector('#recognition-element');


                        element.start();


                    element.addEventListener('result', function(e) {
                    	console.log( e.detail.result );

                        if(e.detail.result.indexOf("clear")!=-1 ){

                        	input.textContent = "";
                        	element.text = "";
                        	
                        } else {
                        	input.textContent = e.detail.result;
                        	// e cercare
                        	$.getJSON("../getContentForWords.php?w=<?php echo($www); ?>&words=" + input.textContent , function(data){
                        		console.log(data);

                        		$("div#contentcontainer").text("");

                        		var c = "";
                        		
                        		for(var i = 0 ; i<data.length; i++){
                        			var r = data[i];
                        			var ss = "<div class='resultrow'>";
                        			ss = ss + "<div class='nickresult'>" + r.nick + "</div><div class='txtresult'>" + r.txt + "</div><div class='sourceresult'>" + r.source + "</div>";
                        			ss = ss + "</div>";
                        			c = c + ss;
                        		}
                        		$("div#contentcontainer").html(c);

                        	});
                        }

                        
                    });
                });
				</script>
				-->

				<script>
                $( document ).ready(function() {
				   
                	$('#recognitioninput').bind('input propertychange', function() {

					      var words = $(this).val();

					      $.getJSON("../getContentForWords.php?w=<?php echo($www); ?>&words=" + words , function(data){
                        		console.log(data);

                        		$("div#contentcontainer").text("");

                        		var c = "";
                        		
                        		for(var i = 0 ; i<data.length; i++){
                        			var r = data[i];
                        			var ss = "<div class='resultrow'>";
                        			ss = ss + "<a class='linkresult' href='" + r.link + "' target='_blank'><div class='nickresult'>" + r.nick + "</div><div class='txtresult'>" + r.txt + "</div></a>";
                        			ss = ss + "</div>";
                        			c = c + ss;
                        		}
                        		$("div#contentcontainer").html(c);

                        	});


					});


				});
                </script>

            	

                <div class="instructions">
                    <p>type something below...</p>

                    <form id="recognition-form" class="pure-form">
                        <textarea id="recognitioninput"></textarea>
                    </form>
                </div>






		</div>
		<div id="contentcontainer" class="contents">
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
		<a href='voices.php?w=<?php echo($www); ?>' title='Voices'>
			VOICES
		</a>
		<a href='timeline.php?w=<?php echo($www); ?>' title='TimeLine'>
			TIMELINE
		</a>
		<a href='relations.php?w=<?php echo($www); ?>' title='Relations'>
			RELATIONS
		</a>
	</div>



	<script type="text/javascript">
		

		
    </script>

</body>
</html>