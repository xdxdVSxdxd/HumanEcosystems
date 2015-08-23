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
      { "color": "#ffffff" }
    ]
  },{
    "featureType": "poi",
    "elementType": "geometry",
    "stylers": [
      { "visibility": "on" },
      { "color": "#e7e7e4" }
    ]
  },{
    "featureType": "road",
    "elementType": "geometry",
    "stylers": [
      { "visibility": "on" },
      { "color": "#cfced2" }
    ]
  },{
    "featureType": "transit",
    "elementType": "geometry",
    "stylers": [
      { "visibility": "on" },
      { "color": "#878597" }
    ]
  },{
    "featureType": "water",
    "elementType": "geometry",
    "stylers": [
      { "visibility": "on" }
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



            

            
			}


      function initHeatmaps(){

        heatmaps = new Object();


        for(key in legend){
          heatmaps[key] = new google.maps.visualization.HeatmapLayer({ map: map });
          heatmaps[key].setOptions( {gradient: [  'rgba(255,255,255,0)' , legend[key]   ]  , radius: 20 });          
        }

        

        getEmotionsForMap();


        getTimelineEmotions();

      }

      var timerDelay1 = 5000;
      var timerUpdater1 = null;
      var getEmotionsForMap = function(){

        $.getJSON("../../API/getGeoLatestEmotions.php?w=" + project)
            .done(function(data){

                // insert markers on map
                //console.log(data);

                var datas = new Object();
                datas["Love"] = [];
                datas["Anger"] = [];
                datas["Disgust"] = [];
                datas["Boredom"] = [];
                datas["Fear"] = [];
                datas["Hate"] = [];
                datas["Joy"] = [];
                datas["Surprise"] = [];
                datas["Trust"] = [];
                datas["Sadness"] = [];
                datas["Anticipation"] = [];
                datas["Violence"] = [];
                datas["Terror"] = [];

                for(var i = 0; i<data.length; i++){
                  datas[  data[i].label  ].push(  new google.maps.LatLng(  data[i].lat , data[i].lng   )  );
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
                return {date: d.date, temperature: +d[name]};
              })
            };
          });

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

          console.log("[new]");
          
          color.domain(d3.keys(data[0]).filter(function(key) { return key !== "date"; }));

          data.forEach(function(d) {
            d.date = parseDate(d.date);
          });

          var cities = color.domain().map(function(name) {
            return {
              name: name,
              values: data.map(function(d) {
                return {date: d.date, temperature: +d[name]};
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