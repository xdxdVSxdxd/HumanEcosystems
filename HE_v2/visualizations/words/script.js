
      var project;


      $(function () {
         initialize();
      });


			function initialize() {

            project = getUrlParameter("w");

            genTagCloud();

            genWordGraph();
            
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
              //if (error) throw error;
              if(error) genTagCloud();

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
      var svg;
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

        svg = d3.select("#wordgraphcontainer").append("svg")
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
            //if (error) throw error;

            if (error) renderWordGraph();

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

            var link = svg.selectAll(".link")
              .data(bilinks)
              .enter().append("path")
              .attr("class", "link");

            var node = svg.selectAll(".node")
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