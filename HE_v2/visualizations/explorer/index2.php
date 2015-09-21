<?php header('Content-Type: text/html; charset=utf-8'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="it" xml:lang="it" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/">
	<head>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<meta charset="utf-8" />
    <link href='http://fonts.googleapis.com/css?family=Bad+Script' rel='stylesheet' type='text/css'>
		<style>
	    	html,body{
	    		width: 100%;
	    		height: 100%;
	    		padding: 0px;
	    		margin: 0px;
	    		background: #FFFFFF;
	    		color: #000000;
	    		font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;
	    		font-size: 10px;
	    	}
	    	.page{
	    		width: 100%;
	    		padding:0px;
	    		margin: 0px;
	    	}
	    	.pagewrapper{
	    		padding: 12px;
	    		margin: 20px;
	    	}
	    	.row{
	    		width: 100%;
	    		padding: 0px;
	    		margin: 0px;
	    		margin-bottom: 20px;
	    	}

	    	.row:after {
			  content:"";
			  display:table;
			  clear:both;
			}

	    	.rowelement{
	    		box-sizing: border-box;
			    -moz-box-sizing: border-box;
			    -webkit-box-sizing: border-box;
	    		padding: 5px;
	    		margin: 5px;
	    		float: left;
	    	}

	    	#theword{
	    		font: bold 40px 'Helvetica Neue',Helvetica,Arial,sans-serif;
	    		color: #000000;
	    	}

	    	.headpeople{
	    		font: bold 40px 'Helvetica Neue',Helvetica,Arial,sans-serif;
	    		color: #000000;
	    		padding: 0px;
	    		margin: 0px;
	    	}

	    	#thepeopleinthewordcontent1,#thepeopleinthewordcontent2{
	    		font: 10px 'Helvetica Neue',Helvetica,Arial,sans-serif;
	    		color: #000000;
	    		padding: 0px;
	    		margin: 0px;
	    		margin-top: 10px;
	    		width: 100%;
	    	}

	    	.barchtitlelabel{
	    		fill: #000000;
	    		stroke: none;
	    		font-size: 18px;
	    		font-weight: bold;
	    	}
	    	.tick text{
	    		fill: #000000;
	    		stroke: none;
	    		font-size: 8px;
	    	}

	    	.pbarchtitlelabel{
	    		fill: #000000;
	    		stroke: none;
	    		font-size: 18px;
	    		font-weight: bold;
	    	}
	    	.ptick text{
	    		fill: #000000;
	    		stroke: none;
	    		font-size: 8px;
	    	}


	    	.node {
	          stroke: none;
	          fill: rgba(0,0,0,1);
	        }

	        .link {
	          fill: none;
	          stroke: rgba(0,0,0,1);
	        }

	        .nodetext{
	          stroke: none;
	          fill: rgba(0,0,0,1);
	          font: 8px Helvetica;
	        }


	    </style>
	  <script src="d3.min.js"></script>  
      <script src="jquery-2.1.3.min.js"></script>
	    <script src="script2.js" charset="utf-8" >
	    	
	    </script>
	</head>
	<body>
		<div id="papercontainer" class="page">
			<div class="pagewrapper">
				<div class="row">
					<div class="rowelement" id="theword"></div>
					<div class="rowelement" id="thestats"></div>
				</div>
				<div class="row">
					<div class="rowelement" id="theconnections"></div>
					<div class="rowelement" id="thestatsoftheconnections"></div>
				</div>
				<div class="row">
					<div class="rowelement" id="therelationsbetweenthepeopleintheword"></div>
					<div class="rowelement" id="thepeopleintheword">
						<div class="headpeople">Who?</div>
						<div id="thepeopleinthewordcontent1"></div>
						<div id="thepeopleinthewordcontent2"></div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>