<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html  xmlns="http://www.w3.org/1999/xhtml">
  <head profile="http://gmpg.org/xfn/11">
	<!-- Change this if you want to allow scaling -->
    <meta name="viewport" content="width=default-width; user-scalable=no" />

    <meta http-equiv="Content-type" content="text/html; charset=utf-8">
    
    <style type="text/css">
		html { height: 100% }
		body { height: 100%; margin: 0px; padding: 0px }
		#map_canvas { 
			position: absolute;
			top: 0px;
			left: 0px;
			height: 100%; 
			z-index: 100;
		}


	</style>
    <script type="text/javascript" charset="utf-8" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script type="text/javascript"
		src="http://maps.google.com/maps/api/js?v=3.exp&libraries=visualization">
	</script>




<script type="text/javascript">
	

	var geocoder;
	
	var map;
	var latlng;
	var pointarray, heatmap;
	
	
	var styles =

[
  {
    "stylers": [
      { "visibility": "off" }
    ]
  },{
    "featureType": "water",
    "elementType": "geometry",
    "stylers": [
      { "visibility": "on" },
      { "color": "#FFFFFF" }
    ]
  },
  {
    "featureType": "landscape",
    "elementType": "geometry.fill",
    "stylers": [
      { "visibility": "on" },
      { "color": "#000000" },
      { "saturation": -83 }
    ]
  }
]
;


var customMapType = new google.maps.StyledMapType(styles, {name: "custom"});
var markersdata = new Array();
var markers = new Array();
var markerkeys = new Array();
var heatmappoints = new Array();
	
	function initialize() {
		geocoder = new google.maps.Geocoder();
		latlng = new google.maps.LatLng(20, 0);
		var myOptions = {
			zoom: 2,
			center: latlng,
			mapTypeControl: false,
			overviewMapControl: false,
			panControl: false,
			scaleControl: false,
			scrollwheel: false,
			streetViewControl: false,
			zoomControl: false,
			mapTypeId: "custom" //google.maps.MapTypeId.HYBRID
		};
		map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
		map.mapTypes.set('custom', customMapType);


		var pointArray = new google.maps.MVCArray(heatmappoints);

  		heatmap = new google.maps.visualization.HeatmapLayer({
    		data: pointArray,
    		radius: 12
  		});

  		heatmap.setMap(map);
		updatemarkers();
	
	}
	
	var i = 0;
	var words = new Array();
	words[0] = 'dream';
	words[1] = 'sogno';
	words[2] = 'sueño';
	words[3] = 'النوم';
	words[4] = '睡眠';
	words[5] = '수면';
	words[6] = 'sommeil';
	words[7] = 'スリープ';
	words[8] = 'sömn';
	words[9] = 'schlaf';
	words[10] = 'uyku';
	
	
			var fla = -90;
			var tla = 90;
			
			var flo = -180;
			var tlo = 180;
			
			
			var step = 2;
			
			
			var ilat = fla + Math.floor(Math.random()*181);
			var ilon = flo + Math.floor(Math.random()*361); 
	
	
	
	function updatemarkers(){
	
		$.getJSON(
			"updatemarkers.php",
			{
				'words': 'txt LIKE "%water%"'
			},
			function(data){
		
			//console.log(data);
			
			
			//console.log("ARRIVATI!\n\n\n");


			
			for(var im=0; im<data.results.length; im++){
			
				var mk = data.results[im];
			
				
				var ll= new google.maps.LatLng(mk.lat, mk.lng);
				
				if(!markers[mk.id]){
					markerkeys.push( mk.id );
				}
				
				var llhm = new google.maps.LatLng(mk.lat, mk.lng);
				llhm.mkid = mk.id;
				heatmap.data.push( llhm );
			
			}
			
			
			if(stillfirst){
			
				stillfirst = false;
				//discourse();
			}
		
		});
		
		setTimeout("updatemarkers()",4000);
	
	
	}
	
	
	
	function onBodyLoad(){
	
		initialize();
		
	}	
</script>
</head>
<body onload="onBodyLoad()">
<div id="map_canvas" style="width:100%; height:100%"></div>
<div id="storer" style="display:none"></div>
<div id="loader" style="display:none"></div>
</body>
</html>
