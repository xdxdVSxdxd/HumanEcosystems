var testing = false;
var legend;

        var project;


$( document ).ready(function() {
    initialize();
});


      function initialize() {

            project = getUrlParameter("w");


            legend = new Object();


            $.getJSON("../../API/getEmotionsLegend.php?w=" + project)
            .done(function(data){

                // insert markers on map


                var dati = new Array();
                dati[0] = new Object();
                dati[0].label = "Love";
                dati[0].color = "#E4F603";

                dati[1] = new Object();
                dati[1].label = "Anger";
                dati[1].color = "#EB8AF6";

                dati[2] = new Object();
                dati[2].label = "Disgust";
                dati[2].color = "#05F642";

                dati[3] = new Object();
                dati[3].label = "Boredom";
                dati[3].color = "#8908F6";

                dati[4] = new Object();
                dati[4].label = "Fear";
                dati[4].color = "#060CD4";

                dati[5] = new Object();
                dati[5].label = "Hate";
                dati[5].color = "#8C6AD4";

                dati[6] = new Object();
                dati[6].label = "Joy";
                dati[6].color = "#D4AD0B";

                dati[7] = new Object();
                dati[7].label = "Surprise";
                dati[7].color = "#D4460B";

                dati[8] = new Object();
                dati[8].label = "Trust";
                dati[8].color = "#F6000A";

                dati[9] = new Object();
                dati[9].label = "Sadness";
                dati[9].color = "#06D4B5";

                dati[10] = new Object();
                dati[10].label = "Anticipation";
                dati[10].color = "#EB8C00";

                dati[11] = new Object();
                dati[11].label = "Violence";
                dati[11].color = "#6ABFD4";

                dati[12] = new Object();
                dati[12].label = "Terror";
                dati[12].color = "#058BEB";
                
                for(var i = 0 ; i<dati.length ; i++){
                  legend[  dati[i].label ] = dati[i].color;
                  $("#legend-body").append("<div class='legend-item-holder'><div class='legend-color' style='background: " + dati[i].color + "' ></div><div class='legend-lebel'>" + dati[i].label + "</div></div>");
                }
                
                // e poi chiamare gli stadi successivi di init
                getTimelineEmotions();

            })
            .fail(function( jqxhr, textStatus, error ){
                //fare qualcosa in caso di fallimento
            });
            
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

        var width = $("#emo-timeline-contained").width() - margin.left - margin.right,
        height = $("#emo-timeline-contained").height() - margin.top - margin.bottom;
            

        var parseDate = d3.time.format("%Y%m%d").parse;

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

        
        width = $("#emo-timeline-contained").width() - margin.left - margin.right;
        height = $("#emo-timeline-contained").height() - margin.top - margin.bottom;
            

        parseDate = d3.time.format("%Y%m%d").parse;

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


        d3.tsv("../../API/getEmotionsTimelineGeneral.php?w=" + project, function(error, data) {
          if (error) throw error;

          
          color.domain(d3.keys(data[0]).filter(function(key) { return key !== "date"; }));

          data.forEach(function(d) {
            //console.log(d.date);
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
              //console.log("remove");
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
              .style("stroke", function(d) { return color(d.name); })
              .style("fill", "#FFFFFF");

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