var map;

var heatmaps;

var legend;

        var project;

        var styles = [
  {
    "stylers": [
      { "visibility": "off" }
    ]
  },{
    "featureType": "administrative",
    "elementType": "geometry",
    "stylers": [
      { "visibility": "on" }
    ]
  },{
    "featureType": "landscape",
    "elementType": "geometry",
    "stylers": [
      { "visibility": "on" },
      { "color": "#000000" }
    ]
  },{
    "featureType": "poi",
    "elementType": "geometry",
    "stylers": [
      { "visibility": "on" },
      { "color": "#222222" }
    ]
  },{
    "featureType": "road",
    "elementType": "geometry",
    "stylers": [
      { "visibility": "on" },
      { "color": "#444444" }
    ]
  },{
    "featureType": "transit",
    "elementType": "geometry",
    "stylers": [
      { "visibility": "on" },
      { "color": "#333333" }
    ]
  },{
    "featureType": "water",
    "elementType": "geometry",
    "stylers": [
      { "visibility": "on" },
      { "color": "#000055" }
    ]
  }
];



			var styledMap = new google.maps.StyledMapType(styles, {name: "Serenade Map"});

			function initialize() {

            project = getUrlParameter("w");


            markers = new Array();

		        var mapOptions = {
              center: new google.maps.LatLng(0, 0),
		          zoom: 3,
		          mapTypeId: google.maps.MapTypeId.HYBRID,
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

            //initHeatmaps();

            legend = new Object();
            legend["all"] = "#00FF00";

            initHeatmaps();

			}



      function getContrastYIQ(hexcolor){
          var r = parseInt(hexcolor.substr(1,2),16);
          var g = parseInt(hexcolor.substr(3,2),16);
          var b = parseInt(hexcolor.substr(4,2),16);
          var yiq = ((r*299)+(g*587)+(b*114))/1000;
          return (yiq >= 128) ? 'black' : 'white';
      }


      function initHeatmaps(){

        heatmaps = new Object();
        heatmaps["all"] = new google.maps.visualization.HeatmapLayer({ map: map });
        heatmaps["all"].setOptions( {radius: 1, opacity: 1.0, dissipating: false });
        //heatmaps["all"].setOptions( {gradient: [  'rgba(255,255,255,0)' , legend["all"]   ]  , radius: 60, opacity: 0.7, dissipating: true });

        getEmotionsForMap();

      }



      function getRandomArbitrary(min, max) {
          return Math.random() * (max - min) + min;
      }


      var timerDelay1 = 5000;
      var timerUpdater1 = null;
      var getEmotionsForMap = function(){

        $.getJSON("../../API/getGeoContentForHeatmap.php?w=" + project)
            .done(function(data){

                // insert markers on map
                console.log(data);

                var datas = new Object();
                datas["all"] = new google.maps.MVCArray();

                for(var i = 0; i<data.length; i++){
                  datas[  "all"  ].push(  { location: new google.maps.LatLng(  parseFloat(data[i].lat) , parseFloat(data[i].lng)   ) , weight: parseFloat(data[i].c) } );

                  /*
                  var marker = new google.maps.Marker({
                    position: {lat: parseFloat(data[i].lat), lng: parseFloat(data[i].lng)},
                    map: map,
                    title: 'i'
                  });
                  */

                  /*
                  if(Math.random()>0.99){

                    var nlat = parseFloat(data[i].lat) + getRandomArbitrary(-0.01,0.01);
                    var nlon = parseFloat(data[i].lng)   + getRandomArbitrary(-0.01,0.01);

                    //console.log(nlat + "," + nlon);

                    datas[  "all"  ].push(  new google.maps.LatLng(  nlat , nlon  )  );
                  }
                  */

                }

                heatmaps["all"].set('data' , datas["all"]);

                /*
                if(timerUpdater1!=null){
                  clearTimeout(timerUpdater1);
                }
                timerUpdater1 = setTimeout(getEmotionsForMap, timerDelay1);
                */
            })
            .fail(function( jqxhr, textStatus, error ){
                //fare qualcosa in caso di fallimento
                /*
                if(timerUpdater1!=null){
                  clearTimeout(timerUpdater1);
                }
                timerUpdater1 = setTimeout(getEmotionsForMap, timerDelay1);
                */
            });

      };

			google.maps.event.addDomListener(window, 'load', initialize);


      function getUrlParameter(sParam)
      {
          var sPageURL = window.location.search.substring(1);
          var sURLVariables = sPageURL.split('&');
          for (var i = 0; i < sURLVariables.length; i++) 
          {
              var sParameterName = sURLVariables[i].split('=');
              if (sParameterName[0] == sParam) 
              {
                  return sParameterName[1];
              }
          }
      }