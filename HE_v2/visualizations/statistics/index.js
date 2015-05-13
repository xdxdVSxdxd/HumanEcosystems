var project;


var legendRectSize = 18;
var legendSpacing = 4;


$( document ).ready(function() {
 
 	project = getUrlParameter("w");
 	//console.log("HE-tools - project: " + project);



 	$.getJSON("../../API/tools-getProjectStatistics.php?w=" + project)
 	.done(function(data){

 		//console.log(data);

 		$("div#projectheader").append("<div class='col span_1_of_4'><div class='padded'><span class='boldtext'>Project:</span><span class='normaltext'>" + project + "</span></div></div>");
 		$("div#projectheader").append("<div class='col span_1_of_4'><div class='padded'><span class='boldtext'>Number of contents:</span><span class='normaltext'>" + data.contents + "</span></div></div>");
 		$("div#projectheader").append("<div class='col span_1_of_4'><div class='padded'><span class='boldtext'>Number of users:</span><span class='normaltext'>" + data.users + "</span></div></div>");
 		$("div#projectheader").append("<div class='col span_1_of_4'><div class='padded'><span class='boldtext'>Geo-referenced contents:</span><span class='normaltext'>" + data.geocontents + "</span></div></div>");




 		// pie emotions
 		var wemotions = 300;
 		var hemotions = 300;
 		var remotions = 100;
 		var coloremotions = d3.scale.category20c();

 		var dataemotions = data.emotions;

 		//console.log(dataemotions);

 		var visemotions = d3.select('#projectemotions').append("svg:svg").data([dataemotions]).attr("width", wemotions).attr("height", hemotions).append("svg:g").attr("transform", "translate(" + remotions + "," + remotions + ")");
		var pie = d3.layout.pie().value(function(d){return d.value;});

		var arc = d3.svg.arc().outerRadius(remotions);

		var arcs = visemotions.selectAll("g.slice").data(pie).enter().append("svg:g").attr("class", "slice");
		arcs.append("svg:path")
    	.attr("fill", function(d, i){
        	return coloremotions(i);
    	})
    	.attr("d", function (d) {
        	return arc(d);
    	});


    	var legendemotions = visemotions.selectAll('.legend')
		  .data(coloremotions.domain())
		  .enter()
		  .append('g')
		  .attr('class', 'legend')
		  .attr('transform', function(d, i) {
		    var height = legendRectSize + legendSpacing;
		    var offset =  height * coloremotions.domain().length / 2;
		    var horz = -2 * legendRectSize + 1.5*remotions;
		    var vert = i * height - offset + 20;
		    return 'translate(' + horz + ',' + vert + ')';
		  });

			legendemotions.append('rect')
			.attr('width', legendRectSize)
			.attr('height', legendRectSize)
			.style('fill', coloremotions)
			.style('stroke', coloremotions);


			legendemotions.append('text')
			.attr('x', legendRectSize + legendSpacing)
			.attr('y', legendRectSize - legendSpacing)
			.text(function(d) { return dataemotions[d].label; });

    	/*
    	arcs.append("svg:text").attr("transform", function(d){
			d.innerRadius = 0;
			d.outerRadius = remotions;
    		return "translate(" + arc.centroid(d) + ")";
    	})
    	.attr("text-anchor", "middle").text( function(d, i) {
    		return dataemotions[i].label;}
		).attr("class","normaltext smallpielabel");
		*/

		// pie emotions end



		// pie classes
 		var wclasses = 300;
 		var hclasses = 300;
 		var rclasses = 100;
 		var colorclasses = d3.scale.category20c();

 		var dataclasses = data.classes;

 		//console.log(dataclasses);

 		var visclasses = d3.select('#projectclasses').append("svg:svg").data([dataclasses]).attr("width", wclasses).attr("height", hclasses).append("svg:g").attr("transform", "translate(" + rclasses + "," + rclasses + ")");
		var pieclasses = d3.layout.pie().value(function(d){return d.value;});

		var arcclasses = d3.svg.arc().outerRadius(rclasses);

		var arcsclasses = visclasses.selectAll("g.slice").data(pieclasses).enter().append("svg:g").attr("class", "slice");
		arcsclasses.append("svg:path")
    	.attr("fill", function(d, i){
        	return colorclasses(i);
    	})
    	.attr("d", function (d) {
        	return arcclasses(d);
    	});


    	var legendclasses = visclasses.selectAll('.legend')
		  .data(colorclasses.domain())
		  .enter()
		  .append('g')
		  .attr('class', 'legend')
		  .attr('transform', function(d, i) {
		    var height = legendRectSize + legendSpacing;
		    var offset =  height * colorclasses.domain().length / 2;
		    var horz = -2 * legendRectSize + 1.5*rclasses;
		    var vert = i * height - offset;
		    return 'translate(' + horz + ',' + vert + ')';
		  });

			legendclasses.append('rect')
			.attr('width', legendRectSize)
			.attr('height', legendRectSize)
			.style('fill', coloremotions)
			.style('stroke', coloremotions);


			legendclasses.append('text')
			.attr('x', legendRectSize + legendSpacing)
			.attr('y', legendRectSize - legendSpacing)
			.text(function(d) { return dataclasses[d].label; });


    	/*
    	arcsclasses.append("svg:text").attr("transform", function(d){
			d.innerRadius = 0;
			d.outerRadius = rclasses;
    		return "translate(" + arcclasses.centroid(d) + ")";
    	})
    	.attr("text-anchor", "middle").text( function(d, i) {
    		return dataclasses[i].label;}
		).attr("class","normaltext smallpielabel");
		*/

		// pie classes end


 	})
 	.fail(function( jqxhr, textStatus, error ){
 		$("div#projectheader").html("<span class='boldtext'>There was a problem? Wrong project?</span>");
 	});


 	genTimelines();

 	getEmotionsWords();
   
});


