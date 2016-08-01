
        var project;
        var word;

        var wordarray = new Array();


        var wordExists = false;

        var wordstats = null;

        var messages = 0;
        var users = 0;
        var relations;


        var positive = ["Love","Joy","Surprise","Trust"];
        var negative = ["Anger","Disgust","Fear","Hate","Sadness","Violence","Terror"];
        var neutral = ["Anticipation","Boredom"];

        function gencsv(){
        	if(project!="" && word!=""){
            window.open("getWordNetworkCSV.php?w=" + project + "&word=" + word);
          }
        }

        function genhashtagscsv(){
          if(project!="" && word!=""){
            window.open("getHashtagsCSV.php?w=" + project + "&word=" + word);
          }
        }

        function gencsvrelations(){
          if(project!="" && word!=""){
            window.open("getRelationsGraphCSV.php?w=" + project + "&word=" + word);
          }
        }

        var csvstring = "";

			$(document).ready(function(){

            project = getUrlParameter("w");
            word = getUrlParameter("iinput");

            word = word.replace("+" , " ");

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
            //genRelations();

			});

      function downloadcontent(){
        if(project!="" && word!=""){
          window.open("getContent.php?w=" + project + "&word=" + word);
        }
      }


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


      var genStats = function(){

          $.getJSON(
            "getStats.php",
            {
              "w": project,
              "word": word
            }
          )
          .done(function(data){

            messages = data.count;
            users = data.users;
            relations = data.relations;

            var testo = "<strong>Count:</strong> " + data.count + " – <strong>Users:</strong> " + data.users; // + " – <strong>Relations:</strong> " + data.relations;
            $("#thestats").html(testo);

            genTimeline();

          })
          .fail(function( jqxhr, textStatus, error ){
            //fare qualcosa in caso di fallimento
            genTimeline();
          });

      };





      var genTimeline = function(){

          var margin = {top: 30, right: 20, bottom: 30, left: 50},
          width = $("#timeline").width() - margin.left - margin.right,
          height = 400 - margin.top - margin.bottom;

          var parseDate = d3.time.format("%d-%m-%Y").parse;

          var x = d3.time.scale().range([0, width]);
          var y = d3.scale.linear().range([height, 0]);

          var xAxis = d3.svg.axis().scale(x)
              .orient("bottom").ticks(5);

          var yAxis = d3.svg.axis().scale(y)
              .orient("left").ticks(5);

          var valueline = d3.svg.line()
            .x(function(d) { return x(d.date); })
            .y(function(d) { return y(d.close); });


          var svg = d3.select("#timeline")
            .append("svg")
                .attr("width", width + margin.left + margin.right)
                .attr("height", height + margin.top + margin.bottom)
            .append("g")
                .attr("transform", 
                      "translate(" + margin.left + "," + margin.top + ")");

          d3.csv("getTimelineData.php?w=" + project + "&word=" + word, function(error, data) {
              var datevalues = new Array();

              data.forEach(function(d) {

                  d.date = parseDate(d.date);
                  d.close = +d.close;

                  var y = "" + d.date.getFullYear();
                  var m = "" + (d.date.getMonth() + 1);
                  if(d.date.getMonth()<10){ m = "0" + m; }
                  var da = "" + (d.date.getDay() + 1);
                  if(d.date.getDay()<10){ da = "0" + da; }

                  datevalues[y + m + da] = d.close;

              });


              var timelinedatestring = "";
              timelinedatestring = timelinedatestring + "<table align='center' width='300' border='1'>";
              for(var i in datevalues){
                timelinedatestring = timelinedatestring + "<tr>";
                timelinedatestring = timelinedatestring + "<td align='center'>" + i + "</td>";
                timelinedatestring = timelinedatestring + "<td align='center'>" + datevalues[i] + "</td>";
                timelinedatestring = timelinedatestring + "</tr>";

              }
              timelinedatestring = timelinedatestring + "</table>";

              $("#timelinetable").html(timelinedatestring);


              // Scale the range of the data
              x.domain(d3.extent(data, function(d) { return d.date; }));
              y.domain([0, d3.max(data, function(d) { return d.close; })]);

              // Add the valueline path.
              svg.append("path")
                  .attr("class", "line")
                  .attr("d", valueline(data));

              // Add the X Axis
              svg.append("g")
                  .attr("class", "x axis")
                  .attr("transform", "translate(0," + height + ")")
                  .call(xAxis);

              // Add the Y Axis
              svg.append("g")
                  .attr("class", "y axis")
                  .call(yAxis);


              genEmotions();

          });

      };


      var genEmotions = function(){
      
        d3.csv("getEmotionsData.php?w=" + project + "&word=" + word, function(error, data) {

          // emozione,n

              var margin = {top: 30, right: 20, bottom: 30, left: 50},
              width = $("#emotiongraph").width() - margin.left - margin.right,
              height = 400 - margin.top - margin.bottom;

              var maxValue = 0;

              var colors = ['#0000b4','#0082ca','#0094ff','#0d4bcf','#0066AE','#074285','#00187B','#285964','#405F83','#416545','#4D7069','#6E9985','#7EBC89','#0283AF','#79BCBF','#99C19E'];


              var pn = 0;
              var nn = 0;
              var nen = 0;

              var emotionsarray = new Array();

              data.forEach(function(d) {
                  d.n = +d.n;

                  var found = false;
                  for(var k = 0 ; k<positive.length && !false; k++){
                    if(positive[k]==d.emotion){
                      pn=pn+d.n;
                    }
                  }
                  found = false;
                  for(var k = 0 ; k<negative.length && !false; k++){
                    if(negative[k]==d.emotion){
                      nn=nn+d.n;
                    }
                  }
                  found = false;
                  for(var k = 0 ; k<neutral.length && !false; k++){
                    if(neutral[k]==d.emotion){
                      nen=nen+d.n;
                    }
                  }

                  emotionsarray[d.emotion] = d.n;

                  if(d.n>maxValue) { maxValue = d.n; }
              });


              var tablestring = "";
              tablestring = tablestring + "<table align='center' width='300' border='1'>";
              for(var i in emotionsarray){
                tablestring = tablestring + "<tr>";
                tablestring = tablestring + "<td align='center'>" + i + "</td>";
                tablestring = tablestring + "<td align='center'>" + emotionsarray[i] + "</td>";
                tablestring = tablestring + "</tr>";

              }
              tablestring = tablestring + "</table>";

              $("#emotionstable").html(tablestring);



              var xscale = d3.scale.linear()
                      .domain([0,maxValue])
                      .range([0,width-170]);

              var yscale = d3.scale.linear()
                      .domain([0,data.length])
                      .range([0,480]);

              var colorScale = d3.scale.category20(); 
                //d3.scale.quantize()
                //.domain([0,data.length])
                //.range(colors);

              var canvas = d3.select('#emotiongraph')
                .append('svg')
                .attr({'width':width,'height':550 });


              var xAxis = d3.svg.axis();
                xAxis
                  .orient('bottom')
                  .scale(xscale);


              var yAxis = d3.svg.axis();
                yAxis
                  .orient('left')
                  .scale(yscale)
                  .tickSize(2)
                  .tickFormat(function(d,i){ return data[i].emotion; })
                  .tickValues(d3.range(data.length));

              var y_xis = canvas.append('g')
                        .attr("transform", "translate(150,10)")
                        .attr('id','yaxis')
                        .call(yAxis);

              var x_xis = canvas.append('g')
                        .attr("transform", "translate(150,480)")
                        .attr('id','xaxis')
                        .call(xAxis);

              var chart = canvas.append('g')
                  .attr("transform", "translate(150,0)")
                  .attr('id','bars')
                  .selectAll('rect')
                  .data(data)
                  .enter()
                  .append('rect')
                  .attr('height',19)
                  .attr({'x':0,'y':function(d,i){ return yscale(i)+19; }})
                  .style('fill',function(d,i){ return colorScale(i); })
                  .attr('width',function(d){ return xscale(d.n); });

              $("#emotiongraph #yaxis .tick text").attr("y" , 17);


              var ps = 100*pn/(pn+nn+nen); 
              var ns = 100*nn/(pn+nn+nen); 
              var nes = 100*nen/(pn+nn+nen);

              $("#positivesentiment").text( ps.toFixed(2) + "%");
              $("#negativesentiment").text( ns.toFixed(2) + "%");
              $("#neutralsentiment").text( nes.toFixed(2) + "%");


              genWordNetwork();
              

        });




      };

      var genWordNetwork = function(){

        var tcbleed, tcwidth, tcheight;
        var tcpack;
        var tcsvg;

        tcbleed = 100;
        tcwidth = $("#wordnetwork").width();
        tcheight = 800;

        $("#wordnetwork").html("");

            tcpack = d3.layout.pack()
            .sort(null)
            .size([tcwidth, tcheight + tcbleed * 2])
            .padding(2);

            tcsvg = d3.select("#wordnetwork").append("svg")
            .attr("width", tcwidth)
            .attr("height", tcheight)
            .append("g")
            .attr("transform", "translate(0," + -tcbleed + ")");

            d3.json("getWordNetwork.php?w=" + project + "&word=" + word, function(error, json) {
            //d3.json("README.json", function(error, json) {
              //if (error) throw error;

              //console.log(json);

              var tablestring = "";
              tablestring = tablestring + "<table align='center' width='300' border='1'>";

              var ii=0;

              json.children.forEach(function(ch){
                ch.value = +ch.value;
                ch.n = ch.value;
                if(ii<200){
                  tablestring = tablestring + "<tr>";
                  tablestring = tablestring + "<td align='center'>" + ch.name + "</td>";
                  tablestring = tablestring + "<td align='center'>" + ch.value + "</td>";
                  tablestring = tablestring + "</tr>";
                  ii++;
                }

              });

              tablestring = tablestring + "<tr><td align='center'>...</td><td align='center'>...</td></tr>";
              tablestring = tablestring + "</table>";

              $("#wordtable").html(tablestring);


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



              genRelations();


            });//d3.json


      };



      var genRelations = function(){


        var tcbleed, tcwidth, tcheight;
        var tcpack;
        var tcsvg;

        tcbleed = 100;
        tcwidth = $("#relationalnetwork").width();
        tcheight = 800;

        $("#relationalnetwork").html("");

            tcpack = d3.layout.pack()
            .sort(null)
            .size([tcwidth, tcheight + tcbleed * 2])
            .padding(2);

            tcsvg = d3.select("#relationalnetwork").append("svg")
            .attr("width", tcwidth)
            .attr("height", tcheight)
            .append("g")
            .attr("transform", "translate(0," + -tcbleed + ")");

            d3.json("getRelationsGraph.php?w=" + project + "&word=" + word, function(error, json) {
            //d3.json("README.json", function(error, json) {
              //if (error) throw error;

              //console.log(json);

              var tablestring = "";
              tablestring = tablestring + "<table align='center' width='300' border='1'>";

              var ii = 0;

              json.children.forEach(function(ch){
                ch.value = +ch.value;
                ch.n = ch.value;
                if(ii<200){
                  tablestring = tablestring + "<tr>";
                  tablestring = tablestring + "<td align='center'>" + ch.name + "</td>";
                  tablestring = tablestring + "<td align='center'>" + ch.value + "</td>";
                  tablestring = tablestring + "</tr>";
                  ii++;
                }

              });

              tablestring = tablestring + "<tr><td align='center'>...</td><td align='center'>...</td></tr>";
              tablestring = tablestring + "</table>";

              $("#relationstable").html(tablestring);

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

                genHashtags();

            });//d3.json
          
      };

