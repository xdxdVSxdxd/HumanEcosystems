
      var project;


      $(function () {
         initialize();
      });


			function initialize() {

            project = getUrlParameter("w");

            genCorecurrence();
            
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


var margin = {top: 80, right: 10, bottom: 10, left: 80},
    width = 720,
    height = 720;

var x,z,c;

var oos = ["name","count","group"];

var timeout = null;

var svg;

      
      var timercc = null;
      var delaycc = 30000;

      var genCorecurrence = function(){

            $("#vizholder").width(  $(document).innerHeight() - margin.left );
            $("#vizholder").height(  $(document).innerHeight() - margin.top );
            $("#vizholder").css("left" , -margin.left + "px");

            width = $("#vizholder").width();
            height = $("#vizholder").height();

            x = d3.scale.ordinal().rangeBands([0, width]);
            z = d3.scale.linear().domain([0, 4]).clamp(true);
            c = d3.scale.category10().domain(d3.range(10));

            svg = d3.select("#vizholder").append("svg")
                .attr("width", width + margin.left)// - margin.left - margin.right)
                .attr("height", height + margin.top)// - margin.top - margin.bottom)
                .append("g")
                .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

            d3.json("http://human-ecosystems.com/HE-Linz/API/getMostImportantWordsConnectionsgraph.php?w=" + project, function(graphu) {
            
              var grapho = graphu;

              var matrix = [],
                nodes = grapho.nodes,
                n = nodes.length;

              nodes.forEach(function(node, i) {
                node.index = i;
                node.count = 0;
                matrix[i] = d3.range(n).map(function(j) { return {x: j, y: i, z: 0}; });
              });

              grapho.links.forEach(function(link) {
                matrix[link.source][link.target].z += link.value;
                matrix[link.target][link.source].z += link.value;
                matrix[link.source][link.source].z += link.value;
                matrix[link.target][link.target].z += link.value;
                nodes[link.source].count += link.value;
                nodes[link.target].count += link.value;
              });

              
              var orders = {
                name: d3.range(n).sort(function(a, b) { return d3.ascending(nodes[a].name, nodes[b].name); }),
                count: d3.range(n).sort(function(a, b) { return nodes[b].count - nodes[a].count; }),
                group: d3.range(n).sort(function(a, b) { return nodes[b].group - nodes[a].group; })
              };

              x.domain(orders.name);

              svg.append("rect")
                .attr("class", "background")
                .attr("width", width)
                .attr("height", height);


              var row = svg.selectAll(".row")
                .data(matrix)
                .enter().append("g")
                .attr("class", "row")
                .attr("transform", function(d, i) { return "translate(0," + x(i) + ")"; })
                .each(row);

              row.append("line")
                .attr("x2", width);

              row.append("text")
                .attr("x", -6)
                .attr("y", x.rangeBand() / 2)
                .attr("dy", ".32em")
                .attr("text-anchor", "end")
                .text(function(d, i) { return nodes[i].name; });

              var column = svg.selectAll(".column")
                .data(matrix)
                .enter().append("g")
                .attr("class", "column")
                .attr("transform", function(d, i) { return "translate(" + x(i) + ")rotate(-90)"; });

              column.append("line")
                .attr("x1", -width);

              column.append("text")
                .attr("x", 6)
                .attr("y", x.rangeBand() / 2)
                .attr("dy", ".32em")
                .attr("text-anchor", "start")
                .text(function(d, i) { return nodes[i].name; });



              function row(row) {
                var cell = d3.select(this).selectAll(".cell")
                    .data(row.filter(function(d) { return d.z; }))
                  .enter().append("rect")
                    .attr("class", "cell")
                    .attr("x", function(d) { return x(d.x); })
                    .attr("width", x.rangeBand())
                    .attr("height", x.rangeBand())
                    .style("fill-opacity", function(d) { return z(d.z); })
                    .style("fill", function(d) { return nodes[d.x].group == nodes[d.y].group ? c(nodes[d.x].group) : null; })
                    .on("mouseover", mouseover)
                    .on("mouseout", mouseout);
              }


              function mouseover(p) {
                d3.selectAll(".row text").classed("active", function(d, i) { return i == p.y; });
                d3.selectAll(".column text").classed("active", function(d, i) { return i == p.x; });
              }


              function mouseout() {
                d3.selectAll("text").classed("active", false);
              }

              function order(value) {
                x.domain(orders[value]);

                var t = svg.transition().duration(2500);

                t.selectAll(".row")
                    .delay(function(d, i) { return x(i) * 4; })
                    .attr("transform", function(d, i) { return "translate(0," + x(i) + ")"; })
                  .selectAll(".cell")
                    .delay(function(d) { return x(d.x) * 4; })
                    .attr("x", function(d) { return x(d.x); });

                t.selectAll(".column")
                    .delay(function(d, i) { return x(i) * 4; })
                    .attr("transform", function(d, i) { return "translate(" + x(i) + ")rotate(-90)"; });
              }


              timeout = setInterval(function() {

                order( oos[   Math.floor(Math.random() * oos.length)   ]  );
                
              }, 5000);

            /*
            if( timercc!=null){
              clearTimeout(timercc);
            }
            timercc = setTimeout(genCorecurrence, delaycc );
            */

        });        


            
        

      };