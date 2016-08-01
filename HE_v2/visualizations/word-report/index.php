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
	    		font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;
	    		font-size: 10px;
	    	}
	    	#interface{
	    		width: 100%;
	    		height: 100%;
	    		padding: 0px;
	    		margin: 0px;
	    		overflow: hidden;
	    		clear: auto;
	    	}
	    	#ibody{
	    		width: 100%;
	    		height: 100%;
	    		padding: 0px;
	    		margin: 0px;
	    		overflow: hidden;
	    		clear: auto;
	    	}
	    	#ititle{
	    		padding: 0px;
	    		margin: auto;
	    		margin-top: 175px;
	    		margin-bottom: 60px;
	    		font-size: 40px;
	    		font-weight: bold;
	    		text-align: center;
	    		clear: auto;
	    		color: #00FF00;
	    	}
	    	#iform{
	    		width: 400px;
	    		margin: auto;
	    		overflow: hidden;
	    	}
	    	#formbody{
	    		width: 340px;
	    		margin: 0px;
	    		padding: 30px;
	    		overflow: hidden;
	    	}
	    	#iinput{
	    		width: 340px;
	    		background: #EEEEEE;
	    		text-align: center;
	    		font-size: 22px;
	    		color: #333333;
	    		border-bottom: 2px solid #009900;
	    	}
	    	#submitf{
	    		width: 400px;
	    		margin: auto;
	    		overflow: hidden;	
	    	}
	    	#isubmit{
	    		width: 210px;
	    		margin: 0px;
	    		margin-left: 80px;
	    		margin-right: 80px;
	    		padding: 15px;
	    		background: #22FF22;
	    		color: #000000;
	    		border-bottom: 2px solid #009900;
	    		text-align: center;
	    		font-size: 25px;
	    		text-decoration: none;
	    		overflow: hidden;	
	    	}

	    	#isubmit:hover{
	    		background: #88FF88;
	    	}

	    	#submitf a,#submitf a:visited{
	    		text-decoration: none;
	    	}
	    </style>
	    <!--script type="text/javascript" charset="utf-8" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoQFDqTY52IIrAVtLvTZr2CMXZEm0CEH4&sensor=false&libraries=visualization"></script-->
      <script type="text/javascript"src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=visualization&sensor=false"></script>
      <script src="jquery-2.1.3.min.js"></script>
	    <script src="script.js" charset="utf-8" >
	    	
	    </script>
	</head>
	<body>
		<div id='interface'>
			<div id='ibody'>
				<div id='ititle'>Word Report</div>
				<div id='iform'>
					<form id='extractorform' name='extractorform' METHOD="GET" action="index2.php">
						<div id='formbody'>
							<input type="text" name="iinput" id="iinput" value="" />
							<input type="hidden" name="w" id="w" value="" />
						</div>
					</form>
				</div>
				<div id='submitf'>
					<a href="javascript:submitForm();"><div id="isubmit">REPORT</div></a>
				</div>
			</div>
		</div>
	</body>
</html>