var genHashtags = function(){
            var tcbleed, tcwidth, tcheight;
        var tcpack;
        var tcsvg;

        tcbleed = 100;
        tcwidth = $("#hashtags").width();
        tcheight = 800;

        $("#hashtags").html("");

            tcpack = d3.layout.pack()
            .sort(null)
            .size([tcwidth, tcheight + tcbleed * 2])
            .padding(2);

            tcsvg = d3.select("#hashtags").append("svg")
            .attr("width", tcwidth)
            .attr("height", tcheight)
            .append("g")
            .attr("transform", "translate(0," + -tcbleed + ")");

            d3.json("getHashtags.php?w=" + project + "&word=" + word, function(error, json) {
            //d3.json("README.json", function(error, json) {
              //if (error) throw error;

              //console.log(json);

              var tablestring = "";
              tablestring = tablestring + "<table align='center' width='300' border='1'>";


              var ii = 0;

              json.children.forEach(function(ch){
                ch.value = +ch.value;
                ch.n = ch.value;
                if(ii<200){
                  tablestring = tablestring + "<tr>";
                  tablestring = tablestring + "<td align='center'>" + ch.name + "</td>";
                  tablestring = tablestring + "<td align='center'>" + ch.value + "</td>";
                  tablestring = tablestring + "</tr>";  
                  ii++;
                }
                

              });

              tablestring = tablestring + "<tr><td align='center'>...</td><td align='center'>...</td></tr>";
              tablestring = tablestring + "</table>";

              $("#hashtagtable").html(tablestring);

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

            });//d3.json
};