<?php header('Content-Type: text/html; charset=utf-8'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="it" xml:lang="it" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/">
	<head>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<meta charset="utf-8" />

		<meta property="og:type" content="blog" />
		<meta property="og:title" content="Real Time Budapest | HE" />
		<meta property="og:description" content="The Real Time life of Budapest" />
		<meta property="og:url" content="http://www.artisopensource.net/projects/real-time-budapest.html" />
		<meta property="og:site_name" content="[ AOS ] Art is Open Source" />
		<meta property="og:image" content="http://www.artisopensource.net/projects/real-time-cairo-big.png" />
		<title>Real Time Budapest | AOS</title>
		<meta name="keywords" content="art is open source, aos, budapest, ubiquitous, ubiquitous publishing, urban sensing" />
		<meta name="description" content="The Real Time life of Budapest" />
		<meta name="application-name" content="artisopensource.net" />
		
		<!-- Le styles -->
	    <link href="style.css" rel="stylesheet">
	    <link href='http://fonts.googleapis.com/css?family=Port+Lligat+Slab' rel='stylesheet' type='text/css'>
	    <link href='http://fonts.googleapis.com/css?family=Abel' rel='stylesheet' type='text/css'>
	    <style>
	    	html,body,#mapholder{
	    		width: 100%;
	    		height: 100%;
	    		padding: 0px;
	    		margin: 0px;
	    	}
	    	#mapholder{
	    		z-index: 100;
	    	}
	    	#real-time-Cairo-title{
	    		position: absolute;
	    		display: block;
	    		padding:20px;
	    		z-index: 9999;
	    		top: 20px;
	    		left: 20px;
	    		height: 80px;
	    		width: 200px;
	    		background: #FF3399;
	    		color: #FFFFFF;
	    		font-family: 'Port Lligat Slab', serif;
	    		font-size: 22px;
	    		filter:alpha(opacity=60);      
		       	-moz-opacity:0.60;             
		       	-khtml-opacity: 0.60;          
		      	opacity: 0.60;
	    	}

	    	#real-time-Cairo-title p{
	    		font: 8px Helvetica, Arial, sans-serif;
	    		color: #000000;
	    	}

	    	#real-time-Cairo-timeline{
	    		position: absolute;
	    		display: block;
	    		padding:20px;
	    		z-index: 9999;
	    		top: 20px;
	    		right: 20px;
	    		height: 80px;
	    		width: 40%;
	    		background: #000000;
	    		color: #FFFFFF;
	    		font-family: 'Port Lligat Slab', serif;
	    		font-size: 22px;
	    		filter:alpha(opacity=60);      
		       	-moz-opacity:0.60;             
		       	-khtml-opacity: 0.60;          
		      	opacity: 0.60;
	    	}

	    	#real-time-Cairo-title h1{
	    		font: inherit;
	    	}

	    	#real-time-Cairo-title a, #real-time-Cairo-title a:visited{
	    		font: inherit;
	    		font-size: 12px;
	    		color: #000000;
	    		text-decoration: none;
	    	}

	    	#real-time-Cairo-title a:hover{
	    		text-decoration: underline;
	    	}

	    	#tag-cloud{
	    		position: absolute;
	    		display: block;
	    		padding:20px;
	    		z-index: 9999;
	    		top: 160px;
	    		left: 20px;
	    		width: 200px;
	    		background: #333333;
	    		color: #FFFFFF;
	    		font-family: 'Port Lligat Slab', serif;
	    		font-size: 12px;
	    		filter:alpha(opacity=60);      
		       	-moz-opacity:0.60;             
		       	-khtml-opacity: 0.60;          
		      	opacity: 0.60;	
	    	}

	    	#statistics{
	    		position: absolute;
	    		display: block;
	    		padding:20px;
	    		z-index: 9999;
	    		top: 120px;
	    		right: 20px;
	    		width: 200px;
	    		background: transparent;
	    		color: #FFFFFF;
	    		font-family: 'Port Lligat Slab', serif;
	    		font-size: 12px;
	    		filter:alpha(opacity=60);      
		       	-moz-opacity:0.60;             
		       	-khtml-opacity: 0.60;          
		      	opacity: 0.60;		
	    	}

	    	.tagCloudBox{
	    		float: left;
	    		margin: 5px;
	    	}

	    	.h3popup{
	    		font-family: 'Port Lligat Slab', serif;
	    		font-size: 16px;
	    	}

	    	.ppopup{
	    		font-family: 'Port Lligat Slab', serif;
	    		font-size: 12px;
	    	}


div.city-statistics{
	float:left;
	overflow: hidden;
	padding: 0px;
	margin: 10px;
}

