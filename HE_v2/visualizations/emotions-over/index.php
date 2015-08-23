<?php header('Content-Type: text/html; charset=utf-8'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="it" xml:lang="it" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/">
	<head>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<meta charset="utf-8" />
    <link href='http://fonts.googleapis.com/css?family=Bad+Script' rel='stylesheet' type='text/css'>
		<style>
	    	html,body,#mapholder{
	    		width: 100%;
	    		height: 100%;
	    		padding: 0px;
	    		margin: 0px;
	    	}
	    	#mapholder{
	    		width: 100%;
	    		height: 100%;
          position: absolute;
          top: 0px;
          left: 0px;
          z-index: 100;
	    	}

        #legend{
          width: 200px;
          height: 304px;
          position: absolute;
          top: 10px;
          right: 10px;
          z-index: 900;
          background: rgba(0,0,0,0.3);
          color: #FFFFFF;
          overflow: hidden;
        }
        #legend-head{
          width: 180px;
          height: 20px;
          padding: 10px;
          overflow: hidden;
          font-family: 'Bad Script', cursive;
          font-size: 20px;
          line-height: 25px;
          border-bottom: 1px solid #EEEEEE;
        }
        #legend-body{
          width: 180px;
          height: 239px;
          padding: 10px;
          overflow: hidden;
        }

        .legend-item-holder{
          width: 180px;
          height: 15px;
          margin-bottom: 4px;
          overflow: hidden;
          color: #FFFFFF;
          font: 12px Helvetica,sans-serif;
          line-height: 15px;
          clear: auto;
        }
        .legend-color{
          width: 15px;
          height: 15px;
          margin-right: 12px;
          overflow: hidden;
          float: left;
        }
        .legend-lebel{
          width: 153px;
          height: 15px;
          overflow: hidden;
          float: left;
        }

        a,a:visited{
          color: #333333;
          text-decoration: none;
        }
        a:hover{
          color: #555555;
          text-decoration: none;
        }
        .infowdiv{
          text-decoration: none;
          color: #333333;
          font: 13px Helvetica, Arial, sans-serif;
          padding: 2px;
          margin: 6px;
        }

        #bottom-diagrams{
          width: 100%;
          height: 100px;
          position: absolute;
          bottom: 0px;
          left: 0px;
          z-index: 900;
          background: rgba(0,0,0,0.6);
          color: #FFFFFF;
          overflow: hidden;
          font: 8px monospace;
        }


        .axis path,
        .axis line {
          fill: none;
          stroke: #FFFFFF;
          shape-rendering: crispEdges;
        }

        .axis text{
          fill: #FFFFFF;
          stroke: none;
        }

        .x.axis path {
          display: none;
        }

        .line {
          fill: none;
          stroke: steelblue;
          stroke-width: 1.5px;
        }



	    </style>
	    <!--script type="text/javascript" charset="utf-8" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoQFDqTY52IIrAVtLvTZr2CMXZEm0CEH4&sensor=false&libraries=visualization"></script-->
      <script type="text/javascript"src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=visualization&sensor=false"></script>
      <script src="jquery-2.1.3.min.js"></script>
      <script src="d3.min.js"></script>
	    <script src="script.js" charset="utf-8" >
	    	
	    </script>
	</head>
	<body>
		<div id='mapholder'></div>
    <div id='legend'>
      <div id="legend-head">Legend</div>
      <div id="legend-body"></div>
    </div>
    <div id="bottom-diagrams">
        <div id="emo-timeline-contained">
        </div>
    </div>
	</body>
</html>