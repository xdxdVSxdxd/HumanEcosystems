var colors = new Array();
colors[0] = "#FF0000";
colors[1] = "#FFFF00";
colors[2] = "#FF00FF";
colors[3] = "#00FF00";
colors[4] = "#00FFFF";
colors[5] = "#0000FF";
colors[6] = "#FF00FF";

var project = "";

function round(n) {
    return Math.round(n*100) / 100;
}

// Represents an edge from source to sink with capacity
var Edge = function(source, sink, capacity) {
    this.source = source;
    this.sink = sink;
    this.capacity = capacity;
};

// Main class to manage the network
var Graph = function() {
    this.edges = {};
    this.nodes = [];
    this.nodeMap = {};
    
    // Add a node to the graph
    this.addNode = function(node) {
        this.nodes.push(node);
        this.nodeMap[node] = this.nodes.length-1;
        this.edges[node] = [];
    };

    // Add an edge from source to sink with capacity
    this.addEdge = function(source, sink, capacity) {
        // Create the two edges = one being the reverse of the other    
        var edge = new Edge(source, sink, capacity);
        this.edges[source].push(edge);
    };
    
    // Does edge from source to sink exist?
    this.edgeExists = function(source, sink) {
        if(this.edges[source] !== undefined) 
            for(var i=0;i<this.edges[source].length;i++)
                if(this.edges[source][i].sink == sink)
                    return this.edges[source][i];
        return null;
    };
    
    // Turn the set of nodes and edges to a matrix with the value being
    // the capacity between the nodes
    this.getAssociatedMatrix = function() {
        var matrix = [];
        for(var i=0;i<this.nodes.length;i++) {
            var row = [];
            for(var j=0;j<this.nodes.length;j++) {
                var edge = this.edgeExists(this.nodes[j], this.nodes[i]);
                if(i == j) edge = {capacity:1};
                row.push(edge != null ? edge.capacity : 0);
            }
            matrix.push(row);
        }
        return matrix;
    };
        
    // Normalizes a given matrix
    this.normalize = function(matrix) {
        // Find the sum of each column
        var sums = [];
        for(var col=0;col<matrix.length;col++) {
            var sum = 0;
            for(var row=0;row<matrix.length;row++)
                sum += matrix[row][col];
            sums[col] = sum;
        }

        // For every value in the matrix divide by the sum
        for(var col=0;col<matrix.length;col++){
            for(var row=0;row<matrix.length;row++){
                if(sums[col]!=0){
                    matrix[row][col] = round(matrix[row][col] / sums[col]);    
                }
            }
        }
    };
    
    // Prints the matrix
    this.print = function(matrix) {
        for(var i=0;i<matrix.length;i++) {
            for(var j=0;j<matrix[i].length;j++) {
                document.write((j==0?'':',')+matrix[i][j]);
            }
            document.write('<br>');
        }
    };
        
    // Take the (power)th power of the matrix effectively multiplying it with
    // itself pow times
    this.matrixExpand = function(matrix, pow) {
        var resultMatrix = [];
        for(var row=0;row<matrix.length;row++) {
            resultMatrix[row] = [];
            for(var col=0;col<matrix.length;col++) {
                var result = 0;
                for(var c=0;c<matrix.length;c++)
                    result += matrix[row][c] * matrix[c][col];
                resultMatrix[row][col] = result;
            }
        }
        return resultMatrix;
    }; 
        
    // Applies a power of X to each item in the matrix
    this.matrixInflate = function(matrix, pow) {
        for(var row=0;row<matrix.length;row++) 
            for(var col=0;col<matrix.length;col++)
                matrix[row][col] = Math.pow(matrix[row][col], pow);
    };
    
    // Are the two matrices equal?
    this.equals = function(a,b) {
        for(var i=0;i<a.length;i++) 
            for(var j=0;j<a[i].length;j++) 
                if(b[i] === undefined || b[i][j] === undefined || a[i][j] - b[i][j] > 0.1) return false;
        return true;
    };
    
    // Girvan–Newman algorithm
    this.getMarkovCluster = function(power, inflation) {
        var lastMatrix = [];
        
        var currentMatrix = this.getAssociatedMatrix();
        //this.print(currentMatrix); 
        console.log(currentMatrix);       
        this.normalize(currentMatrix);  
        
        currentMatrix = this.matrixExpand(currentMatrix, power);    
        this.matrixInflate(currentMatrix, inflation);                               
        this.normalize(currentMatrix);
        
        var c = 0;
        while(!this.equals(currentMatrix,lastMatrix)) {
            lastMatrix = currentMatrix.slice(0);

            currentMatrix = this.matrixExpand(currentMatrix, power);                
            this.matrixInflate(currentMatrix, inflation);         
            this.normalize(currentMatrix);            
                       
            if(++c > 500) break; //JIC, fiddle fail
        }
        return currentMatrix;
    };
};

