<html>
<head>

		<title>Human Ecosystems – Voices</title>

		<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200' rel='stylesheet' type='text/css'>

		<link href="../css/style.css" rel="stylesheet">

		<script src="../js/jquery-2.0.3.min.js"></script>

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

	<?php

		require_once('../../API/db.php');

	?>

	<div id="emc1container">
		<h1>Voices Browser</h1>
		<div>
	
				<script>
                $( document ).ready(function() {
				   
                	$('#recognitioninput').bind('input propertychange', function() {

					      var words = $(this).val();

					      $.getJSON("../../API/getContentForWords.php?w=<?php echo($research_code); ?>&words=" + words , function(data){
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


</body>
</html>