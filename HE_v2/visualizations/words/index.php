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
          background: #000000;
          color: #FFFFFF;
	    	}
        #vizholder{
          width: 100%;
          height: 100%;
          padding: 0px;
          margin: 0px;
          position: absolute;
          z-index: 200;
          top: 0px;
          left: 0px; 
        }
        #wordgraph{
          width: 50%;
          height: 100%;
          padding: 0px;
          margin: 0px;
          float: left;
          background: #000000;
        }
        #wordgraphcontainer{
          width: 100%;
          height: 100%;
          padding: 0px;
          margin: 0px;
        }
        #tagcloud{
          width: 50%;
          height: 100%;
          padding: 0px;
          margin: 0px;
          float: left;
          background: #00FF00;
        }

        #tagcloudcontainer{
          width: 100%;
          height: 100%;
          padding: 0px;
          margin: 0px;
        }

        #wordgraphtitle{
          width: 45%;
          padding: 0px;
          margin: 0px;
          position: absolute;
          z-index: 400;
          top: 10px;
          left: 10px;
          background: transparent;
          color: rgba(255,255,255,0.9);
          font-family: Helvetica, Arial, sans-serif;
          font-size: 20px;
          line-height: 28px;
        }



        .node {
          stroke: none;
          fill: rgba(0,255,0,1);
        }

        .link {
          fill: none;
          stroke: rgba(200,200,200,0.5);
        }

        .nodetext{
          stroke: none;
          fill: rgba(255,255,255,0.5);
          font: 8px Helvetica;
        }

        .tccircle{
          fill: #000000;
          stroke: none;
        }

        .tctext{
          fill: #FFFFFF;
          stroke: none;
          font: 24px "Helvetica Neue", Helvetica, Arial, sans-serif;
          text-anchor: middle;
          pointer-events: none;
        }
	    </style>
	    <script src="jquery-2.1.3.min.js"></script>
      <script src="d3.min.js"></script>
	    <script src="script.js" charset="utf-8" >
	    </script>
	</head>
	<body>
		<div id='vizholder'>
      <div id='wordgraph'>
        <div id='wordgraphcontainer'></div>
      </div>
      <div id='tagcloud'><div id='tagcloudcontainer'></div></div>
    </div>
    <div id='wordgraphtitle'></div>
	</body>
</html>