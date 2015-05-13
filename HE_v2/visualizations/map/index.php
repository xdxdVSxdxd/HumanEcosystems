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

            $.getJSON("../../API/getContentForMap.php?w=" + project)
            .done(function(data){

                // insert markers on map
                //console.log(data);

                for(var i = 0; i<data.length; i++){
                  var aLatLng = new google.maps.LatLng(data[i].lat,data[i].lng);

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
                        scale: Math.min(eval(data[i].c)*10 , 30)
                      }
                  });

                  google.maps.event.addListener(marker, 'click', markerClickHandler );

                  markers.push(marker);

                }
                
            })
            .fail(function( jqxhr, textStatus, error ){
                //fare qualcosa in caso di fallimento
            });

			}

			google.maps.event.addDomListener(window, 'load', initialize);

      var infoWindow;
      var currentMarker;


      var markerClickHandler = function(){
        // do something
        //console.log(this);

        var clickedLat = this.position.lat();
        var clickedLng = this.position.lng();

        currentMarker = this;


        $.getJSON("../../API/getContentNearby.php" , { 'w' : project, 'lat' : clickedLat , 'lng' : clickedLng , "rad" : 0.2 })
        .done(function(data){

            //console.log(data);

            var contentString = "";

            for(var i = 0; i<data.length; i++){
              contentString = contentString + "<a target='_blank' href='" + data[i].link + "'><div class='infowdiv'><strong>" + data[i].nick + ":</strong>" + data[i].txt + "</div></a>";
            }

            if(infoWindow){
              infoWindow.close();
            }

              infowindow = new google.maps.InfoWindow({
                content: contentString,
                maxWidth: 400
              });

            infowindow.open(map,currentMarker);
            
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
	</body>
</html>