// set to false if you don't want the test mode
// the test mode introduces some random data so that it can show immediate results right away
var testing = false;

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
      { "color": "#444444" }
    ]
  },{
    "featureType": "road",
    "elementType": "geometry",
    "stylers": [
      { "visibility": "on" },
      { "color": "#555555" }
    ]
  },{
    "featureType": "transit",
    "elementType": "geometry",
    "stylers": [
      { "visibility": "on" },
      { "color": "#666666" }
    ]
  },{
    "featureType": "water",
    "elementType": "geometry",
    "stylers": [
      { "visibility": "on" },
      { "color": "#000066" }
    ]
  }
];



			var styledMap = new google.maps.StyledMapType(styles, {name: "Serenade Map"});

			function initialize() {

            project = getUrlParameter("w");


            markers = new Array();

		        var mapOptions = {
              center: new google.maps.LatLng(45.464161, 9.190336),
		          zoom: 13,
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

            //initHeatmaps();

            legend = new Object();


            $.getJSON("../../API/getEmotionsLegend.php?w=" + project)
            .done(function(data){

                // insert markers on map
                
                for(var i = 0 ; i<data.length ; i++){
                  legend[  data[i].label ] = data[i].color;


                  $("#legend-body").append("<div class='legend-item-holder'><div class='legend-color' style='background: " + data[i].color + "' ></div><div class='legend-lebel'>" + data[i].label + "</div></div>");

                }
                


                // e poi chiamare gli stadi successivi di init
                initHeatmaps();

            })
            .fail(function( jqxhr, textStatus, error ){
                //fare qualcosa in caso di fallimento
            });


            getRandomUser();
            

            
			}


      function getRandomArbitrary(min, max) {
          return Math.random() * (max - min) + min;
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


        for(key in legend){
          heatmaps[key] = new google.maps.visualization.HeatmapLayer({ map: map });
          heatmaps[key].setOptions( {gradient: [  'rgba(255,255,255,0)' , legend[key]   ]  , radius: 70, opacity: 0.4, dissipating: true });          
        }

        

        getEmotionsForMap();


        getTimelineEmotions();

        getEmotionalPosts();

      }





      var timerUpdater3 = null;
      var timerDelay3 = 2000;

      var getEmotionalPosts = function(){

        $("#emotinsposts").animate(
          {
            top: "-2000px"
          },500,function(){

              $.getJSON("../../API/getLatestMessagesWithEmotions.php?w=" + project)
              .done(function(data){

                $("#emotinspostscontainer").html("");

                for(var i = 0; i<data.length; i++){

                  var item = "";

                  item = item + "<div class='emotionalpostitem'>";
                  item = item + "<div class='emotionalpostitem-image'><img src='" + data[i].iurl + "' width='20' height='20 border='0' /></div>";
                  item = item + "<div class='emotionalpostitem-user'>" + data[i].nick + "</div>";
                  item = item + "<div class='emotionalpostitem-emotions'>";
                  var parts = data[i].color.split(",");
                  for(var j = 0; j<parts.length; j++){
                    item = item + "<div class='emotionitem-block' style='background: " + parts[j] + "'></div>";
                  }

                  item = item + "</div>";
                  item = item + "</div>";


                  $("#emotinspostscontainer").append(item);


                  $("#emotinsposts").animate(
                    {
                      top: "10px"
                    },500,function(){

                       if(timerUpdater3!=null){
                          clearTimeout(timerUpdater3);
                        }
                        timerUpdater3 = setTimeout(getEmotionalPosts, timerDelay3);
                    }
                  );

                }
                  
              })
              .fail(function( jqxhr, textStatus, error ){
                  //fare qualcosa in caso di fallimento

                  if(timerUpdater3!=null){
                    clearTimeout(timerUpdater3);
                  }
                  timerUpdater3 = setTimeout(getEmotionalPosts, timerDelay3);
              });


          }
        );

      };



      var timerUpdater2 = null;
      var timerDelay2 = 2000;

      var getRandomUser = function(){

        $("#randomuser").animate(
          {
            top: "-300px"
          },500,function(){

              $.getJSON("../../API/getRandomMessageWithEmotion.php?w=" + project)
              .done(function(data){


                $("#randomuserimage").html("<img src='" + data[0].iurl + "' border='0' />");
                $("#randomusernick").html(data[0].nick);
                $("#randomusertext").html(data[0].txt);
                $("#randomuser").css("background",data[0].color);
                $("#randomuser").css("color",getContrastYIQ(data[0].color));


                $("#randomuser").animate(
                  {
                    top: "10px"
                  },500,function(){

                     if(timerUpdater2!=null){
                        clearTimeout(timerUpdater2);
                      }
                      timerUpdater2 = setTimeout(getRandomUser, timerDelay2);
                  }
                );
                  
              })
              .fail(function( jqxhr, textStatus, error ){
                  //fare qualcosa in caso di fallimento

                  if(timerUpdater1!=null){
                    clearTimeout(timerUpdater1);
                  }
                  timerUpdater1 = setTimeout(getRandomUser, timerDelay1);
              });


          }
        );

      };




      var timerDelay1 = 5000;
      var timerUpdater1 = null;
      var getEmotionsForMap = function(){

        $.getJSON("../../API/getGeoLatestEmotions.php?w=" + project)
            .done(function(data){

                // insert markers on map
                //console.log(data);

                var datas = new Object();
                datas["Love"] = new google.maps.MVCArray();
                datas["Anger"] = new google.maps.MVCArray();
                datas["Disgust"] = new google.maps.MVCArray();
                datas["Boredom"] = new google.maps.MVCArray();
                datas["Fear"] = new google.maps.MVCArray();
                datas["Hate"] = new google.maps.MVCArray();
                datas["Joy"] = new google.maps.MVCArray();
                datas["Surprise"] = new google.maps.MVCArray();
                datas["Trust"] = new google.maps.MVCArray();
                datas["Sadness"] = new google.maps.MVCArray();
                datas["Anticipation"] = new google.maps.MVCArray();
                datas["Violence"] = new google.maps.MVCArray();
                datas["Terror"] = new google.maps.MVCArray();

                for(var i = 0; i<data.length; i++){
                  datas[  data[i].label  ].push(  new google.maps.LatLng(  data[i].lat , data[i].lng   )  );


                  if(Math.random()>0.99){

                    var nlat = parseFloat(data[i].lat) + getRandomArbitrary(-0.01,0.01);
                    var nlon = parseFloat(data[i].lng)   + getRandomArbitrary(-0.01,0.01);

                    //console.log(nlat + "," + nlon);

                    datas[  data[i].label  ].push(  new google.maps.LatLng(  nlat , nlon  )  );
                  }

                }

                heatmaps["Love"].setData(datas["Love"]);
                heatmaps["Anger"].setData(datas["Anger"]);
                heatmaps["Disgust"].setData(datas["Disgust"]);
                heatmaps["Boredom"].setData(datas["Boredom"]);
                heatmaps["Fear"].setData(datas["Fear"]);
                heatmaps["Hate"].setData(datas["Hate"]);
                heatmaps["Joy"].setData(datas["Joy"]);
                heatmaps["Surprise"].setData(datas["Surprise"]);
                heatmaps["Trust"].setData(datas["Trust"]);
                heatmaps["Sadness"].setData(datas["Sadness"]);
                heatmaps["Anticipation"].setData(datas["Anticipation"]);
                heatmaps["Violence"].setData(datas["Violence"]);
                heatmaps["Terror"].setData(datas["Terror"]);


                if(timerUpdater1!=null){
                  clearTimeout(timerUpdater1);
                }
                timerUpdater1 = setTimeout(getEmotionsForMap, timerDelay1);
                
            })
            .fail(function( jqxhr, textStatus, error ){
                //fare qualcosa in caso di fallimento

                if(timerUpdater1!=null){
                  clearTimeout(timerUpdater1);
                }
                timerUpdater1 = setTimeout(getEmotionsForMap, timerDelay1);
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



   /*
    TIMELINE START
   */

   
        var margin = {top: 20, right: 80, bottom: 30, left: 50};

        var width = $("#bottom-diagrams").width() - margin.left - margin.right,
        height = $("#bottom-diagrams").height() - margin.top - margin.bottom;
            

        var parseDate = d3.time.format("%Y%m%d%H%M").parse;

        var x = d3.time.scale()
            .range([0, width]);

        var y = d3.scale.linear()
            .range([height, 0]);

        //var color = d3.scale.category10();

        var ll = new Array();
        var cc = new Array();

        for(var key in legend){
          if(legend.hasOwnProperty(key)){
            ll.push(key);
            cc.push(legend[key]);
          }
        }

        var color = d3.scale.ordinal()
                  .domain(ll)
                  .range(cc);


        var xAxis = d3.svg.axis()
            .scale(x)
            .orient("bottom");

        var yAxis = d3.svg.axis()
            .scale(y)
            .orient("left");

        var line = d3.svg.line()
            .interpolate("basis")
            .x(function(d) { return x(d.date); })
            .y(function(d) { return y(d.temperature); });

        var svg;


      function getRandomArbitrary(min, max) {
          return Math.random() * (max - min) + min;
      }

      var arbitraries = new Object();

      function getTimelineEmotions(){

        
        width = $("#bottom-diagrams").width() - margin.left - margin.right;
        height = $("#bottom-diagrams").height() - margin.top - margin.bottom;
            

        parseDate = d3.time.format("%Y%m%d%H%M").parse;

        x = d3.time.scale()
            .range([0, width]);

        y = d3.scale.linear()
            .range([height, 0]);



        var ll = new Array();
        var cc = new Array();

        for(var key in legend){
          if(legend.hasOwnProperty(key)){
            ll.push(key);
            cc.push(legend[key]);
          }
        }

        color = d3.scale.ordinal()
                  .domain(ll)
                  .range(cc);


        xAxis = d3.svg.axis()
            .scale(x)
            .orient("bottom");

        yAxis = d3.svg.axis()
            .scale(y)
            .orient("left");

        line = d3.svg.line()
            .interpolate("basis")
            .x(function(d) { return x(d.date); })
            .y(function(d) { return y(d.temperature); });


        svg = d3.select("#emo-timeline-contained").append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
          .append("g")
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")");


        d3.tsv("../../API/getEmotionsTimeline.php?w=" + project, function(error, data) {
          if (error) throw error;

          
          color.domain(d3.keys(data[0]).filter(function(key) { return key !== "date"; }));

          data.forEach(function(d) {
            d.date = parseDate(d.date);
          });

          var cities = color.domain().map(function(name) {
            return {
              name: name,
              values: data.map(function(d) {
                var rnd = 0;

                if(testing){
                  rnd = getRandomArbitrary(0,3);
                }

                arbitraries[name + d.date] = rnd;

                return {date: d.date, temperature: +(d[name]+rnd)};
              })
            };
          });

          if(Object.keys( arbitraries ).length>2000){
            while(Object.keys( arbitraries ).length>2000){
              console.log("remove");
              var props = Object.keys( arbitraries );
              delete arbitraries[props[0]];
            }
          }

          x.domain(d3.extent(data, function(d) { return d.date; }));

          y.domain([
            d3.min(cities, function(c) { return d3.min(c.values, function(v) { return v.temperature; }); }),
            d3.max(cities, function(c) { return d3.max(c.values, function(v) { return v.temperature; }); })
          ]);

          svg.append("g")
              .attr("class", "x axis")
              .attr("transform", "translate(0," + height + ")")
              .call(xAxis);

          svg.append("g")
              .attr("class", "y axis")
              .call(yAxis)
            .append("text")
              .attr("transform", "rotate(-90)")
              .attr("y", 6)
              .attr("dy", ".71em")
              .style("text-anchor", "end")
              .text("");

          var city = svg.selectAll(".city")
              .data(cities)
            .enter().append("g")
              .attr("class", "city");

          city.append("path")
              .attr("class", "line")
              .attr("d", function(d) { return line(d.values); })
              .style("stroke", function(d) { return color(d.name); });

          /*
          city.append("text")
              .datum(function(d) { return {name: d.name, value: d.values[d.values.length - 1]}; })
              .attr("transform", function(d) { return "translate(" + x(d.value.date) + "," + y(d.value.temperature) + ")"; })
              .attr("x", 3)
              .attr("dy", ".35em")
              .text(function(d) { return d.name; });
          */

        });


            
            
            var inter = setInterval(function() {
                    updateTimelineData();
            }, 5000);
            

      }



function updateTimelineData(){




        
      d3.tsv("../../API/getEmotionsTimeline.php?w=" + project, function(error, data) {
          if (error) throw error;
          
          color.domain(d3.keys(data[0]).filter(function(key) { return key !== "date"; }));

          data.forEach(function(d) {
            d.date = parseDate(d.date);
          });

          var cities = color.domain().map(function(name) {
            return {
              name: name,
              values: data.map(function(d) {


                var rnd = 0;

                if(testing){


                  if(arbitraries[name + d.date]){
                    rnd = arbitraries[name + d.date];
                  } else {
                    rnd = getRandomArbitrary(0,3);
                  }
                
                  arbitraries[name + d.date] = rnd;

                }

                return {date: d.date, temperature: +(d[name]+rnd)};
              })
            };
          });


          x.domain(d3.extent(data, function(d) { return d.date; }));

          y.domain([
            d3.min(cities, function(c) { return d3.min(c.values, function(v) { return v.temperature; }); }),
            d3.max(cities, function(c) { return d3.max(c.values, function(v) { return v.temperature; }); })
          ]);

          // DA QUI

          var newcities = svg.selectAll(".city")
          .data(cities);

          
          newcities
            .select( ".line" )
            .transition() 
            .ease("linear")
            .duration(750) 
            .attr( "d", function(d) { 
              return line(d.values); 
            });

          svg.select(".x.axis")
            .transition()
            .duration(750)
            .ease("linear")
            .call(xAxis);

          svg.select(".y.axis")
            .transition()
            .duration(750)
            .ease("linear")
            .call(yAxis); 


          // A QUI


          /*
          xAxis = d3.svg.axis()
            .scale(x)
            .orient("bottom");

          yAxis = d3.svg.axis()
              .scale(y)
              .orient("left");


          line = d3.svg.line()
            .interpolate("basis")
            .x(function(d) { return x(d.date); })
            .y(function(d) { return y(d.temperature); });


          var svg = d3.select("#emo-timeline-contained").transition();

          
          svg.select(".x .axis")
              .duration(750)
              .call(xAxis);
          
          
          svg.select(".y .axis")
              .duration(750)
              .call(yAxis);
          

          
          var city = svg.selectAll(".city");

          

          city.select("path.line")
              .attr("d", function(d) { return line(d.values); })
              .duration(750);
          */

          /*
          city.append("text")
              .datum(function(d) { return {name: d.name, value: d.values[d.values.length - 1]}; })
              .attr("transform", function(d) { return "translate(" + x(d.value.date) + "," + y(d.value.temperature) + ")"; })
              .attr("x", 3)
              .attr("dy", ".35em")
              .text(function(d) { return d.name; });
          */


        });



}

  /*
    TIMELINE END
   */