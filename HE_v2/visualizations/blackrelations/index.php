<html>
<head>
	<meta charset="UTF-8">

	<link href="css/style.css" rel="stylesheet">

	<style>
		html,body{
			margin: 0px;
			padding: 0px;
			background: #000000;
			color: #FFFFFF;
			font: 10px Helvetica, Arial, sans-serif;
			width:1280px;
			height: 480px; 
			overflow: hidden;
		}

		
		#wrapper{
			margin: 0px;
			padding: 0px;
			background: #000000;
			color: #FFFFFF;
			font: 10px Helvetica, Arial, sans-serif;
			width:2048px;
			height: 768px;
			overflow: hidden;	
		}
		#part2{
			position: absolute;
			top: 0px;
			left: 0px;
			margin: 0px;
			padding: 0px;
			background: #000000;
			color: #FFFFFF;
			font: 10px Helvetica, Arial, sans-serif;
			width:100%;
			height: 100%;	
			z-index: 100;
			overflow: hidden;
		}

		#randomrel{
			position: absolute;
			top: 10px;
			left: 10px;
			margin: 0px;
			padding: 0px;
			background: rgba(0,0,0,0.5);
			border: 1px solid #00FF00;
			color: #FFFFFF;
			font: 10px Helvetica, Arial, sans-serif;
			width:500px;
			height: 500px;	
			z-index: 500;
			overflow: hidden;	
		}

		.imProfile{
			position: relative;
			float:left;
			background: transparent;
			width:20px;
			height:20px;
			padding: 0px;
			margin: 0px;
		}
		.imProfIm{
			position: relative;
			display: block;
			float: left;
			width: 16px;
			height: 16px;
			border: 0px;
			margin: 2px;
			padding: 0px;
			-webkit-transition-property: height, width;
    		-webkit-transition-duration: 0.5s;
    		z-index: 100;
		}
		.imProfIm:hover{
			position: relative;
			display: block;
			float: left;
			width: 30px;
			height: 30px;
			border: 0px;
			margin: 2px;
			padding: 0px;
			-webkit-transition-property: height, width;
    		-webkit-transition-duration: 0.5s;
    		z-index: 200;
		}



div#blackbar{
    margin: 0px;
    padding: 0px;
    width:1024px;
    height: 200px;
    background: #000000;
    color: #000000;
    font: 10px Helvetica, Arial, sans-serif;
    overflow: hidden;
}
div#emc1container{
    margin: 0px;
    padding: 0px;
    width:1024px;
    height: 568px;
    background: #000000;
	color: #FFFFFF;
    font: 10px Helvetica, Arial, sans-serif;
    overflow: hidden;
}


