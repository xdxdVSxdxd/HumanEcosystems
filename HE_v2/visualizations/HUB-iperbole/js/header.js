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
              center: new google.maps.LatLng(44.5075, 11.351389),
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


            //getRandomUser();
            

            
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
          heatmaps[key].setOptions( {gradient: [  'rgba(0,0,0,0)' , legend[key]   ]  , radius: 70, opacity: 0.4, dissipating: true });          
        }


        genTagCloud();

        genWordGraph();
        

        getEmotionsForMap();


        getTimelineEmotions();

        getEmotionalPosts();

        graph = new myGraph("#results");

        getLatestUsers(true);

      }

      var timerUpdater3 = null;
      var timerDelay3 = 2000;

      var getEmotionalPosts = function(){

        $("#emotinsposts").animate(
          {
            opacity: 0.0
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
                      opacity: 1.0
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
            opacity: 0.0
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
                    opacity: 1.0
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


                  if(Math.random()>0.99 && testing){

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





/*
TAGCLOUD START
*/
      var tcbleed, tcwidth, tcheight;
      var tcpack;
      var tcsvg;


      var timertc = null;
      var delaytc = 30000;

      var genTagCloud = function(){

        tcbleed = 100;
        tcwidth = $("#tagcloudcontainer").width();
        tcheight = $("#tagcloudcontainer").height();

        $("#tagcloudcontainer").animate({ opacity: "0" },1000,function(){

          //

            $("#tagcloudcontainer").html("");

            tcpack = d3.layout.pack()
            .sort(null)
            .size([tcwidth, tcheight + tcbleed * 2])
            .padding(2);

            tcsvg = d3.select("#tagcloudcontainer").append("svg")
            .attr("width", tcwidth)
            .attr("height", tcheight)
            .append("g")
            .attr("transform", "translate(0," + -tcbleed + ")");

            d3.json("../../API/getMostImportantWords.php?w=" + project, function(error, json) {
            //d3.json("README.json", function(error, json) {
              if (error) throw error;

              //console.log(json);

              json.children.forEach(function(ch){
                ch.n = +ch.n;
              });          

              var node = tcsvg.selectAll(".node")
                .data(tcpack.nodes(json)
                .filter(function(d) { return !d.children; }))
                .enter().append("g")
                .attr("class", "node")
                .attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });

              node.append("circle")
                .attr("class" , "tccircle")
                .attr("r", function(d) { return d.r; });

              node.append("text")
                .text(function(d) { return d.name; })
                .attr("class" , "tctext")
                .style("font-size", function(d) { var vv = (2 * d.r - 8) / this.getComputedTextLength() * 24; if(vv<0){vv=0;} var v = Math.min(2 * d.r, vv); if(v<0){v=0;} return v + "px"; })
                .attr("dy", ".35em");

                    $("#tagcloudcontainer").animate({ opacity: "1" },1000,function(){
                      if( timertc!=null){
                        clearTimeout(timertc);
                      }
                      timertc = setTimeout(genTagCloud, delaytc );
                    });

            });//d3.json


          // animate


        });        


            
        

      };




      function flatten(root) {
        var nodes = [];

        function recurse(node) {
          if (node.children) node.children.forEach(recurse);
          else nodes.push({name: node.name, value: node.size});
        }

        recurse(root);
        return {children: nodes};
      }





      var wgwidth, wgheight;
      var wgcolor;
      var wgforce;
      var wgggsvg;
      var maxn = 1;

      var genWordGraph = function(){

        wgwidth = $("#wordgraphcontainer").width();
        wgheight = $("#wordgraphcontainer").height();

        wgcolor = d3.scale.category20();

        wgforce = d3.layout.force()
          .linkDistance(40)
          .linkStrength(0.5)
          .charge(-90)
          .size([wgwidth, wgheight]);

        $("#wordgraphcontainer").html("");

        wgggsvg = d3.select("#wordgraphcontainer").append("svg")
          .attr("width", wgwidth)
          .attr("height", wgheight);

        renderWordGraph();

      };

      var minnn = 2;
      var maxnn = 4;

      var timergraph = null;
      var timergraphdelay = 10000;

      var renderWordGraph = function(){

        $("#wordgraphcontainer").fadeOut(function(){


          var numero = Math.floor(Math.random() * (maxnn - minnn + 1)) + minnn;

          d3.json("../../API/getNWordsAndConnectionsGraph.php?w=" + project + "&n=" + numero, function(error, data) {
            if (error) throw error;

            var meta = data.meta;

            var title = ""
            for(var i = 0 ; i<meta.length; i++){
              title = title + " <strong>" + meta[i].word + "</strong>";
              if(i<(meta.length-1)){
                title = title + " vs";
              }
            }


            $("#wordgraphtitle").html(title);

            var graph = data.graph;

            var nodes = graph.nodes.slice(),
              links = [],
              bilinks = [];

            maxn = 1;

            
            graph.links.forEach(function(link) {
              var s = nodes[link.source],
                  t = nodes[link.target],
                  i = {n: 1, weight: 1}; // intermediate node
              nodes.push(i);
              links.push({source: s, target: i}, {source: i, target: t});
              bilinks.push([s, i, t]);
            });


            nodes.forEach(function(node){
              node.n = +node.n;
              if(node.n>maxn){ maxn = node.n; }
            });


            wgforce
              .nodes(nodes)
              .links(links)
              .start();

            var link = wgggsvg.selectAll(".link")
              .data(bilinks)
              .enter().append("path")
              .attr("class", "link");

            var node = wgggsvg.selectAll(".node")
              .data(graph.nodes);


            var nodeEnter = node
                            .enter()
                            .append("svg:g")
                            .attr("class", "node")
                            .call(wgforce.drag);

            nodeEnter.append("circle")
              .attr("r", function(d){  return 4+(15*d.n/maxn); });
              //.style("fill", function(d) { return wgcolor(d.n); });

            nodeEnter.append("svg:text")
              .attr("class", "nodetext")
              .attr("dx", 12)
              .attr("dy", ".35em")
              .text(function(d) { return d.word });

            node.append("title")
              .text(function(d) { return d.word; });

            wgforce.on("tick", function() {
              link.attr("d", function(d) {
                return "M" + d[0].x + "," + d[0].y + "S" + d[1].x + "," + d[1].y + " " + d[2].x + "," + d[2].y;
              });
              node.attr("transform", function(d) {
                return "translate(" + d.x + "," + d.y + ")";
              });
            });


            $("#wordgraphcontainer").fadeIn(function(){

              // riimpostare il timer
              if( timergraph!=null){
                clearTimeout(timergraph);
              }
              timergraph = setTimeout(genWordGraph, timergraphdelay );

            });



          });


        });



      };

/*
TAGCLOUD END
*/



/*

RELATIONS START

*/

var graph;

function doSearch(clearGraph){
    var searchString = $("input#searchbox").val();
    $.getJSON("getExploreResults.php", { "search" : searchString , "w" : project })
    .done(function(data){

        //console.log(data);

        if(clearGraph){
            graph.removeAllNodes();    
        }
        

        for(var i = 0; i<data.nodes.length; i++){
            var u = {
                "id" : data.nodes[i].id,
                "nick" : data.nodes[i].nick,
                "pu" : data.nodes[i].pu
            };

            graph.addNode(u);
        }

        for(var i = 0; i<data.links.length; i++){

            graph.addLink(data.links[i].source, data.links[i].target, data.links[i].weight);
        }

    })
    .fail(function( jqxhr, textStatus, error ){
        //fare qualcosa in caso di fallimento
    });

}


var timerLU = null;


function getLatestUsers(clearGraph){
    $.getJSON("getTopUsers.php", { "w" : project })
    .done(function(data){

        //console.log(data);

        if(clearGraph){
            graph.removeAllNodes();    
        }
        

        for(var i = 0; i<data.nodes.length; i++){
            var u = {
                "id" : data.nodes[i].id,
                "nick" : data.nodes[i].nick,
                "pu" : data.nodes[i].pu
            };

            if(!graph.findNode(u.id)){
              graph.addNode(u); 
            }
        }

        for(var i = 0; i<data.links.length; i++){

            graph.addLink(data.links[i].source, data.links[i].target, data.links[i].weight);
        }


        if(timerLU!=null){
          clearTimeout(timerLU);
        }
        timerLU = setTimeout("getLatestUsers(false);", 12000);

    })
    .fail(function( jqxhr, textStatus, error ){
        //fare qualcosa in caso di fallimento
        if(timerLU!=null){
          clearTimeout(timerLU);
        }
        timerLU = setTimeout("getLatestUsers(false);", 12000);
    });

}


var parseDate = d3.time.format("%Y %m %d %H:%M").parse;

function myGraph(el) {

    // Add and remove elements on the graph object
    this.addNode = function (obj) {
        nodes.push(obj);
        update();
    }

    this.removeAllNodes = function(){
        var i = 0;
        while(i<nodes.length && nodes.length>0){



            var j = 0;
            var n = nodes[i];
            while (j < links.length) {
                if ((links[j]['source'] === n)||(links[j]['target'] == n)) links.splice(j,1);
                else j++;
            }
            var index = findNodeIndex(n.id);
            if(index !== undefined) {
                nodes.splice(index, 1);
                update();
            }




        }
    }

    this.removeNode = function (id) {
        var i = 0;
        var n = this.findNode(id);
        while (i < links.length) {
            if ((links[i]['source'] === n)||(links[i]['target'] == n)) links.splice(i,1);
            else i++;
        }
        var index = findNodeIndex(id);
        if(index !== undefined) {
            nodes.splice(index, 1);
            update();
        }
    }

    this.addLink = function (sourceId, targetId,c) {
        var sourceNode = this.findNode(sourceId);
        var targetNode = this.findNode(targetId);

        //console.log("--addLink--[" + sourceId + "," + targetId + "]");
        //console.log(sourceNode);
        //console.log(targetNode);

        if((sourceNode !== undefined) && (targetNode !== undefined)) {
            //console.log("[aggiungo]");
            links.push({"source": sourceNode, "target": targetNode, "c": c});
            update();
        }
    }

    this.findNode = function (id) {
        for (var i=0; i < nodes.length; i++) {
            if (nodes[i].id === id)
                return nodes[i]
        };
    }

    var findNodeIndex = function (id) {
        for (var i=0; i < nodes.length; i++) {
            if (nodes[i].id === id)
                return i
        };
    }

    this.getNodes = function(){
        return nodes;
    }

    this.getlinks = function(){
        return links;
    }

    // set up the D3 visualisation in the specified element
    var w = $(el).innerWidth(),
        h = 500; //$(el).innerHeight();

    var vis = this.vis = d3.select(el).append("svg:svg")
        .attr("width", w)
        .attr("height", h)
        //.attr("pointer-events", "all")
        .append("g")
        .call(d3.behavior.zoom().on("zoom", redraw))
        .append("g");

    vis.append('svg:rect')
    .attr('width', 20000)
    .attr('height', 20000)
    .attr('x' , -10000)
    .attr('y', -10000)
    .attr('fill', 'black');

    var force = d3.layout.force()
        .gravity(.05)
        .distance(100)
        .charge(-200)
        .size([w, h]);

    var nodes = force.nodes(),
        links = force.links();

    

    var update = function () {

        var link = vis.selectAll("line.linkexplore")
            .data(links, function(d) { return d.source.id + "-" + d.target.id; });

        link.enter().insert("line")
            .attr("class", "linkexplore")
            .attr("stroke-width", function(d){
                //console.log(d);
                return Math.min(10,d.c);
            });

        link.exit().remove();

        var node = vis.selectAll("g.node")
            .data(nodes, function(d) { return d.id;});

        var nodeEnter = node.enter().append("g")
            .attr("class", "node")
            .on("click",clickedNode)
            .call(force.drag);

        nodeEnter.append("text")
            .attr("class", "nodetextexplore")
            .attr("dx", 12)
            .attr("dy", ".35em")
            .text(function(d) {return d.id});

        nodeEnter.append("circle")
            .attr("class", "circleexplore")
            .attr("cx", "0px")
            .attr("cy", "0px")
            .attr("r" , "5px")
            .attr("width", "16px")
            .attr("height", "16px");

        node.exit().remove();

        force.on("tick", function() {
          link.attr("x1", function(d) { return d.source.x; })
              .attr("y1", function(d) { return d.source.y; })
              .attr("x2", function(d) { return d.target.x; })
              .attr("y2", function(d) { return d.target.y; });

          node.attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });
        });

        // Restart the force layout.
        force.start();
    }

    // Make it all go
    update();
}


