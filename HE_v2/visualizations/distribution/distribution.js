var project;
var maxD,maxCW;
var maxDotSize = 20;
var paddingAxes = 50;



$( document ).ready(function() {
 
 	project = getUrlParameter("w");


 	getDistribution();
  getDistributionUsers();
  getDistributionTimes();
   
});


function getDistribution(){

	var margin = {top: 20, right: 100, bottom: 30, left: 100},
    width = $("div#distribution").width() - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

    var x = d3.scale.ordinal()
    .rangePoints([ paddingAxes , width - paddingAxes]);

	var y = d3.scale.ordinal()
	    .rangePoints([height - paddingAxes, paddingAxes ]);

	var color = d3.scale.category20();

	var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom");

	var yAxis = d3.svg.axis()
	    .scale(y)
	    .orient("left");

	maxD = 1;
  


	var svg = d3.select("#distribution").append("svg")
	.attr("width", width + margin.left + margin.right)
	.attr("height", height + margin.top + margin.bottom)
	.append("g")
	.attr("transform", "translate(" + margin.left + "," + margin.top + ")");

	d3.csv("../../API/tools-getForDistribution.php?w=" + project, function(error, data) {
	data.forEach(function(d) {

		d.c = eval(d.c);
		if(d.c>maxD){ maxD = d.c; }
	});

	//x.domain(d3.extent(data, function(d) { return d.word; })).nice();
	x.domain(data.map(function(d) { return d.word; }));
  	//y.domain(d3.extent(data, function(d) { return d.emotion; })).nice();
  	y.domain(data.map(function(d) { return d.emotion; }));

  	svg.append("g")
      .attr("class", "x axisdistribution")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis)
    .append("text")
      .attr("class", "labeldistribution")
      .attr("x", width)
      .attr("y", -6)
      .style("text-anchor", "middle")
      .text("Topic");

   	svg.append("g")
      .attr("class", "y axisdistribution")
      .call(yAxis)
    .append("text")
      .attr("class", "labeldistribution")
      .attr("transform", "rotate(-90)")
      .attr("y", 6)
      .attr("dy", ".71em")
      .style("text-anchor", "end")
      .text("Emotion");

    svg.selectAll(".dot")
      .data(data)
    .enter().append("circle")
      .attr("class", "dotdistribution")
      .attr("r", function(d) {  return (d.c/maxD)*maxDotSize + 3; })
      .attr("cx", function(d) { return x(d.word); })
      .attr("cy", function(d) { return y(d.emotion); })
      .on("click", function(d){
      	window.open("browseByEmotionWord.php?emotion=" + d.emotion + "&word=" + d.word + "&w=" + project);
      	console.log(d);
      })
      .on("mouseover", function(d){
        d3.select(this).classed("dotdistribution" , false);
        d3.select(this).classed("hoverCircle" , true);
      })
      .on("mouseout", function(d){
        d3.select(this).classed("dotdistribution" , true);
        d3.select(this).classed("hoverCircle" , false);
      });

  });

}




function getDistributionUsers(){

  var margin = {top: 20, right: 100, bottom: 30, left: 100},
    width = $("div#distributionusers").width() - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

    var x = d3.scale.log()
    .range([ paddingAxes , width - paddingAxes]);

  var y = d3.scale.ordinal()
      .rangePoints([height - paddingAxes, paddingAxes ]);

  var color = d3.scale.category20();

  var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom");

  var yAxis = d3.svg.axis()
      .scale(y)
      .orient("left");

  maxD = 1;
  maxCW = 1;


  var svg = d3.select("#distributionusers").append("svg")
  .attr("width", width + margin.left + margin.right)
  .attr("height", height + margin.top + margin.bottom)
  .append("g")
  .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

  d3.csv("../../API/tools-getForDistributionUsers.php?w=" + project, function(error, data) {
  data.forEach(function(d) {

    d.c = eval(d.c);
    d.cw = eval(d.cw);
    if(d.cw>maxCW){ maxCW = d.cw; }
    if(d.c>maxD){ maxD = d.c; }
  });

  //x.domain(d3.extent(data, function(d) { return d.word; })).nice();
  //x.domain(data.map(function(d) { return d.c; }));
    //y.domain(d3.extent(data, function(d) { return d.emotion; })).nice();

    x.domain(d3.extent(data, function(d) { return d.c; })).nice();
    y.domain(data.map(function(d) { return d.word; }));

    svg.append("g")
      .attr("class", "x axisdistribution")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis)
    .append("text")
      .attr("class", "labeldistribution")
      .attr("x", width)
      .attr("y", -6)
      .style("text-anchor", "middle")
      .text("n. of messages");

    svg.append("g")
      .attr("class", "y axisdistribution")
      .call(yAxis)
    .append("text")
      .attr("class", "labeldistribution")
      .attr("transform", "rotate(-90)")
      .attr("y", 6)
      .attr("dy", ".71em")
      .style("text-anchor", "end")
      .text("Topic");

    svg.selectAll(".dot")
      .data(data)
    .enter().append("circle")
      .attr("class", "dotdistribution")
      .attr("r", function(d) {  return (d.cw/maxCW)*maxDotSize + 3; })
      .attr("cx", function(d) { return x(d.c); })
      .attr("cy", function(d) { return y(d.word); })
      .on("click", function(d){
        //window.open("browseByEmotionWord.php?emotion=" + d.emotion + "&word=" + d.word + "&w=" + project);
        console.log(d);
      })
      .on("mouseover", function(d){
        d3.select(this).classed("dotdistribution" , false);
        d3.select(this).classed("hoverCircle" , true);
      })
      .on("mouseout", function(d){
        d3.select(this).classed("dotdistribution" , true);
        d3.select(this).classed("hoverCircle" , false);
      });

  });


}



