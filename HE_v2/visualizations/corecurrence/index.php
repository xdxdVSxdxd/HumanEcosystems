<?php header('Content-Type: text/html; charset=utf-8'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="it" xml:lang="it" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/">
	<head>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<meta charset="utf-8" />
    <link href='http://fonts.googleapis.com/css?family=Bad+Script' rel='stylesheet' type='text/css'>
		<style>
	    	html,body{
	    		cursor:none;
	    		width: 100%;
	    		height: 100%;
	    		padding: 0px;
	    		margin: 0px;
          background: #000000;
          color: #FFFFFF;
	    	}
        #vizholder{
        	cursor:none;
          width: 100%;
          height: 100%;
          padding: 0px;
          margin: 0px;
          position: relative;
          z-index: 200;
          margin: auto;
        }

        #hiddeninterfaces{
          display: none;
        }



        .background {
          fill: #000000;
        }

        line {
          stroke: #444444;
        }

        text{
          font-family: Helvetica;
          font-size: 8px;
          fill: #FFFFFF;
          stroke: none;
          opacity: 0.4;
        }
        text.active {
          fill: #FFFF00;
          font-size: 12px;
          opacity: 1;
        }
        .cell{
          
        }

	    </style>
	    <script src="jquery-2.1.3.min.js"></script>
      <script src="d3.min.js"></script>
	    <script src="script.js" charset="utf-8" >
	    </script>
	</head>
	<body>
		<div id='vizholder'>
    </div>
	</body>
</html>