var clickedNode = function(d){
    if(d3.event.shiftKey){
        window.open( d.pu  );
    } else if(d3.event.altKey){
        $("input#searchbox").val( d.id  );
        doSearch(true);    
    }else {
        $("input#searchbox").val( d.id  );
        doSearch(false);    
    }
    
};


function redraw (){
      //console.log("zoom", d3.event.translate, d3.event.scale);
        graph.vis.attr("transform", 
                 "translate(" + d3.event.translate + ")" 
                    + " scale(" + d3.event.scale + ")"
                 );
    }




/*

RELATIONS END

*/

(function($) {
  $(function() {
    // logo change refresh
    var logo_ebologna = $('.logo-ebologna img');
    var random = Math.floor((Math.random() * 8) + 1);
    logo_ebologna.attr('src', logo_ebologna.attr('src').replace('1.png', '' + random + '.png'));
    
    var user_tooltips = $('.user-buttons .login a').qtip({
      content: $('#user-tooltip') ,
      hide: {
        fixed: true,
        delay: 300
      },
      style: {
        classes: 'qtip-light'
      },
      position: {
        viewport: $(window),
        adjust: {
            method: 'flipinvert'
        },
        my: 'top center',
        at: 'bottom center',
        target: $('.user-buttons .login a')
      }
    });
    
    var feedback_tooltips = $('.feedback a').qtip({
      content: $('#feedback-tooltip') ,
      hide: {
        fixed: true,
        delay: 300
      },
      style: {
        classes: 'qtip-dark'
      },
      position: {
        viewport: $(window),
        adjust: {
            method: 'flipinvert'
        },
        my: 'top center',
        at: 'bottom center',
        target: $('.feedback a')
      }
    });
    
    var api_user_tooltip = user_tooltips.qtip('api');
    var api_feedback_tooltip = user_tooltips.qtip('api');
    
    $('.user-buttons .picture').mouseover(function() {
      if(($(window)).width() < 767) {
        api_user_tooltip.set('position.target', $('.user-buttons .picture'));
      }
      else {
        api_user_tooltip.set('position.target', $('.user-buttons .login a'));
      }
      api_feedback_tooltip.hide();
      api_user_tooltip.show();
    });
    
    $('.feedback').mouseover(function() {
      api_user_tooltip.hide();
    });


    initialize();

  });
})(jQuery);