function getDistributionTimes(){

  var margin = {top: 20, right: 100, bottom: 30, left: 100},
    width = $("div#distributiontime").width() - margin.left - margin.right,
    height = 500 - margin.top - margin.bottom;

    var x = d3.scale.linear()
    .range([ paddingAxes , width - paddingAxes]);

  var y = d3.scale.ordinal()
      .rangePoints([height - paddingAxes, paddingAxes ]);

  var color = d3.scale.category20();

  var xAxis = d3.svg.axis()
    .scale(x)
    .orient("bottom");

  var yAxis = d3.svg.axis()
      .scale(y)
      .orient("left");

  maxD = 1;
  maxCW = 1;


  var svg = d3.select("#distributiontime").append("svg")
  .attr("width", width + margin.left + margin.right)
  .attr("height", height + margin.top + margin.bottom)
  .append("g")
  .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

  d3.csv("../../API/tools-getForDistributionTimeOfDay.php?w=" + project, function(error, data) {
  data.forEach(function(d) {
    d.c = eval(d.c);
    d.time = eval(d.time);
    if(d.c>maxD){ maxD = d.c; }
  });

  //x.domain(d3.extent(data, function(d) { return d.word; })).nice();
  //x.domain(data.map(function(d) { return d.c; }));
    //y.domain(d3.extent(data, function(d) { return d.emotion; })).nice();

    x.domain(d3.extent(data, function(d) { return d.time; })).nice();
    y.domain(data.map(function(d) { return d.word; }));

    svg.append("g")
      .attr("class", "x axisdistribution")
      .attr("transform", "translate(0," + height + ")")
      .call(xAxis)
    .append("text")
      .attr("class", "labeldistribution")
      .attr("x", width)
      .attr("y", -6)
      .style("text-anchor", "middle")
      .text("Time of Day");

    svg.append("g")
      .attr("class", "y axisdistribution")
      .call(yAxis)
    .append("text")
      .attr("class", "labeldistribution")
      .attr("transform", "rotate(-90)")
      .attr("y", 6)
      .attr("dy", ".71em")
      .style("text-anchor", "end")
      .text("Topic");

    svg.selectAll(".dot")
      .data(data)
    .enter().append("circle")
      .attr("class", "dotdistribution")
      .attr("r", function(d) {  return (d.c/maxD)*maxDotSize + 3; })
      .attr("cx", function(d) { return x(d.time); })
      .attr("cy", function(d) { return y(d.word); })
      .on("click", function(d){
        //window.open("browseByEmotionWord.php?emotion=" + d.emotion + "&word=" + d.word + "&w=" + project);
        console.log(d);
      })
      .on("mouseover", function(d){
        d3.select(this).classed("dotdistribution" , false);
        d3.select(this).classed("hoverCircle" , true);
      })
      .on("mouseout", function(d){
        d3.select(this).classed("dotdistribution" , true);
        d3.select(this).classed("hoverCircle" , false);
      });

  });

}




var parseDate = d3.time.format("%Y %m %d %H:%M").parse;


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