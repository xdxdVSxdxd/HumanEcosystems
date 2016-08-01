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
	    		text-align: center;
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

	    	a.linkwordclass{
	    		color: #000000;
	    	}

	    	a.linkwordclass:hover{
	    		color: #FF0000;
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

	    	.sentimentpercent{
	    		font: 40px Helvetica,Arial,sans-serif;
	    		text-align: center;
	    		color: #000000;
	    	}

	        	#inputbox{
	        		margin:0px;
	        		padding: 0px;
	        		width: 100%;
	        		height: 40px;
	        		background: #000000;
	        		color: #FFFFFF;

	        	}
	        	#inputboxinner{
	        		padding: 10px;
	        		font: 14px Helvetica, Arial, sans-serif;
	        	}


	        	#timeline path { 
				    stroke: steelblue;
				    stroke-width: 2px;
				    fill: none;
				}

				#timeline .axis path,
				#timeline .axis line {
				    fill: none;
				    stroke: grey;
				    stroke-width: 2px;
				    shape-rendering: crispEdges;
				}


				#emotiongraph #xaxis .domain {
					fill:none;
					stroke:#000;
				}
				#emotiongraph #xaxis text, #emotiongraph #yaxis text {
					font-size: 12px;
				}


				#wordnetwork .tccircle{
		          fill: steelblue;
		          stroke: none;
		        }

		        #wordnetwork .tctext{
		          fill: #FFFFFF;
		          stroke: none;
		          font: 24px "Helvetica Neue", Helvetica, Arial, sans-serif;
		          text-anchor: middle;
		          pointer-events: none;
		        }


		        #relationalnetwork .tccircle{
		          fill: steelblue;
		          stroke: none;
		        }

		        #relationalnetwork .tctext{
		          fill: #FFFFFF;
		          stroke: none;
		          font: 24px "Helvetica Neue", Helvetica, Arial, sans-serif;
		          text-anchor: middle;
		          pointer-events: none;
		        }

		        #hashtags .tccircle{
		          fill: steelblue;
		          stroke: none;
		        }

		        #hashtags .tctext{
		          fill: #FFFFFF;
		          stroke: none;
		          font: 24px "Helvetica Neue", Helvetica, Arial, sans-serif;
		          text-anchor: middle;
		          pointer-events: none;
		        }

	    </style>
	  <script src="d3.min.js"></script>  
      <script src="jquery-2.1.3.min.js"></script>
	    <script src="script2.js" charset="utf-8" >
	    	
	    </script>
	</head>
	<body>
		<div id="papercontainer" class="page">
			<div id="inputbox">
				<div id="inputboxinner">

					<input type="text" name='searchText' id='searchText' value='' />
					<button id='submitsearch'>REPORT</button>
				
				</div>
			</div>
			<div class="pagewrapper">
				<div class="row">
					<div class="rowelement" id="theword"></div>
					<div class="rowelement" id="thestats"></div>
				</div>
				<div class="row">
					<div class="rowelement" id="csv"><a href="javascript:downloadcontent();">DOWNLOAD CONTENT</a></div>
				</div>
				<div class="row">
					<div class="rowelement"><h1>Time</h1></div>
					<div class="rowelement" id="timeline"></div>
					<div class="rowelement" id="timelinetable"></div>
				</div>
				<div class="row">
					<div class="rowelement"><h1>Emotions</h1></div>
					<div class="rowelement" id="emotiongraph"></div>
					<div class="rowelement" id="sentimentgraph">
						<table width="100%">
							<tr>
								<td align="center">
									<img src="positive.png" width="100" height="100" />
								</td>
								<td align="center">
									<img src="neutral.png" width="100" height="100" />
								</td>
								<td align="center">
									<img src="negative.png" width="100" height="100" />
								</td>
							</tr>
							<tr>
								<td align="center" class="sentimentpercent" id="positivesentiment">
								</td>
								<td align="center" class="sentimentpercent" id="neutralsentiment">
								</td>
								<td align="center" class="sentimentpercent" id="negativesentiment">
								</td>
							</tr>
						</table>
					</div>
					<div class="rowelement" id="emotionstable"></div>
				</div>
				<div class="row">
					<div class="rowelement"><h1>Word Network</h1></div>
					<div class="rowelement" id="wordnetwork"></div>
					<div class="rowelement" id="wordtable"></div>
					<div class="rowelement" >
						<div class="rowelement" id="csv"><a href="javascript:gencsv();">GEN CSV</a></div>
					</div>
				</div>
				<div class="row">
					<div class="rowelement"><h1>Hashtags</h1></div>
					<div class="rowelement" id="hashtags"></div>
					<div class="rowelement" id="hashtagtable"></div>
					<div class="rowelement" >
						<div class="rowelement" id="csv"><a href="javascript:genhashtagscsv();">GEN CSV</a></div>
					</div>
				</div>
				<div class="row">
					<div class="rowelement"><h1>Relational Network</h1></div>
					<div class="rowelement" id="relationalnetwork"></div>
					<div class="rowelement" id="relationstable"></div>
					<div class="rowelement" >
						<div class="rowelement" id="csvrelations"><a href="javascript:gencsvrelations();">GEN CSV</a></div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>