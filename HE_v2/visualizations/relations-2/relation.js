var project;
var maxD,maxCW;
var maxDotSize = 20;
var paddingAxes = 50;

var vis,zoombehavior;



$( document ).ready(function() {
 
 	project = getUrlParameter("w");


 	getrelations();
   
});


function redraw(){
  console.log("zoom", d3.event.translate, d3.event.scale);
    vis.attr("transform", 
             "translate(" + d3.event.translate + ")" 
                + " scale(" + d3.event.scale + ")"
             );
}


function getrelations(){

  var w = $("#relation").innerWidth() - 40;
  var h = $(window).innerHeight() - 40;

  
    vis = d3.select("#relation").append("svg:svg")
    .attr("width", w)
    .attr("height", h)
    .attr("pointer-events", "all")
    .append("g")
    .call(d3.behavior.zoom().on("zoom", redraw))
    .append("g");

    vis.append('svg:rect')
    .attr('width', 20000)
    .attr('height', 20000)
    .attr('x' , -10000)
    .attr('y', -10000)
    .attr('fill', 'white');



    d3.json("../../API/tools-getRelations.php?w=" + project, function(json) {

    var force = d3.layout.force()
        .nodes(json.nodes)
        .links(json.links)
        .gravity(.05)
        .distance(100)
        .charge(-100)
        .size([w, h])
        .start();

    var link = vis.selectAll("line.link")
        .data(json.links)
        .enter().append("svg:line")
        .attr("class", "linkrelations");

    var node = vis.selectAll("g.node")
        .data(json.nodes)
      .enter().append("svg:g")
        .attr("class", "noderelations")
        .call(force.drag);

    node.append("svg:circle")
        .attr("cx", "0px")
        .attr("cy", "0px")
        .attr("r", "3px")
        .attr("class", "circlerelationsnode")
        .on("click",function(d){
          window.open(d.profile_url);
        });

    node.append("svg:text")
        .attr("class", "nodetextrelations")
        .attr("dx", 12)
        .attr("dy", ".35em")
        .text(function(d) { return d.nick });

    force.on("tick", function() {
      link.attr("x1", function(d) { return d.source.x; })
          .attr("y1", function(d) { return d.source.y; })
          .attr("x2", function(d) { return d.target.x; })
          .attr("y2", function(d) { return d.target.y; });

      node.attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });
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