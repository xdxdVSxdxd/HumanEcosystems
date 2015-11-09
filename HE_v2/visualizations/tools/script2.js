
        var project;
        var word;


        var wordExists = false;

        var wordstats = null;

			$(document).ready(function(){

            project = getUrlParameter("w");
            word = getUrlParameter("iinput");

            word = word.replace("+" , " ");

            var totalwidth = $(".pagewrapper:first").width() - 2*parseInt($(".pagewrapper:first").css("padding"));

            var remar = parseInt($(".rowelement:first").css("margin"));
            var repad = parseInt($(".rowelement:first").css("padding"));

            $(".rowelement").width(   
              Math.floor(  totalwidth  )  
              - 2*remar
              - 2*repad
            );

            $("#searchText").val(word);

            $("#submitsearch").click(function(){
              if(  $("#searchText").val().length>3 ){
                document.location = "index2.php?w=" + project + "&iinput=" + $("#searchText").val();
              } else {
                alert("Inserire una parola lunga più di 3 caratteri.");
              }              
            });

            $("#theword").append(word);

            genStats();

			});


      function getContrastYIQ(hexcolor){
          var r = parseInt(hexcolor.substr(1,2),16);
          var g = parseInt(hexcolor.substr(3,2),16);
          var b = parseInt(hexcolor.substr(4,2),16);
          var yiq = ((r*299)+(g*587)+(b*114))/1000;
          return (yiq >= 128) ? 'black' : 'white';
      }


      function getRandomArbitrary(min, max) {
          return Math.random() * (max - min) + min;
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




      var genStats = function(){

        $.getJSON(
          "../../API/getStatsAboutWord.php",
          {
            "w": project,
            "word": word
          }
        )
        .done(function(data){

          wordstats = data;

          if(data.length<1){
            wordExists = false;
          }
          else{
            wordExists = true;
          }


          var output = "";

          if(data.length<1){
            output = output + "<p>La parola <strong>" + word + "</strong> non sembra essere molto discussa in questo dominio...  Forse potresti iniziare tu e coinvolgere qualcuno.<p/>";
          }else {
            output = output + "<p>La parola <strong>" + word + "</strong> si trova nei database in <strong>" +  data.length + "</strong> modalità diverse<p/>";

            for(var i = 0; i<data.length && i<5 ; i++){
              var witerpret = "";
              if(data[i].n<10){
                witerpret = "<em>Questo vuol dire che non è una parola ricorrente o importante.</em>";
              }
              else if(data[i].n<25){
                witerpret = "<em>Questo vuol dire che è una parola usata spesso, o che è importante nelle conversazioni.</em>";
              }
              else if(data[i].n<80){
                witerpret = "<em>Questo vuol dire che è una parola che è molto importante nelle conversazioni.</em>"; 
              }
              else {
                witerpret = "<em>Questo vuol dire che è una parola fondamentale..</em>";  
              }

              var linkword = "<a href='index2.php?iinput=" + data[i].word + "&w=" + project + "' class='linkwordclass'>" + data[i].word + "</a>";

              output = output + "<p>Con il numero di identificazione <strong>" + data[i].id + "</strong> si manifesta sotto forma di <strong>" +  linkword + "</strong>, con un peso di <strong>" +  data[i].n + "</strong>. ";
              output = output + " ( " + witerpret + " )</p>";
            }

            if(data.length>5){

              
              output = output + "<p>Questa parola appare anche sotto tante altre forme, per esempio: ";

              for(var i = 5; i<data.length; i++){
                var linkword = "<a href='index2.php?iinput=" + data[i].word + "&w=" + project + "' class='linkwordclass'>" + data[i].word + "</a>";
                output = output + "<strong>" +  linkword + "</strong> (" +  data[i].n + ")";
                if(i<(data.length-1)){
                  output = output + ", ";
                }
              }

              output = output + "</p>";
            }
            

          }

          $("#thestats").html(output);

          if(wordExists){
            genBarCharts();  
            genGraphs();
            genUsers()
          }
        
        })
        .fail(function( jqxhr, textStatus, error ){
            //fare qualcosa in caso di fallimento
        });

      };



      var wgwidth, wgheight;
      var wgcolor;
      var wgforce;
      var wgsvg1,wgsvg;
      var maxn = 1;
      var radius = 20;


      function redrawwords() {
        //console.log("here", d3.event.translate, d3.event.scale);
        wgsvg.attr("transform",
            "translate(" + d3.event.translate + ")"
            + " scale(" + d3.event.scale + ")");
      }


      var genGraphs = function(){

        wgwidth = $("#theconnections").width();
        wgheight = 900;
        $("#theconnections").height( wgheight );

        wgcolor = d3.scale.category20();

        wgforce = d3.layout.force()
          .linkDistance(40)
          .linkStrength(0.5)
          .charge(-90)
          .size([wgwidth, wgheight]);

        wgforce.drag()
          .on("dragstart", function() { d3.event.sourceEvent.stopPropagation(); });

        wgsvg1 = d3.select("#theconnections").append("svg")
          .attr("width", wgwidth)
          .attr("height", wgheight)
          .attr("pointer-events", "all");

        wgsvg = wgsvg1
          .append('svg:g')
          .call(d3.behavior.zoom().on("zoom", redrawwords))
          .append('svg:g');


          wgsvg
          .append('svg:rect')
          .attr('x', -10000)
          .attr('y', -10000)
          .attr('width', 20000)
          .attr('height', 20000)
          .attr('fill', 'white');


        var numero = Math.min(8,wordstats.length);
        var idstring = "";

        for(var i = 0; i<numero; i++){
          idstring = idstring + wordstats[i].id;
          if(i<(numero-1)){
            idstring = idstring + ",";
          }
        }

        //
        d3.json("../../API/getConnectionsGraphForNWordsByID.php?w=" + project + "&ids=" + idstring, function(error, data) {
            if (error) throw error;

            var meta = data.meta;

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

            
            var link = wgsvg.selectAll(".link")
              .data(bilinks)
              .enter().append("path")
              .attr("class", "link");

            var node = wgsvg.selectAll(".node")
              .data(graph.nodes);


            var nodeEnter = node
                            .enter()
                            .append("svg:g")
                            .attr("class", "node")
                            .call(wgforce.drag);

            wgsvg.selectAll(".node")
              .on("click",function(d){
                if (d3.event.shiftKey) {
                  document.location = "index2.php?iinput=" + d.word + "&w=" + project;
                }
              });

            nodeEnter.append("circle")
              .attr("r", function(d){  return 4+(15*d.n/maxn); });
              //.style("fill", function(d) { return wgcolor(d.n); });

            var wgtexts = nodeEnter.append("svg:text")
              .attr("class", "nodetext")
              .attr("dx", function(d){  return 12; })
              .attr("dy", ".35em")
              .text(function(d) { return d.word });

            node.append("title")
              .text(function(d) { return d.word; });

            wgforce.on("tick", function() {

              link.attr("d", function(d) {
                return "M" + d[0].x + "," + d[0].y + "S" + d[1].x + "," + d[1].y + " " + d[2].x + "," + d[2].y;
              });
              
              

              node.attr("transform", function(d) {

                var ddx = d.x;
                var ddy = d.y;
                //if(ddx<0){ddx=0;} else if(ddx>wgwidth){ddx=wgwidth;}
                //if(ddy<0){ddy=0;} else if(ddy>wgheight){ddy=wgheight;}

                return "translate(" + ddx + "," + ddy + ")";
              });
              

              //node.attr("cx", function(d) { return d.x = Math.max(radius, Math.min( wgwidth - radius, d.x)); })
              //    .attr("cy", function(d) { return d.y = Math.max(radius, Math.min(wgheight - radius, d.y)); });

              link.attr("x1", function(d) { return d[0].x; })
                  .attr("y1", function(d) { return d[0].y; })
                  .attr("x2", function(d) { return d[1].x; })
                  .attr("y2", function(d) { return d[1].y; });

              wgtexts
                  .attr("dx", function(d) {   

                    val = 0;

                    if(d.x>wgwidth/2){
                      val = -12;// - d.n/4 - this.getComputedTextLength();
                    } else {
                      val = 12;// + d.n/4;
                    }

                    return val;

                  });


            });

        });
        //

      };




      var eachChartHeight = 80;
      var totChartHeight = 0;
      var marginBetweenCharts = 25;
      var titlewordheight = 30;

      var barssvg;

      var genBarCharts = function(){

        totChartHeight = (eachChartHeight + marginBetweenCharts + titlewordheight ) * Math.min(8,wordstats.length);

        $("#thestatsoftheconnections").height(totChartHeight);
        var barchwidth = $("#thestatsoftheconnections").width();

        barssvg = d3.select("#thestatsoftheconnections").append("svg")
            .attr("width",  barchwidth )
            .attr("height", totChartHeight)
            .append("g");

        
        wordstats.forEach(function(e,i){

          
          if(i<8){

            //
            var x = d3.scale.ordinal()
                .rangeRoundBands([0, barchwidth], .1);

            var y = d3.scale.linear()
                .range([eachChartHeight - titlewordheight, 0]);

            var xAxis = d3.svg.axis()
                .scale(x)
                .orient("bottom");

            var yAxis = d3.svg.axis()
                .scale(y)
                .orient("left")
                .ticks(10, "%");

            var chsvg = barssvg.append("g")
              .attr("width", barchwidth)
              .attr("height", eachChartHeight)
              .append("g")
              .attr("transform", "translate(0," + (((i+1)*(titlewordheight)  ) + (i*(eachChartHeight + marginBetweenCharts ))) + ")");

            chsvg.append("g")
              .attr("width", barchwidth)
              .attr("height", titlewordheight)
              .append("text")
              .attr("class" , "barchtitlelabel")
              .attr("height", titlewordheight)
              .attr("y",0)
              .attr("x",0)
              .attr("dy",-titlewordheight*0.3)
              .text(e.word)
              .on("click",function(){
                //console.log(d3.select(this).text());
                document.location = "index2.php?w=" + project + "&iinput=" + d3.select(this).text();
              });

            
            x.domain(e.corec.map(function(d) { return d.word; }));
            y.domain([0, d3.max(e.corec, function(d) { return +d.n; })]);

            var altText = false;

            chsvg.append("g")
                .attr("class", "x axis towrap")
                .attr("transform", "translate(0," + eachChartHeight + ")")
                .call(xAxis)
                .selectAll(".tick text")
                .attr("dy" , function(){
                  if (altText) {
                      altText = false;
                      return 15;
                  } else {
                      altText = true;
                      return 5;
                  }
                })
                .call(shorten, x.rangeBand());
            
            chsvg.append("g")
                .attr("class", "y axis")
                .call(yAxis);
              /*
              .append("text")
                .attr("transform", "rotate(-90)")
                .attr("y", 6)
                .attr("dy", ".71em")
                .style("text-anchor", "end")
                .text("Frequency");
              */


            chsvg.selectAll(".bar")
                .data(e.corec)
              .enter().append("rect")
                .attr("class", "bar")
                .attr("x", function(d) { return x(d.word) + x.rangeBand()/2 - 5 ; })
                .attr("width", 10)//x.rangeBand())
                .attr("y", function(d) { return y(d.n) + titlewordheight; })
                .attr("height", function(d) { return eachChartHeight - titlewordheight - y(d.n); })
                .on("click",function(d){
                  document.location = "index2.php?w=" + project + "&iinput=" + d.word;
                });
            //

          }

          

        });



      }



      function shorten(text, width) {

        text.each(function() {
          var text = d3.select(this);
          var words = text.text();

          if(words.length>8){
            words = words.substring(0,8) + "...";
            text.text(words);
          }

        });

      }

      function wrap(text, width) {
        text.each(function() {
          var text = d3.select(this),
              words = text.text().split(/\s+/).reverse(),
              word,
              line = [],
              lineNumber = 0,
              lineHeight = 1.1, // ems
              y = text.attr("y"),
              dy = parseFloat(text.attr("dy")),
              tspan = text.text(null).append("tspan").attr("x", 0).attr("y", y).attr("dy", dy + "em");
          while (word = words.pop()) {
            line.push(word);
            tspan.text(line.join(" "));
            if (tspan.node().getComputedTextLength() > width) {
              line.pop();
              tspan.text(line.join(" "));
              line = [word];
              tspan = text.append("tspan").attr("x", 0).attr("y", y).attr("dy", ++lineNumber * lineHeight + dy + "em").text(word);
            }
          }
        });
      }


      var genUsers = function(){

        var numero = Math.min(8,wordstats.length);
        var idstring = "";

        for(var i = 0; i<numero && idstring.length<200 ; i++){
          idstring = idstring + wordstats[i].id;
          if(i<(numero-1)){
            idstring = idstring + ",";
          }
        }

        
        var urlop = "../../API/getPeopleTalkingAboutWordsByID.php?w=" + project + "&ids=" + idstring;

        //console.log( urlop );

        d3.json(urlop, function(error, data) {
        //d3.json("../../API/getPeopleTalkingAboutWordsByID.php")
        //.send("POST","w=" + project + "&ids=" + idstring , function(error,data) {
        //.send("POST", JSON.stringify({w:  project,ids: idstring}) , function(error,data) {
        //.header("Content-Type", "application/x-www-form-urlencoded")
        //.post( "w=" + project + "&ids=" + idstring , function(error,data) {
            if (error) throw error;

            //console.log(data);

            var content = "";

            if(data.length==0){
              content = content + "<p>Nessuno sta parlando in pubblico di questo argomento. Forse dovresti iniziare e coinvolgere qualcuno.</p>";
            } else{

              content = content + "<p>Ci sono <strong>" + (data.length) + "</strong> persone che parlano di queste cose.</p>";

              content = content + "<p>Eccole:";
              for(var i = 0; i<data.length; i++){
                var linkuser = "<a href='" + data[i].profile + "' target='_blank' class='linkwordclass'>" + data[i].name + "</a>";
                content = content + " <strong>" + linkuser + "</strong> (" +  data[i].c + ")";
                if(i<(data.length-1)){ content = content + ",";}
              }

              //content = content + ".</p><p>Here they are on the right, with their relations.</p>";


              $("#thepeopleinthewordcontent1").html( content );

              var ptotChartHeight = (eachChartHeight + marginBetweenCharts + 2*titlewordheight  );

              //$("#thepeopleinthewordcontent1").height(ptotChartHeight);
              var pbarchwidth = $("#thepeopleinthewordcontent1").width();

              var pbarssvg = d3.select("#thepeopleinthewordcontent1").append("svg")
                .attr("width",  pbarchwidth )
                .attr("height", ptotChartHeight)
                .append("g");

              var x = d3.scale.ordinal()
                  .rangeRoundBands([0, pbarchwidth], .1);

              var y = d3.scale.linear()
                  .range([eachChartHeight, 0]);

              var xAxis = d3.svg.axis()
                  .scale(x)
                  .orient("bottom");

              var yAxis = d3.svg.axis()
                  .scale(y)
                  .orient("left")
                  .ticks(10, "%");

              var pchsvg = pbarssvg.append("g")
                  .attr("width", pbarchwidth)
                  .attr("height", eachChartHeight)
                  .append("g")
                  .attr("transform", "translate(0," + (titlewordheight) + ")");


              x.domain(data.map(function(d) { return d.name; }));
              y.domain([0, d3.max(data, function(d) { return +d.c; })]);

              var altText = false;


            pchsvg.append("g")
              .attr("class", "x axis ptowrap")
              .attr("transform", "translate(0," + eachChartHeight + ")")
              .call(xAxis)
              .selectAll(".tick text")
              .attr("dy" , function(){
                if (altText) {
                    altText = false;
                    return 15;
                } else {
                    altText = true;
                    return 5;
                }
              })
              .call(shorten, x.rangeBand());

            pchsvg.append("g")
                .attr("class", "y axis")
                .call(yAxis);

            pchsvg.selectAll(".pbar")
                .data(data)
              .enter().append("rect")
                .attr("class", "pbar")
                .attr("x", function(d) { return x(d.name) + x.rangeBand()/2 - 5 ; })
                .attr("width", 10)//x.rangeBand())
                .attr("y", function(d) { return y(d.c); })
                .attr("height", function(d) { return eachChartHeight - y(d.c); });



            var idstringu = "";

            for(var i = 0; i<data.length; i++){
              idstringu = idstringu + data[i].name;
              if(i<(data.length-1)){
                idstringu = idstringu + ",";
              }
            }


            genRelationsUsers(idstringu);


            }// else di if data is empty


        });
        

      };


var pegwidth, pegheight;
var pegcolor;
var pegforce;
var pegsvg,pegsvg1;

function redrawusers() {
        //console.log("here", d3.event.translate, d3.event.scale);
        pegsvg.attr("transform",
            "translate(" + d3.event.translate + ")"
            + " scale(" + d3.event.scale + ")");
}


      var genRelationsUsers = function(idstringu){

        //console.log(idstringu);

        //d3.json("../../API/getRelationsAmongPeopleByID.php?w=" + project + "&ids=" + idstringu, function(error, data) {
          d3.json("../../API/getRelationsAmongPeopleByID.php")
          .header("Content-Type", "application/json")
          .post(JSON.stringify({w: project, ids: idstringu}), function(error, data) {
          //.post("w=" + project + "&ids=" + idstringu, function(error, data) {
            if (error) throw error;

            //console.log(data);

            pegwidth = $("#therelationsbetweenthepeopleintheword").width();
            pegheight = 900;
            $("#therelationsbetweenthepeopleintheword").height( pegheight );

            pegcolor = d3.scale.category20();

            pegforce = d3.layout.force()
              .linkDistance(30)
              .linkStrength(0.5)
              .charge(-90)
              .size([wgwidth, wgheight]);

            pegforce.drag()
              .on("dragstart", function() { d3.event.sourceEvent.stopPropagation(); });

            pegsvg1 = d3.select("#therelationsbetweenthepeopleintheword").append("svg")
              .attr("width", pegwidth)
              .attr("height", pegheight)
              .attr("pointer-events", "all");

            pegsvg = pegsvg1
              .append('svg:g')
              .call(d3.behavior.zoom().on("zoom", redrawusers ))
              .append('svg:g');


              pegsvg
              .append('svg:rect')
              .attr('x', -10000)
              .attr('y', -10000)
              .attr('width', 20000)
              .attr('height', 20000)
              .attr('fill', 'white');

            var graph = data;

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

            pegforce
              .nodes(nodes)
              .links(links)
              .start();

            var link = pegsvg.selectAll(".link")
              .data(bilinks)
              .enter().append("path")
              .attr("class", "link");


            var node = pegsvg.selectAll(".node")
              .data(graph.nodes);


            var nodeEnter = node
                            .enter()
                            .append("svg:g")
                            .attr("class", "node")
                            .call(pegforce.drag);

            pegsvg.selectAll(".node")
              .on("click",function(d){
                if (d3.event.shiftKey) {
                  console.log(d);
                  window.open( d.profile );
                }
              });


            nodeEnter.append("circle")
              .attr("r", 2); //function(d){  return 4+(15*d.n/maxn); });
              //.style("fill", function(d) { return wgcolor(d.n); });

            var pegtexts = nodeEnter.append("svg:text")
              .attr("class", "nodetext")
              .attr("dx", function(d){  return 12 + d.n/4; })
              .attr("dy", ".35em")
              .text(function(d) { return d.name });

            node.append("title")
              .text(function(d) { return d.name; });



            pegforce.on("tick", function() {

              link.attr("d", function(d) {
                return "M" + d[0].x + "," + d[0].y + "S" + d[1].x + "," + d[1].y + " " + d[2].x + "," + d[2].y;
              });
              node.attr("transform", function(d) {

                var ddx = d.x;
                var ddy = d.y;
                if(ddx<0){ddx=0;} else if(ddx>pegwidth){ddx=pegwidth;}
                if(ddy<0){ddy=0;} else if(ddy>pegheight){ddy=pegheight;}

                return "translate(" + ddx + "," + ddy + ")";
              });


              node.attr("cx", function(d) { return d.x = Math.max(radius, Math.min( pegwidth - radius, d.x)); })
                  .attr("cy", function(d) { return d.y = Math.max(radius, Math.min( pegheight - radius, d.y)); });

              link.attr("x1", function(d) { return d[0].x; })
                  .attr("y1", function(d) { return d[0].y; })
                  .attr("x2", function(d) { return d[1].x; })
                  .attr("y2", function(d) { return d[1].y; });

              pegtexts
                  .attr("dx", function(d) {   

                    val = 0;

                    if(d.x>pegwidth/2){
                      val = -12;// - d.n/4 - this.getComputedTextLength();
                    } else {
                      val = 12;// + d.n/4;
                    }

                    return val;

                  });


            });

        });



      };