function genTimelines(){

	var margin = {top: 8, right: 10, bottom: 2, left: 10},
    width = $("div#projecttimelines").width() - margin.left - margin.right,
    height = 69 - margin.top - margin.bottom;

    

    var x = d3.time.scale()
    .range([0, width]);

    var y = d3.scale.linear()
    .range([height, 0]);

    var area = d3.svg.area()
    .x(function(d) { return x(d.date); })
    .y0(height)
    .y1(function(d) { return y(d.count); });

    var line = d3.svg.line()
    .x(function(d) { return x(d.date); })
    .y(function(d) { return y(d.count); });

    d3.csv("../../API/tools-getWordTimelines.php?w=" + project, type, function(error, data) {

    	// Nest data by symbol.
		  var symbols = d3.nest()
		      .key(function(d) { return d.word; })
		      .entries(data);

		  // Compute the maximum price per symbol, needed for the y-domain.
		  symbols.forEach(function(s) {
		    s.maxPrice = d3.max(s.values, function(d) { return d.count; });
		  });

		  // Compute the minimum and maximum date across symbols.
		  // We assume values are sorted by date.
		  x.domain([
		    d3.min(symbols, function(s) { return s.values[0].date; }),
		    d3.max(symbols, function(s) { return s.values[s.values.length - 1].date; })
		  ]);



		  // Add an SVG element for each symbol, with the desired dimensions and margin.
		  var svg = d3.select("div#projecttimelines").selectAll("svg")
		      .data(symbols)
		    .enter().append("svg")
		      .attr("width", width + margin.left + margin.right)
		      .attr("height", height + margin.top + margin.bottom)
		    .append("g")
		      .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

		  // Add the area path elements. Note: the y-domain is set per element.
		  svg.append("path")
		      .attr("class", "areaTimelines")
		      .attr("d", function(d) { y.domain([0, d.maxPrice]); return area(d.values); });

		  // Add the line path elements. Note: the y-domain is set per element.
		  svg.append("path")
		      .attr("class", "lineTimelines")
		      .attr("d", function(d) { y.domain([0, d.maxPrice]); return line(d.values); });

		      // Add a small label for the symbol name.
			  svg.append("text")
			      .attr("x", width - 6)
			      .attr("y", height - 6)
			      .style("text-anchor", "end")
			      .text(function(d) { return d.key; });
	});

}


function getEmotionsWords(){
	var radius = 160,
    padding = 10;

    var color = d3.scale.category20c();

    var arc = d3.svg.arc()
    .outerRadius(radius)
    .innerRadius(radius - 80);

    var pie = d3.layout.pie()
    .sort(null)
    .value(function(d) { return d.population; });

    d3.csv("../../API/tools-getEmotionTotalsForWords.php?w=" + project, function(error, data) {
  	color.domain(d3.keys(data[0]).filter(function(key) { return key !== "word"; }));

  	data.forEach(function(d) {
		d.ages = color.domain().map(function(name) {
		  return {name: name, population: +d[name]};
		});
	});

	var legend = d3.select("#projectemotionswords").append("svg")
	.attr("class", "legendemotionswords")
	.attr("width", radius * 2)
	.attr("height", radius * 2)
	.selectAll("g")
	.data(color.domain().slice().reverse())
	.enter().append("g")
	.attr("transform", function(d, i) { return "translate(0," + i * 20 + ")"; });

	legend.append("rect")
      .attr("width", 18)
      .attr("height", 18)
      .style("fill", color);

    legend.append("text")
      .attr("x", 24)
      .attr("y", 9)
      .attr("dy", ".35em")
      .text(function(d) { return d; });

	var svg = d3.select("#projectemotionswords").selectAll(".pie")
	.data(data)
	.enter().append("svg")
	.attr("class", "pieemotionswords")
	.attr("width", radius * 2)
	.attr("height", radius * 2)
	.append("g")
	.attr("transform", "translate(" + radius + "," + radius + ")");

	svg.selectAll(".arc")
	.data(function(d) { return pie(d.ages); })
	.enter().append("path")
	.attr("class", "arcemotionswords")
	.attr("d", arc)
	.style("fill", function(d) { return color(d.data.name); });

	svg.append("text")
      .attr("dy", ".35em")
      .style("text-anchor", "middle")
      .text(function(d) { return d.word; });

	});

}



var parseDate = d3.time.format("%Y %m %d %H:%M").parse;


var type = function(d) {
  d.count = +d.count;
  d.date = parseDate(d.date);
  return d;
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