div#mapholder{
	position: absolute;
	top: 0px;
	left: 2048;
	margin: 0px;
    padding: 0px;
    width:1024px;
    height: 768px;
    background: #FFFF00;
    color: #000000;
    font: 10px Helvetica, Arial, sans-serif;
    overflow: hidden;
}

        #classescontainer{
            position: absolute;
            z-index: 900;
            background: transparent;
            color: #FFFFFF;
            top: 205px;
            left: 2053px;
            width: 100px;
            padding: 0px;
            margin: 0px;
        }





		div#popover{
			position: absolute;
			z-index: 600;
			width: 600px;
			height: 400px;
			min-width: 600px;
			min-height: 400px;
			max-width: 600px;
			max-height: 400px;
			overflow: hidden;
			top: -400px;
			left: 600px;
			background: #000000;
			color: #FFFFFF;
		}

		div#popoverwrap{
			z-index: 600;
			position: relative;
			margin: 20px;
			width: 560px;
			height: 360px;
			background: #FFFFFF;
			color: #000000;
		}

		img#popoverimg{
			display: block;
			position: relative;
			top: -370px;
			left: 30px;
			z-index: 650;
			width: 100px;
			height: 100px;
		}
		div#popovername{
			display: block;
			position: relative;
			top: -475px;
			left: 270px;
			z-index: 650;
			width: 300px;
			height: 100px;
			color: #000000;
			font: bold 35px Helvetica,Arial,sans-serif;
			text-align: right;
			overflow: hidden;
		}

		div.noResults{
			width:50px;
			margin: auto;
			padding-top: 146px;
			font: bold 130px Helvetica,Arial,sans-serif;
			color: #FF00FF;
		}




		.rrnode circle{
			fill: #00FF00;
			stroke: none;
		}

		.rrlink{
			fill: none;
			stroke: #00FF00;	
		}


		.rrnodetitle{
			stroke: none;
			fill: #FFFFFF;
			font: 9px "Helvetica Neue", Helvetica, Arial, sans-serif;
			opacity: 0.6;
		}

		
	</style>
	<script type="text/javascript" src="../js/jquery-2.0.3.min.js"></script>
	<?php

		require_once('../../API/db.php');

	?>

	<script src="../js/three.min.js"></script>
	<script src="../js/controls/OrbitControls.js"></script>
	<script src="../js/tween.min.js"></script>

	<script type="text/javascript" src="js/vis.js"></script>
	<script type="text/javascript" src="js/jquery-2.1.3.min.js"></script>
	<script type="text/javascript" src="js/d3.min.js"></script>
	<link href="js/vis.css" rel="stylesheet" type="text/css" />

	<script type="text/javascript">

		var classes,classesPS;
		var renderer,scene,camera,controls;
		var mindelta = 30;
		var particles1, particles10, particles20, particlesmax;
    	var groupparticles1, groupparticles10, groupparticles20, groupparticlesmax;
		var connections;
    	var WIDTH = window.innerWidth;
		var HEIGHT = window.innerHeight;


		var citycode = "<?php 
				if(isset($_REQUEST['w'])){
					echo($_REQUEST['w']);
				} else {
					echo('rome');
				}
		?>";

		var counterBoxes = 0;
		var counterProfiles = 0;
		var totBoxes = 9216;


		//for graphviz in popover
		var nodes = null;
	    var edges = null;
	    var network = null;
	    //for graphviz in popover

	    var totalheight = 768;
		var maskheight = 0;
		var canvasheight = totalheight - maskheight;
	
		

		var highestProfileID = 0;

		var currentNick = null;

		var profiles;

		var timerFlipAnotherOne = null;

		var timerInsert1 = null;
		var timerInsert2 = null;
		var timerInsert3 = null;
		var timerInsert4 = null;
		var timerInsert5 = null;

		$( document ).ready(function() {
 			
			profiles = new Array();


 			initRelations();

 			$("div#popover").css("left", Math.round( WIDTH/2.0 - $("div#popover").width()/2) );


 			$("div#popover").click(function(){
 				$("div#popover").animate(
					{
						top: "-400px"
					},500,function(){


						//$("#popoverwrap").html("<div class='noResults'>?</div>");
						
					}
				);
 			});

 			
 			$(".imProfIm").click(function(){
 				var elem = $(this);
 				//console.log(elem.attr("nick"));
 				slideInPopover(elem.attr("nick"));
 			});


 			showRandomRelations();
    
		});


		// random relations start

		var rrwidth, rrheight;
		var rrcolor;
		var rrforce;
		var rrsvg;


		var timerrandrel = null;
		var delayrandrel = 12000;

		var targetrrheight = 10;

		var showRandomRelations = function(){


			$("#randomrel").height(  $(document).innerHeight() - 100  );

			targetrrheight = Math.floor( (   $(document).innerHeight() - $("#randomrel").height()  ) / 2   );

			rrwidth = $("#randomrel").width();
			rrheight = $("#randomrel").height();

			rrcolor = d3.scale.category20();

			rrforce = d3.layout.force()
			    .charge(-100)
			    .linkDistance(120)
			    .size([rrwidth, rrheight]);

			$("#randomrel").html("");

			rrsvg = d3.select("#randomrel").append("svg")
			    .attr("width", rrwidth)
			    .attr("height", rrheight);

			$("#randomrel").animate(
				{
					top: "-2000px"
				}, 1000,
				function(){

					// load data and process it - begin



					d3.json("../../API/getRandomRelationGraph.php?w=" + citycode , function(error, graph) {
		  				if (error) throw error;


		  				rrforce
					      .nodes(graph.nodes)
					      .links(graph.links)
					      .start();

					    var link = rrsvg.selectAll(".rrlink")
					    	.data(graph.links)
					    	.enter().append("line")
					    	.attr("class", "rrlink")
					    	.style("stroke-width", function(d) { return Math.sqrt(d.value); });

					    var node = rrsvg.selectAll(".rrnode")
					    	.data(graph.nodes)
					    	.enter()
					    	.append("svg:g")
					    	.attr("class", "rrnode")
					    	.call(rrforce.drag);

					    node.append("circle")
					      	.attr("r", 5);
					      	

					    node.append("svg:text")
		      				.text(function(d) { return d.name; })
		      				.attr("dx", 12)
				            .attr("dy", ".35em")
		      				.attr("class", "rrnodetitle");

		      			rrforce.on("tick", function() {
						    link.attr("x1", function(d) { return d.source.x; })
						        .attr("y1", function(d) { return d.source.y; })
						        .attr("x2", function(d) { return d.target.x; })
						        .attr("y2", function(d) { return d.target.y; });

						    node.attr("transform", function(d) {
				                return "translate(" + d.x + "," + d.y + ")";
				            });
						});


						$("#randomrel").animate(
							{
								top: targetrrheight + "px"
							}, 1000,
							function(){

								if(timerrandrel!=null){
									clearTimeout(timerrandrel);
								}
								timerrandrel = setTimeout(showRandomRelations, delayrandrel );

							}
						);

		  			});




					// load data and process it - begin

				}
			);

		}


		// random relations end


		function slideInPopover(nick){

			currentNick = nick;

			if(currentNick!=null && typeof currentNick != 'undefined'){
				if($("div#popover").attr("top")!=-400){
					$("div#popover").animate(
						{
							top: "-400px"
						},500,function(){
							loadPopoverUser();
						}
					);
				} else {
					loadPopoverUser();
				}
			}
		}

		function loadPopoverUser(){

			$.getJSON("../../API/getUserProfile.php",{n: currentNick},function(data){

				//console.log(data);

				//console.log("user got:" + currentNick );

				// preparare

				var iu = "blank.png";
				if(data["user"] && data["user"].image_url && typeof data["user"].image_url != 'undefined' && data["user"].image_url!="" ){
					iu = data["user"].image_url;
				}

				$("img#popoverimg").attr("src",iu);

				$("div#popovername").text(data["user"].nick);

				$("div#popoverwrap").text("");

				nodes = new Array();
				edges = new Array();

				var color = '#BFBFBF';

				for(var i = 0 ; i<data["relations"].length; i++){

					//console.log(data["relations"][i]);

					var n1 = data["relations"][i].n1;
					var n2 = data["relations"][i].n2;
					var c = data["relations"][i].c;
					var i1 = "blank.png";
					if(data["relations"][i].i1  && typeof data["relations"][i].i1 != 'undefined' && data["relations"][i].i1!="" ){
						i1 = data["relations"][i].i1;
					}
					var i2 = "blank.png";
					if(data["relations"][i].i2  && typeof data["relations"][i].i2 != 'undefined' && data["relations"][i].i2!="" ){
						i2 = data["relations"][i].i2;
					}
					//console.log(i1 + "-->" + i2);

					var idx1 = -1;
					var idx2 = -1;
					
					for(var j = 0; j<nodes.length && (idx1==-1 || idx2==-1 ) ; j++ ){
						if(nodes[j].label==n1){
							idx1 = j;
						}
						if(nodes[j].label==n2){
							idx2 = j;
						}
					}

					//console.log(idx1 + "--" + idx2);

					if(idx1==-1){
						idx1 = nodes.length;
						//console.log("nodes(1):before:" + nodes.length );
						//nodes.push(  {  id: idx1 , label: n1, image: i1  , shape: 'image'} );
						nodes.push(  {  id: idx1 , label: n1, shape: 'dot'} );
						//console.log("nodes(1):after:" + nodes.length );
					}

					if(idx2==-1){
						idx2 = nodes.length;
						//console.log("nodes(2):before:" + nodes.length );
						//nodes.push( {  id: idx2 , label: n2, image: i2  , shape: 'image' } );
						nodes.push( {  id: idx2 , label: n2, shape: 'dot' } );
						//console.log("nodes(2):after:" + nodes.length );
					}

					edges.push(  {from: idx1, to: idx2, value: c, label: c, color: color}  );


				}

				//console.log(edges);
				//console.log(nodes);

				if(nodes.length==0 || edges.length==0){

					//console.log("nodes or edges empty");

					$("#popoverwrap").html("<div class='noResults'>?</div>");

				}
				else {

					//console.log("[a]");

					var container = document.getElementById('popoverwrap');

					//console.log("container:");

					//console.log(container);

					var data = {
						nodes: nodes,
						edges: edges
					};
					var options = {
						nodes: {
				          shape: 'dot',
				          color: '#FF0000'
				        },
				        edges: {
				          color: '#777777'
				        }
					};
					network = new vis.Network(container, data, options);

					network.on('select', function(properties) {
						//console.log(properties);
						if(properties.nodes.length>0){
							var nodeid = properties.nodes[0];
							var found = false;
							for(var i=0; i<nodes.length && !found;i++){
								if(nodes[i].id==nodeid){
									found = true;
									slideInPopover(nodes[i].label);
								}
							}
						}
					});

	
				}

				

				// e poi portare giu in popover
				$("div#popover").animate(
					{
						top:  (maskheight+20) + "px"
					},500,function(){
						// poi fare qualcosa
					}
				);

			});
		}

		function setupBoxes(){
			for(var i = 0; i<totBoxes ; i++){
				var ele = "<div class='imProfile' id='div-" + i + "'><img src='blank.png' id='im-" + i + "' class='imProfIm' /></div>";
				$("div#part1").append(ele);
			}
		}

		function loadProfiles(){
			
			if(timerFlipAnotherOne!=null){
				window.clearTimeout(timerFlipAnotherOne);
			}

			$.getJSON("../../API/getUsers.php?w=" + citycode ,{  fromID: highestProfileID  },function(data){
				//console.log(data.length);

				//console.log(data);
				
				loadProfileData(data);
				
				//console.log( profiles );

			});
		}

		function loadProfileData( data){

			for(var i = 0; i<data.length; i++){
				var p = new Object();
				p.id = data[i].id;
				p.nick = data[i].nick;
				p.url = data[i].profile_url;
				p.im =  data[i].image_url;

				if(p.id>highestProfileID){
					highestProfileID = p.id;
				}

				profiles.push( p );
			}
			flipAnotherOne();
		}


		function flipAnotherOne(){
			if(counterBoxes>=totBoxes){
				counterBoxes = 0;
			}
			counterBoxes = Math.floor(Math.random() * totBoxes);
			if(counterProfiles>=profiles.length){
				counterProfiles = 0;
				if(timerFlipAnotherOne!=null){
					window.clearTimeout(timerFlipAnotherOne);
				}
				loadProfiles();
			}
			var idBox = "im-" + counterBoxes;
			$("img#" + idBox).fadeOut(200,function(){
				$("img#" + idBox).attr("src",profiles[counterProfiles].im);
				$("img#" + idBox).attr("nick",profiles[counterProfiles].nick);
				$("img#" + idBox).attr("numProfile",profiles[counterProfiles].counterProfiles);
				$("img#" + idBox).fadeIn(200,function(){
					counterProfiles++;
					counterBoxes++;
					timerFlipAnotherOne = window.setTimeout("flipAnotherOne();", 50);
				});
			});
		}



		
		var VIEW_ANGLE = 45,
		  ASPECT = WIDTH / HEIGHT,
		  NEAR = 0.1,
		  FAR = 10000;

		var $container;

		var directionalLight,plight;

		var amplitude = 4000;
		var circleStep;

		var users,psize;

		var selected_block;

		var relations, particles, currRelation;

		var attraction1to10, attraction10to20, attraction20tomax,attractions;

		var gmat1 = new THREE.MeshBasicMaterial( { color: 0xFFFF00} );
		var gmat10 = new THREE.MeshBasicMaterial( { color: 0xFFFF00 } );
		var gmat20 = new THREE.MeshBasicMaterial( { color: 0xFFFF00 } );
		var gmatmax = new THREE.MeshBasicMaterial( { color: 0xFFFF00 , opacity: 0.8} );

		var blockMaterialTW = new THREE.MeshBasicMaterial({color: 0x8888FF});
		var blockMaterialFB = new THREE.MeshBasicMaterial({color: 0x000088});
		var blockMaterialOT = new THREE.MeshBasicMaterial({color: 0x000088});

		var geometry1 = new THREE.Geometry();
		var geometry10 = new THREE.Geometry();
		var geometry20 = new THREE.Geometry();
		var geometrymax = new THREE.Geometry();


		var lgeom;


		var steps = 70.0;
		var delta = 40.0;


		var maxcoord = 8000.0;


		var timerGrabRelations = null;

		function loadTexture(url) {
		    var image = new Image();
		    var texture = new THREE.Texture(image);
		    image.onload = function() {
		        texture.needsUpdate = true;
		        //console.log("texture " + url + " loaded");
		    };
		    image.src = url;
		    return texture;
		}


		function initRelations(){
			psize = 30
    		currRelation = 0;

    		$container = $('#part2');

    		renderer = new THREE.WebGLRenderer();
			renderer.shadowMapEnabled = true;
			renderer.shadowMapSoft = true;

			attraction1to10 = new Array();
			attraction10to20 = new Array();
			attraction20tomax = new Array();
			attractions = new Array();

			camera =
			  new THREE.PerspectiveCamera(
			    VIEW_ANGLE,
			    ASPECT,
			    NEAR,
			    FAR);

			camera.rotation.x = 0;//Math.PI/7.0;
			camera.position.y = 0;


			controls = new THREE.OrbitControls( camera , renderer.domElement );

			scene = new THREE.Scene();
			scene.fog = new THREE.FogExp2( 0x000000, 0.0002 );

			scene.add(camera);

			camera.position.z = 1500;

			renderer.setSize(WIDTH, HEIGHT);

			//console.log(renderer.domElement);

			$container.append(renderer.domElement);

			classesPS = new Array();


			groupparticlesmax = new THREE.Object3D();
			groupparticles20 = new THREE.Object3D();
			groupparticles10 = new THREE.Object3D();
			groupparticles1 = new THREE.Object3D();
			

			scene.add(groupparticles1);
			scene.add(groupparticles10);
			scene.add(groupparticles20);
			scene.add(groupparticlesmax);


			directionalLight = new THREE.DirectionalLight( 0xffffff, 0.5 );
			directionalLight.position.set( 0, 0.5, 0 );
			directionalLight.castShadow = true;
			directionalLight.shadowCameraVisible = false;
			directionalLight.position.set(0,0,2000);
			scene.add( directionalLight );
			

			plight = new THREE.PointLight(0xFFFFFF, 1, 2000)
			plight.position.set(0,0,0);
			scene.add(plight);

			lgeom = new THREE.Geometry();

			connections = new THREE.Object3D();
			/*
			new THREE.Line(
				lgeom,
				new THREE.LineBasicMaterial({ color: 0xffff00, linewidth: 1 , transparent: true, opacity: 0.5 }),
				THREE.LinePieces
			);
			*/

			scene.add(connections);
			
			grabRelations();


			initEventHandling();

			requestAnimationFrame(render);


		}//initrelations


		function grabRelations(){

			if(timerGrabRelations!=null){
				window.clearTimeout(timerGrabRelations);
				timerGrabRelations = null;
			}

			$.getJSON("../../API/getLatestRelations.php?w=" + citycode,{},function(data){

				for(var i = 0; i<data.length; i++){

					var fv = null;
					var tv = null;

					var numfound = 0;

					var nome1 = data[i].nick1;
					var found = false;

					for(var j = 0; j<groupparticlesmax.children.length && !found; j++){
						if(groupparticlesmax.children[j].nick==nome1){
							found = true;
							numfound++;
							fv = groupparticlesmax.children[j].position;
							fv.referenceNome = nome1;

						}
					}
					if(!found){
						var vvv = new THREE.Mesh( new THREE.CubeGeometry(8, 8, 8,1,1,1) , gmatmax);
						vvv.position.x = Math.random() * 4000 - 2000;
						vvv.position.y = Math.random() * 4000 - 2000;
						vvv.position.z = Math.random() * 4000 - 2000;
						vvv.idd=data[i].id;
						vvv.id_social=data[i].id;
						vvv.nick=data[i].nick1;
						vvv.profile_url="";
						vvv.image_url="";
						vvv.source="";
						fv = vvv.position;
						fv.referenceNome = nome1;
						groupparticlesmax.add(vvv);	
					}


					var nome2 = data[i].nick2;
					found = false;
					for(var j = 0; j<groupparticlesmax.children.length && !found; j++){
						if(groupparticlesmax.children[j].nick==nome2){
							found = true;
							numfound++;
							tv = groupparticlesmax.children[j].position;
							tv.referenceNome = nome2;
						}
					}
					if(!found){
						var vvv = new THREE.Mesh( new THREE.CubeGeometry(8, 8, 8,1,1,1) , gmatmax);
						vvv.position.x = Math.random() * 4000 - 2000;
						vvv.position.y = Math.random() * 4000 - 2000;
						vvv.position.z = Math.random() * 4000 - 2000;
						vvv.idd=data[i].id;
						vvv.id_social=data[i].id;
						vvv.nick=data[i].nick2;
						vvv.profile_url="";
						vvv.image_url="";
						vvv.source="";
						tv = vvv.position;
						tv.referenceNome = nome2;
						groupparticlesmax.add(vvv);	
					}


					if(fv!=null && tv!=null && numfound<2){
						// mettere linea
						
							var lgeom2 = new THREE.Geometry();

							lgeom2.vertices.push(  fv  );
							lgeom2.vertices.push(  tv   );

							var connectionschild = new THREE.Line(
								lgeom2,
								new THREE.LineBasicMaterial({ color: 0xFFFFFF, linewidth: 1 , transparent: true, opacity: 0.5 }),
								THREE.LinePieces
							);	

						
						connections.add( connectionschild );

						connections.needsUpdate = true;
						
					}//if(fv!=null && tv!=null)

					
				}

				groupparticlesmax.needsUpdate = true;

				
				//console.log(connections);

				timerGrabRelations = window.setTimeout("grabRelations();",10000);


			});

		}//grabRelations


		function resetCamera(){
			camera.rotation.x = 0;
			camera.rotation.y = 0;
			camera.rotation.z = 0;
			camera.position.x = 0;
			camera.position.y = 0;
			camera.position.z = 1000;
		}

		function render(){
		  requestAnimationFrame(render);

		  controls.update();
		  TWEEN.update();

		  			var time = Date.now() * 0.00005;

					if(groupparticles1) { groupparticles1.rotation.y = time * 0.3; }
					if(groupparticles10) { groupparticles10.rotation.y = time * 0.3; }
					if(groupparticles20) { groupparticles20.rotation.y = time * 0.3; }
					if(groupparticlesmax) { groupparticlesmax.rotation.y = time * 0.3; }
					if(connections) { connections.rotation.y = time * 0.3; }


			doAnims();
					
		  
		  
		  renderer.render(scene, camera);
		};




		function doAnims(){

			//console.log("--- anim ---");


			if(groupparticlesmax.children.length>2000){
				var o = groupparticlesmax.children[0];
				var ni = o.nick;
				//console.log("removing:" + ni);
				groupparticlesmax.remove(o);
				for(var i = connections.children.length-1; i>=0; i--){
					var oi = connections.children[i];
					var vfrom = oi.geometry.vertices[0];
					var vto = oi.geometry.vertices[1];
					if(vfrom.referenceNome==ni || vto.referenceNome==ni){
						connections.remove(oi);
						//console.log("removing:" + oi);
					}

				}
			}


			for(var i = 0; i<connections.children.length; i++){
				var vfrom = connections.children[i].geometry.vertices[0];
				var vto = connections.children[i].geometry.vertices[1];

				//console.log("------");
				//console.log(vfrom);
				//console.log(vto);

				var deltax = ( vto.x - vfrom.x );
				var deltay = ( vto.y - vfrom.y );
				var deltaz = ( vto.z - vfrom.z );

				var distance = Math.sqrt(  deltax*deltax + deltay*deltay + deltaz*deltaz  );

				if( distance>delta ){
					vfrom.x = vfrom.x + deltax/steps;
					vfrom.y = vfrom.y + deltay/steps;
					vfrom.z = vfrom.z + deltaz/steps;

					vto.x = vto.x - deltax/steps;
					vto.y = vto.y - deltay/steps;
					vto.z = vto.z - deltaz/steps;

					var fff = false;
					for(var k = 0; k<groupparticlesmax.children.length && !fff; k++){
						if(groupparticlesmax.children[k].nick==vfrom.referenceNome){
							fff = true;
							groupparticlesmax.children[k].position = vfrom;
						}
					}
					//groupparticlesmax.children[ vfrom.reference ].position = vfrom;
					fff = false;
					for(var k = 0; k<groupparticlesmax.children.length && !fff; k++){
						if(groupparticlesmax.children[k].nick==vto.referenceNome){
							fff = true;
							groupparticlesmax.children[k].position = vto;
						}
					}
					//groupparticlesmax.children[ vto.reference ].position = vto;

					connections.children[i].geometry.vertices[0] = vfrom;
					connections.children[i].geometry.vertices[1] = vto;	
					connections.children[i].needsUpdate = true;
					connections.children[i].geometry.verticesNeedUpdate = true;
					
				}

			}

			connections.needsUpdate = true;
			
			groupparticles1.needsUpdate = true;
			groupparticles10.needsUpdate = true;
			groupparticles20.needsUpdate = true;
			groupparticlesmax.needsUpdate = true;
			
		}




		initEventHandling = (function() {
			var _vector = new THREE.Vector3,
				projector = new THREE.Projector(),
				handleMouseDown, handleMouseMove, handleMouseUp;
			
			handleMouseDown = function( evt ) {
				var ray, intersections;

				//console.log(evt.clientX + "," + evt.clientY );

				/*
				_vector.set(
					( evt.clientX / window.innerWidth ) * 2 - 1,
					-( evt.clientY / window.innerHeight ) * 2 + 1,
					1
				);
				*/
				_vector.set(
					( evt.clientX / WIDTH ) * 2 - 1,
					-( (evt.clientY) / HEIGHT  ) * 2 + 1,
					1
				);

				projector.unprojectVector( _vector, camera );
				
				ray = new THREE.Raycaster( camera.position, _vector.sub( camera.position ).normalize() );
				intersections = ray.intersectObjects( groupparticlesmax.children );

				if ( intersections.length > 0 ) {
					selected_block = intersections[0].object;
					//console.log(selected_block);
					if(selected_block.nick){
						showBlock(selected_block, selected_block.position.clone() );
					}
				}

				

			};
			
			handleMouseMove = function( evt ) {
				
				
			};
			
			handleMouseUp = function( evt ) {
				
				if ( selected_block !== null ) {
					
					
					selected_block = null;
				}
				
			};
			
			return function() {
				renderer.domElement.addEventListener( 'mousedown', handleMouseDown );
				renderer.domElement.addEventListener( 'mousemove', handleMouseMove );
				renderer.domElement.addEventListener( 'mouseup', handleMouseUp );
			};
		})();



		function showBlock(s,p){
	 		//console.log(s);

	 		slideInPopover(s.nick)

	 		/*
	 		var ss = "<h1>" + s.nick + "</h1><br />Source:" + s.source + "<br /><a href='" + s.profile_url + "' target='_blank'>OPEN</a>";
	 		$("div#infobox").html(ss);
	 		$("div#infobox").show();
	 		*/
	 	}



	</script>

	<!-- relations -->
    
</head>
<body>
	<!--div id="wrapper"-->
		<div id="part2">
		</div>

	<!--/div-->


	<div id="classescontainer"></div>

	<div id="popover">
		<div id="popoverwrap">
		</div>
		<img id="popoverimg" src="blank.png" border="0" />
		<div id="popovername"></div>
	</div>



	<div id="randomrel"></div>

</body>
</html>