var g;



 

(function($){

  var Renderer = function(canvas){
    var canvas = $(canvas).get(0)
    var ctx = canvas.getContext("2d");
    var particleSystem

    var that = {
      init:function(system){
        //
        // the particle system will call the init function once, right before the
        // first frame is to be drawn. it's a good place to set up the canvas and
        // to pass the canvas size to the particle system
        //
        // save a reference to the particle system for use in the .redraw() loop
        particleSystem = system

        // inform the system of the screen dimensions so it can map coords for us.
        // if the canvas is ever resized, screenSize should be called again with
        // the new dimensions
        particleSystem.screenSize(canvas.width, canvas.height) 
        particleSystem.screenPadding(80) // leave an extra 80px of whitespace per side
        
        // set up some event handlers to allow for node-dragging
        that.initMouseHandling()
      },
      
      redraw:function(){
        // 
        // redraw will be called repeatedly during the run whenever the node positions
        // change. the new positions for the nodes can be accessed by looking at the
        // .p attribute of a given node. however the p.x & p.y values are in the coordinates
        // of the particle system rather than the screen. you can either map them to
        // the screen yourself, or use the convenience iterators .eachNode (and .eachEdge)
        // which allow you to step through the actual node objects but also pass an
        // x,y point in the screen's coordinate system
        // 
        ctx.fillStyle = "white"
        ctx.fillRect(0,0, canvas.width, canvas.height)
        
        particleSystem.eachEdge(function(edge, pt1, pt2){
          // edge: {source:Node, target:Node, length:#, data:{}}
          // pt1:  {x:#, y:#}  source position in screen coords
          // pt2:  {x:#, y:#}  target position in screen coords

          // draw a line from pt1 to pt2
          ctx.strokeStyle = "rgba(0,0,0, .333)"
          ctx.lineWidth = 1
          ctx.beginPath()
          ctx.moveTo(pt1.x, pt1.y)
          ctx.lineTo(pt2.x, pt2.y)
          ctx.stroke()
        })

        particleSystem.eachNode(function(node, pt){
          // node: {mass:#, p:{x,y}, name:"", data:{}}
          // pt:   {x:#, y:#}  node position in screen coords

          // draw a rectangle centered at pt
          var w = 2
          //console.log("ci:" + node.data.colorIndex );
          ctx.fillStyle = colors[node.data.cluster]; //(node.data.alone) ? "orange" : "black"
          ctx.fillRect(pt.x-w/2, pt.y-w/2, w,w)
        })              
      },
      
      initMouseHandling:function(){
        // no-nonsense drag and drop (thanks springy.js)
        var dragged = null;

        // set up a handler object that will initially listen for mousedowns then
        // for moves and mouseups while dragging
        var handler = {
          clicked:function(e){
            var pos = $(canvas).offset();
            _mouseP = arbor.Point(e.pageX-pos.left, e.pageY-pos.top)
            dragged = particleSystem.nearest(_mouseP);

            if (dragged && dragged.node !== null){
              // while we're dragging, don't let physics move the node
              dragged.node.fixed = true
            }

            $(canvas).bind('mousemove', handler.dragged)
            $(window).bind('mouseup', handler.dropped)

            return false
          },
          dragged:function(e){
            var pos = $(canvas).offset();
            var s = arbor.Point(e.pageX-pos.left, e.pageY-pos.top)

            if (dragged && dragged.node !== null){
              var p = particleSystem.fromScreen(s)
              dragged.node.p = p
            }

            return false
          },

          dropped:function(e){
            if (dragged===null || dragged.node===undefined) return
            if (dragged.node !== null) dragged.node.fixed = false
            dragged.node.tempMass = 1000
            dragged = null
            $(canvas).unbind('mousemove', handler.dragged)
            $(window).unbind('mouseup', handler.dropped)
            _mouseP = null
            return false
          }
        }
        
        // start listening
        $(canvas).mousedown(handler.clicked);

      },
      
    }
    return that
  }    

  $(document).ready(function(){
    var sys = arbor.ParticleSystem(1000, 600, 0.5) // create the system with sensible repulsion/stiffness/friction
    sys.parameters({gravity:true}) // use center-gravity to make the graph settle nicely (ymmv)
    sys.renderer = Renderer("#viewport") // our newly created renderer will have its .init() method called shortly by sys...

    g =  new Graph();

    project = getUrlParameter("w");

    
    $.getJSON("../../API/getAllRelations.php?w=" + project , function(data){
        //console.log(data);

        for(var i = 0; i<data.length && i<500; i++){
            sys.addNode(data[i].nick1,{cluster: 1});
            sys.addNode(data[i].nick2,{cluster: 1});
            sys.addEdge(data[i].nick1,data[i].nick2);
            g.addNode(data[i].nick1);
            g.addNode(data[i].nick2);
            g.addEdge(data[i].nick1,data[i].nick2,eval(data[i].c));

        }
        //console.log(g);



        var result = g.getMarkovCluster(3,6);
        //console.log(result);
        
        var colorIndex = 0;
        for(var i = 0; i<result.length; i++){

            for(var j = 0; j<result[i].length; j++){
                if(result[i][j]!=0){
                    var nodespec = g.nodes[j];
                    //console.log(nodespec);
                    var nn = sys.getNode(nodespec);
                    //console.log(nn.data);
                    nn.data.cluster = colorIndex;
                }
            }

            colorIndex++;
            if(colorIndex>=colors.length){
                colorIndex = 0;
            }
        }


    });

    /*
    sys.addNode('a',{cluster: 1});
    sys.addNode('b',{cluster: 1});
    sys.addNode('c',{cluster: 1});
    sys.addNode('d',{cluster: 1});
    sys.addNode('e',{cluster: 1});
    sys.addNode('f',{cluster: 1});
    sys.addNode('g',{cluster: 1});
    sys.addNode('h',{cluster: 1});
    sys.addNode('i',{cluster: 1});

    sys.addEdge('a','b');
    sys.addEdge('b','a');
    sys.addEdge('a','c');
    sys.addEdge('c','a');
    sys.addEdge('a','d');
    sys.addEdge('d','a');
    sys.addEdge('a','b');
    sys.addEdge('b','d');
    sys.addEdge('d','b');
    sys.addEdge('d','a');
    sys.addEdge('d','f');
    sys.addEdge('e','f');
    sys.addEdge('e','i');
    sys.addEdge('e','a');
    sys.addEdge('f','i');
    sys.addEdge('f','a');
    sys.addEdge('g','i');
    sys.addEdge('h','b');


    g.addNode('a');
    g.addNode('b');
    g.addNode('c');
    g.addNode('d');
    g.addNode('e');
    g.addNode('f');
    g.addNode('g');
    g.addNode('h');
    g.addNode('i');

    g.addEdge('a','b',1);
    g.addEdge('b','a',1);
    g.addEdge('a','c',1);
    g.addEdge('c','a',2);
    g.addEdge('a','d',5);
    g.addEdge('d','a',1);
    g.addEdge('a','b',2);
    g.addEdge('b','d',4);
    g.addEdge('d','b',1);
    g.addEdge('d','a',1);
    g.addEdge('d','f',1);
    g.addEdge('e','f',1);
    g.addEdge('e','a',1);
    g.addEdge('e','i',1);
    g.addEdge('f','i',1);
    g.addEdge('f','a',1);
    g.addEdge('g','i',1);
    g.addEdge('h','b',1);
    */

    
    // or, equivalently:
    //
    // sys.graft({
    //   nodes:{
    //     f:{alone:true, mass:.25}
    //   }, 
    //   edges:{
    //     a:{ b:{},
    //         c:{},
    //         d:{},
    //         e:{}
    //     }
    //   }
    // })
    
  })

})(this.jQuery)


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