div.cityName{
	overflow: hidden;
	padding: 0px;
	margin: 0px;
	margin-bottom: 4px;
	font: bold 14px Arial, Helvetica, sans-serif;
	color: #FFFF00;
}

div.dataRow{
	overflow: hidden;
	padding: 0px;
	margin: 0px;
	margin-bottom: 4px;
	font: 10px Arial, Helvetica, sans-serif;
	color: #DDDDDD;
}


div.graphRow{
	overflow: hidden;
	padding: 0px;
	margin: 0px;
	height: 12px;
	min-height: 12px;
}


div.graphLabel{
	overflow: hidden;
	float: left;
	padding: 0px;
	margin: 0px;
	height: 12px;
	min-height: 12px;
	width: 20%;
	color: #FFFFFF;
}
div.graphBar{
	overflow: hidden;
	float: left;
	padding: 0px;
	margin: 0px;
	height: 12px;
	min-height: 12px;
	width: 80%;
}

div.graphBar div{
	float: left;
	min-height: 12px;
}

div.row{
	float: left;
	width: 100%;
	padding: 0px;
	margin: 0px;
	margin-bottom: 32px;
}

	    </style>
	    <script type="text/javascript" charset="utf-8" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	    <script type="text/javascript" charset="utf-8" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoQFDqTY52IIrAVtLvTZr2CMXZEm0CEH4&sensor=false"></script>
	    <script type="text/javascript" charset="utf-8" >


	    	var map;
	    	var markers;
	    	var refreshtimeout,updatetimeout,tagcloudtimer,statstimer,timelinetimer;
	    	var largestID = "";
	    	var infov;
	    	var infowindow = new google.maps.InfoWindow();

	    	var styles = [
  {
    "stylers": [
      { "visibility": "off" }
    ]
  },{
    "featureType": "water",
    "elementType": "geometry",
    "stylers": [
      { "visibility": "on" },
      { "invert_lightness": true }
    ]
  },{
    "featureType": "road",
    "elementType": "geometry.fill",
    "stylers": [
      { "visibility": "on" },
      { "color": "#487070" },
      { "weight": 0.7 }
    ]
  },{
    "featureType": "administrative",
    "elementType": "geometry",
    "stylers": [
      { "visibility": "on" },
      { "lightness": -65 }
    ]
  },{
    "featureType": "landscape",
    "elementType": "geometry",
    "stylers": [
      { "visibility": "on" },
      { "color": "#201210" }
    ]
  },{
    "featureType": "poi",
    "elementType": "geometry",
    "stylers": [
      { "visibility": "on" },
      { "lightness": -82 }
    ]
  },{
    "featureType": "transit",
    "stylers": [
      { "visibility": "on" }
    ]
  }
];

			var styledMap = new google.maps.StyledMapType(styles, {name: "Serenade Map"});


	      function initialize() {
	        var mapOptions = {
	          center: new google.maps.LatLng(41.89474, 12.4839),
	          zoom: 11,
	          mapTypeId: google.maps.MapTypeId.ROADMAP,
	          backgroundColor: '#EEEEEE',
	          mapTypeControl: false,
	          panControl: false,
	          rotateControl: false,
	          scaleControl: false,
	          scrollwheel: true,
	          streetViewControl: false,
	          zoomControl: false
	        };
	        map = new google.maps.Map(document.getElementById("mapholder"), mapOptions);

	        map.mapTypes.set('map_style', styledMap);
		  	map.setMapTypeId('map_style');



		  	markers = new Array();


		  	if(refreshtimeout!=null){
		  		clearTimeout( refreshtimeout );
		  	}

		  	refreshtimeout = setTimeout( doRefresh ,2000);


		  	if(tagcloudtimer!=null){
		  		clearTimeout( tagcloudtimer );
		  	}

		  	tagcloudtimer = setTimeout( doTags ,2800);
        

		  	if(updatetimeout!=null){
		  		clearTimeout( updatetimeout );
		  	}

		  	updatetimeout = setTimeout( doUpdate ,9000);


		  	if(statstimer!=null){
		  		clearTimeout( statstimer );
		  	}

		  	statstimer = setTimeout( doStats ,4700);

		  		if(timelinetimer!=null){
			  		clearTimeout( timelinetimer );
			  	}

			  	doTimeline();


	      }




	      google.maps.event.addDomListener(window, 'load', initialize);


	      

			function doTimeline(){


		      	$("div#real-time-Cairo-timeline").load("../versus-cities/getTimeline.php?code=BUDA");


		      	if(timelinetimer!=null){
			  		clearTimeout( timelinetimer );
			  	}

			  	timelinetimer = setTimeout( doTimeline ,50000);


		      }	      


	      function doStats(){


	      	$("div#statistics").load("../versus-cities/getStatsForCity.php?code=BUDA");


	      	if(statstimer!=null){
		  		clearTimeout( statstimer );
		  	}

		  	statstimer = setTimeout( doStats ,12304);


	      }




	      function doRefresh(){

	      	var ss = "../versus-cities/fetchBuda.php";

	      	if(largestID!=""){
	      		ss = ss + "?lid=" + largestID;
	      	}

	      	$.getJSON( ss ,function(data){

	      		
	      		var f = false;

	      		for(var i=0; i<data.results.length; i++){

	      			f = false;
	      			for(var j; j<markers.length && !f ;j++){
	      				if(markers[j].id = data.results[i].id){
	      					f = true;
	      				}
	      			}

	      			if(!f){
	      				var ii = markers.length;
	      				markers[ii] = data.results[i];

	      				if(largestID=="" || largestID<markers[ii].id){
	      					largestID = markers[ii].id;
	      				}

	      				markers[ii].lat = parseFloat( markers[ii].lat );
	      				markers[ii].lng = parseFloat( markers[ii].lng );
	      				if(markers[ii].lat==30.05 && markers[ii].lng==31.2333){

							//markers[ii].lat = markers[ii].lat + (Math.random()*2.0 - 1.0) / 5.0  ;
							//markers[ii].lng = markers[ii].lng + (Math.random()*2.0 - 1.0) / 5.0  ;
							
	      				} else {

	      					var im = {
							    url: markers[ii].profile_image,
							    size: new google.maps.Size(20, 20),
							    origin: new google.maps.Point(0,0),
							    anchor: new google.maps.Point(0, 0)
							  };

		      				markers[ii].marker = new google.maps.Marker({
						      position: new google.maps.LatLng(markers[ii].lat,markers[ii].lng),
						      map: map,
						      title:markers[ii].t,
						      icon: im //"realtime-cairo-marker.png"
						  	});
						  	attachWindow(markers[ii]);
	      				}

	      			}

	      		}


	      		if(markers.length>500){
	      			for(var ii=0; ii<20 ; ii++){
	      				if(markers[ii].marker!=null && markers[ii].marker!== undefined ) { markers[ii].marker.setMap(null);	}
	      			}
	      			markers.splice(0,10);
	      		}


	      	});



	      	if(refreshtimeout!=null){
		  		clearTimeout( refreshtimeout );
		  	}

		  	refreshtimeout = setTimeout( doRefresh ,8011);

	      }

	      function doUpdate(){

	      	$("div#updater").load("../versus-cities/harvestBuda.php",function(){
	      		if(updatetimeout!=null){
			  		clearTimeout( updatetimeout );
			  	}

			  	updatetimeout = setTimeout( doUpdate ,15703);
	      	});

	      }


			function attachWindow(o) {

				//console.log(o.txt);

	      		var cnt = "<img src='" + o.profile_image + "' border='0' width='40' height='40' /><h3 class='h3popup'>" + o.t + "</h3><p class='ppopup'>" + o.txt  + "</p>";
	      		

			  //var infowindow = new google.maps.InfoWindow(
			  //    { content: cnt,
			  //      size: new google.maps.Size(50,50)
			  //    });
			  google.maps.event.addListener(o.marker, 'click', function() {
			    
			    infowindow.setContent(cnt);
			    infowindow.open(map,o.marker);

			  });
			}



			var maxTagFontSize = 22;

			function doTags(){


				$.getJSON("../versus-cities/getTagCloudForCity.php?code=BUDA",function(data){


					var stringa = "";
					var dimensione = 2;
					
					$.each(data, function(parola, val) {
					
						//alert(data["parola"]);
					
						dimensione = 2 + maxTagFontSize * parseFloat(val) ;
							
						stringa = 
								stringa + 
								"<div class='tagCloudBox' style='font-size: " + 
								dimensione + 
								"px'>" +  
								parola + 
								"</div>";
						
					});
				
					$("div#tag-cloud").html(stringa);


					
				});

				if(tagcloudtimer!=null){
				  		clearTimeout( tagcloudtimer );
				}

				tagcloudtimer = setTimeout( doTags ,8007);

			}


	      function decode_utf8(s) {
			  return decodeURIComponent(escape(s));
			}

	    </script>
	</head>
	<body>
		<div id='mapholder'></div>

		<div id='real-time-Cairo-title'>
			<h1>Real Time Budapest</h1>
			<p>What is happening in Cairo right now?</p>
			<a href='http://www.artisopensource.net' title='Art is Open Source' alt='Art is Open Source'>&laquo; Back to AOS</a>
		</div>
		<div id='real-time-Cairo-timeline'></div>
		<div id='tag-cloud'></div>
		<div id='statistics'></div>

		<div id="updater" style="display:none;"></div>
		
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-387817-3']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
	</body>
</html>