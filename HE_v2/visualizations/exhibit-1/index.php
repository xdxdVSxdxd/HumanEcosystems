<?php header('Content-Type: text/html; charset=utf-8'); ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="it" xml:lang="it" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xmlns:og="http://opengraphprotocol.org/schema/">
	<head>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<meta charset="utf-8" />
		<style>
	    	html,body,#mapholder{
	    		width: 100%;
	    		height: 100%;
	    		padding: 0px;
	    		margin: 0px;
	    	}
        #mapholder{
          position: relative;
          z-index: 100;
        }
        #textholder{
          position: absolute;
          width: 100%;
          height: 100%;
          padding: 0px;
          margin: 0px;
          z-index: 999;
          top: 0px;
          left: 0px;
          background: #000000;
          color: #FFFFFF;
          font: 200px serif;
          text-align: center;
        }
        #textholderwrapper{
          background: #000000;
          color: #FFFFFF;
          font: 120px serif;
          text-align: center;
          margin: 0px;
          padding: 60px;
          overflow: hidden;
        }
	    	#mapholder{
	    		width: 100%;
	    		height: 100%;
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
	    </style>
	    <script type="text/javascript" charset="utf-8" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBoQFDqTY52IIrAVtLvTZr2CMXZEm0CEH4&sensor=false"></script>
      <script src="jquery-2.1.3.min.js"></script>
	    <script type="text/javascript" charset="utf-8" >
	    	var map;

        var project;

        var markers;

        var randomMarkers;

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
              { "color": "#000000" }
            ]
          },{
            "featureType": "administrative",
            "elementType": "geometry",
            "stylers": [
              { "visibility": "on" }
            ]
          },{
            "featureType": "road",
            "elementType": "geometry",
            "stylers": [
              { "visibility": "on" },
              { "color": "#161313" },
              { "weight": 0.1 }
            ]
          },{
            "featureType": "transit",
            "elementType": "geometry",
            "stylers": [
              { "visibility": "on" }
            ]
          },{
            "featureType": "poi",
            "elementType": "geometry",
            "stylers": [
              { "visibility": "on" },
              { "color": "#B0B0B0" }
            ]
          }
        ];



			var styledMap = new google.maps.StyledMapType(styles, {name: "Serenade Map"});

			function initialize() {

            project = getUrlParameter("w");

            markers = new Array();

            randomMarkers = new Array();

		        var mapOptions = {
              center: new google.maps.LatLng(0, 0),
		          zoom: 3,
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

            if(timerUpdater!=null){
              clearTimeout(timerUpdater);
            }
            timerUpdater = setTimeout(getRecentContentsForMap, timerDelay);

            getRandomContentsForMap();

            fadeOutText();            

			}

      var fadeOutText = function(){
        $("#textholder").fadeOut("slow");
      }

      var fadeInText = function(){
        $("#textholder").fadeIn("slow");
      }

      var timerDelay = 5000;
      var timerDelay2 = 3000;

      var timerUpdater = null;

      var timerRandomMarker = null;


      var getRandomContentsForMap = function(){
        $.getJSON("../../API/getRandomGeoLocMessage.php?w=" + project)
            .done(function(data){


              for(var i = 0; i<data.length; i++){
                  var aLatLng = new google.maps.LatLng(data[i].lat,data[i].lng);
                  var found = false;


                  $("#textholderwrapper").css("font-size" , (200-data[i].txt.length) + "px");
                  $("#textholderwrapper").text( data[i].txt  );

                  for(var j = 0; j<randomMarkers.length && !found; j++){

                    if(randomMarkers[j].getPosition().lat()==aLatLng.lat() && randomMarkers[j].getPosition().lng()==aLatLng.lng()){
                      found = true;

                      var m = randomMarkers[j];

                      randomMarkers.splice(j,1);

                      m.setIcon({
                        path: google.maps.SymbolPath.CIRCLE,
                        fillColor: '#F00080',
                        fillOpacity: 0.8,
                        strokeColor: '#E00080',
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        scale: Math.min(eval(data[i].c)*3 , 30)
                      });

                      m.setAnimation(google.maps.Animation.DROP);

                      randomMarkers.push( m );
                    }

                  }

                  if(!found){
                    var marker = new google.maps.Marker({
                        position: aLatLng,
                        map: map,
                        title: data[i].nick,
                        icon: {
                          path: google.maps.SymbolPath.CIRCLE,
                          fillColor: '#F00080',
                          fillOpacity: 0.8,
                          strokeColor: '#E00080',
                          strokeOpacity: 0.8,
                          strokeWeight: 2,
                          scale: Math.min(eval(data[i].c)*3 , 30)
                        },
                        animation: google.maps.Animation.DROP
                    });

                    google.maps.event.addListener(marker, 'click', markerClickHandler );

                    randomMarkers.push(marker);  
                  }

                  if(randomMarkers.length>500){
                    var m = randomMarkers.splice(0,1);
                    m.setMap(null);
                    m = null;
                  }


                }

                setTimeout( fadeInText, 1000);
                setTimeout( fadeOutText, 2000);



              if(timerRandomMarker!=null){
                  clearTimeout(timerRandomMarker);
                }
                timerRandomMarker = setTimeout(getRandomContentsForMap, timerDelay2);
            })
            .fail(function( jqxhr, textStatus, error ){
                //fare qualcosa in caso di fallimento

                if(timerRandomMarker!=null){
                  clearTimeout(timerRandomMarker);
                }
                timerRandomMarker = setTimeout(getRandomContentsForMap, timerDelay2);
            });

      };

      var getRecentContentsForMap = function(){

        $.getJSON("../../API/getContentForMap.php?w=" + project)
            .done(function(data){

                // insert markers on map
                //console.log(data);

                for(var i = 0; i<data.length; i++){
                  var aLatLng = new google.maps.LatLng(data[i].lat,data[i].lng);
                  var found = false;

                  for(var j = 0; j<markers.length && !found; j++){

                    if(markers[j].getPosition().lat()==aLatLng.lat() && markers[j].getPosition().lng()==aLatLng.lng()){
                      found = true;

                      var m = markers[j];

                      markers.splice(j,1);

                      m.setIcon({
                        path: google.maps.SymbolPath.CIRCLE,
                        fillColor: '#F08000',
                        fillOpacity: 0.8,
                        strokeColor: '#E07000',
                        strokeOpacity: 0.8,
                        strokeWeight: 2,
                        scale: Math.min(eval(data[i].c)*3 , 30)
                      });

                      m.setAnimation(google.maps.Animation.DROP);

                      markers.push( m );
                    }

                  }

                  if(!found){
                    var marker = new google.maps.Marker({
                        position: aLatLng,
                        map: map,
                        title: data[i].name,
                        icon: {
                          path: google.maps.SymbolPath.CIRCLE,
                          fillColor: '#F08000',
                          fillOpacity: 0.8,
                          strokeColor: '#E07000',
                          strokeOpacity: 0.8,
                          strokeWeight: 2,
                          scale: Math.min(eval(data[i].c)*3 , 30)
                        },
                        animation: google.maps.Animation.DROP
                    });

                    google.maps.event.addListener(marker, 'click', markerClickHandler );

                    markers.push(marker);  
                  }

                  if(markers.length>1500){
                    var m = markers.splice(0,1);
                    m.setMap(null);
                    m = null;
                  }


                }


                if(timerUpdater!=null){
                  clearTimeout(timerUpdater);
                }
                timerUpdater = setTimeout(getRecentContentsForMap, timerDelay);
                
            })
            .fail(function( jqxhr, textStatus, error ){
                //fare qualcosa in caso di fallimento

                if(timerUpdater!=null){
                  clearTimeout(timerUpdater);
                }
                timerUpdater = setTimeout(getRecentContentsForMap, timerDelay);
            });

      };

			google.maps.event.addDomListener(window, 'load', initialize);

      var infoWindow;
      var currentMarker;


      var markerClickHandler = function(){
        // do something
        //console.log(this);

        var clickedLat = this.position.lat();
        var clickedLng = this.position.lng();

        currentMarker = this;


        $.getJSON("../../API/getContentRecentNearby.php" , { 'w' : project, 'lat' : clickedLat , 'lng' : clickedLng , "rad" : 0.002 })
        .done(function(data){

            //console.log(data);

            var contentString = "";

            for(var i = 0; i<data.length; i++){
              contentString = contentString + "<a target='_blank' href='" + data[i].link + "'><div class='infowdiv'><strong>" + data[i].nick + ":</strong>" + data[i].txt + "</div></a>";
            }

            if(infoWindow!=null){
              infoWindow.close();
            }


              infoWindow = new google.maps.InfoWindow({
                content: contentString,
                maxWidth: 400
              });

            infoWindow.open(map,currentMarker);
            
        })
        .fail(function( jqxhr, textStatus, error ){
            //fare qualcosa in caso di fallimento
        });




      }


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

	    </script>
	</head>
	<body>
		<div id='mapholder'></div>
    <div id='textholder'><div id='textholderwrapper'></div></div>
	</body>
</html>