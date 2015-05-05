<html>
<head>
			<!-- Facebook Metadata /-->
		<meta property="fb:page_id" content="79403465956" />
		<meta property="og:image" content="http://artisopensource.net/HE/HE_logo.png" />
		<meta property="og:description" content="Human Ecosystems: the real-time relational ecosystems of cities. Rome, S. Paulo."/>
		<meta property="og:type" content="website" />
		<meta property="og:title" content="Human Ecosystems" />
		<meta property="og:url" content="http://www.artisopensource.net/HE" />
		<meta property="og:site_name" content="Human Ecosystems" />
		

		<!-- Google+ Metadata /-->
		<meta itemprop="name" content="Human Ecosystems">
		<meta itemprop="description" content="Human Ecosystems: the real-time relational ecosystems of cities. Rome, S. Paulo.">
		<meta itemprop="image" content="http://artisopensource.net/HE/HE_logo.png">

		<title>Human Ecosystems</title>
		<meta name="description" content="Human Ecosystems: the real-time relational ecosystems of cities. Rome, S. Paulo." />
		<meta name="keywords" content="Human Ecosystems, smart city, smart cities, smart communities, urban sensing, big data, bigdata, realtime city, real-time city" />
		<meta name="author" content="humans.txt">

		<link rel="shortcut icon" href="favicon.png" type="image/x-icon" />

		<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200' rel='stylesheet' type='text/css'>

		<link href="../../css/style.css" rel="stylesheet">
</head>
<body>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-387817-3', 'artisopensource.net');
  ga('send', 'pageview');

</script>

	<?php

		require_once('../db.php');

	?>

	<div id="emc1container"></div>
	<div id="classescontainer"></div>
	
	<div id="infobox"></div>


	<script src="js/three.min.js"></script>
	<script src="js/controls/OrbitControls.js"></script>
	<script src="js/tween.min.js"></script>
	<script src="js/jquery-2.0.3.min.js"></script>
    <script>

    var classes,classesPS;

    var renderer,scene,camera,controls;

    var mindelta = 30;

    var particles1, particles10, particles20, particlesmax;
    var groupparticles1, groupparticles10, groupparticles20, groupparticlesmax;

    var connections;
    
    var WIDTH = window.innerWidth,
		  HEIGHT = window.innerHeight;

	
		// set some camera attributes
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

	var steps = 70.0;
	var delta = 500.0;
	var deltarepulsion = 100.0;

	//var steps2 = 380.0;
	//var delta2 = 400.0;

	var maxcoord = 8000.0;

function loadTexture(url) {
    var image = new Image();
    var texture = new THREE.Texture(image);
    image.onload = function() {
        texture.needsUpdate = true;
        console.log("texture " + url + " loaded");
    };
    image.src = url;
    return texture;
}


    $( document ).ready(function() {

    	psize = 30
    	currRelation = 0;

    	
		// get the DOM element to attach to
		// - assume we've got jQuery to hand
		$container = $('#emc1container');

		// create a WebGL renderer, camera
		// and a scene
		renderer = new THREE.WebGLRenderer();
		renderer.shadowMapEnabled = true;
		renderer.shadowMapSoft = true;

		camera =
		  new THREE.PerspectiveCamera(
		    VIEW_ANGLE,
		    ASPECT,
		    NEAR,
		    FAR);

		camera.rotation.x = 0;//Math.PI/7.0;
		camera.position.y = 0;



		controls = new THREE.OrbitControls( camera , renderer.domElement );
		//controls.addEventListener( 'change', render );

		scene = new THREE.Scene();
		scene.fog = new THREE.FogExp2( 0x000000, 0.0002 );

		// add the camera to the scene
		scene.add(camera);

		camera.position.z = 1500;

		renderer.setSize(WIDTH, HEIGHT);

		// attach the render-supplied DOM element
		$container.append(renderer.domElement);

		classesPS = new Array();

		var cbox = "<div class='legendBox'>";
		cbox = cbox + "<div class='legendcolor' style='background:#FF8000'></div>";
		cbox = cbox + "<div class='legendname' >Influencers / Operators</div>";
		cbox = cbox + "</div>";

		$("#classescontainer").append(cbox);

		cbox = "<div class='legendBox'>";
		cbox = cbox + "<div class='legendcolor' style='background:#00AA00'></div>";
		cbox = cbox + "<div class='legendname' >Bridges</div>";
		cbox = cbox + "</div>";

		$("#classescontainer").append(cbox);

		cbox = "<div class='legendBox'>";
		cbox = cbox + "<div class='legendcolor' style='background:#AAAAAA'></div>";
		cbox = cbox + "<div class='legendname' >Hubs</div>";
		cbox = cbox + "</div>";

		$("#classescontainer").append(cbox);

		cbox = "<div class='legendBox'>";
		cbox = cbox + "<div class='legendcolor' style='background:#555555'></div>";
		cbox = cbox + "<div class='legendname' >Simple Nodes</div>";
		cbox = cbox + "</div>";

		$("#classescontainer").append(cbox);

		cbox = "<div class='legendBox'>";
		cbox = cbox + "<div class='legendcolor'></div>";
		cbox = cbox + "<div class='legendname' ><a href='javascript:resetCamera();'>Reset Camera</a></div>";
		cbox = cbox + "</div>";

		$("#classescontainer").append(cbox);


		
		var blockMaterialTW = new THREE.MeshBasicMaterial({color: 0x8888FF});
		var blockMaterialFB = new THREE.MeshBasicMaterial({color: 0x000088});
		var blockMaterialOT = new THREE.MeshBasicMaterial({color: 0x000088});


		$.getJSON("getUsers.php?w=<?php echo($www); ?>",{},function(data){
			
			var geometry1 = new THREE.Geometry();
			var geometry10 = new THREE.Geometry();
			var geometry20 = new THREE.Geometry();
			var geometrymax = new THREE.Geometry();

			groupparticlesmax = new THREE.Object3D();
			groupparticles20 = new THREE.Object3D();
			groupparticles10 = new THREE.Object3D();
			groupparticles1 = new THREE.Object3D();
			

			var gmat1 = new THREE.MeshBasicMaterial( { color: 0x555555} );
			var gmat10 = new THREE.MeshBasicMaterial( { color: 0xAAAAAA } );
			var gmat20 = new THREE.MeshBasicMaterial( { color: 0x00aa00 } );
			var gmatmax = new THREE.MeshBasicMaterial( { color: 0xFF8000 } );


			for(var i = 0; i<data.length; i++){
				
				/*
				if(data[i].c<=15){

					var vvv = new THREE.Mesh( new THREE.CubeGeometry(5, 5, 5,1,1,1) , gmat1);
					vvv.position.x = Math.random() * 4000 - 2000;
					vvv.position.y = Math.random() * 4000 - 2000;
					vvv.position.z = Math.random() * 4000 - 2000;
					vvv.idd=data[i].id;
					vvv.id_social=data[i].id_social;
					vvv.nick=data[i].nick;
					vvv.profile_url=data[i].profile_url;
					vvv.image_url=data[i].image_url;
					vvv.source=data[i]["source"];
					groupparticles1.add(vvv);


				} else if(data[i].c<=30){

					var vvv = new THREE.Mesh( new THREE.CubeGeometry(7, 7, 7,1,1,1) , gmat10);
					vvv.position.x = Math.random() * 4000 - 2000;
					vvv.position.y = Math.random() * 4000 - 2000;
					vvv.position.z = Math.random() * 4000 - 2000;
					vvv.idd=data[i].id;
					vvv.id_social=data[i].id_social;
					vvv.nick=data[i].nick;
					vvv.profile_url=data[i].profile_url;
					vvv.image_url=data[i].image_url;
					vvv.source=data[i]["source"];
					groupparticles10.add(vvv);


				} else if(data[i].c<=40){

					var vvv = new THREE.Mesh( new THREE.CubeGeometry(10, 10, 10,1,1,1) , gmat20);
					vvv.position.x = Math.random() * 4000 - 2000;
					vvv.position.y = Math.random() * 4000 - 2000;
					vvv.position.z = Math.random() * 4000 - 2000;
					vvv.idd=data[i].id;
					vvv.id_social=data[i].id_social;
					vvv.nick=data[i].nick;
					vvv.profile_url=data[i].profile_url;
					vvv.image_url=data[i].image_url;
					vvv.source=data[i]["source"];
					groupparticles20.add(vvv);

				} else{

				*/

					var vvv = new THREE.Mesh( new THREE.CubeGeometry(15, 15, 15,1,1,1) , gmatmax);
					vvv.position.x = Math.random() * 4000 - 2000;
					vvv.position.y = Math.random() * 4000 - 2000;
					vvv.position.z = Math.random() * 4000 - 2000;
					vvv.idd=data[i].id;
					vvv.id_social=data[i].id_social;
					vvv.nick=data[i].nick;
					vvv.profile_url=data[i].profile_url;
					vvv.image_url=data[i].image_url;
					vvv.source=data[i]["source"];
					groupparticlesmax.add(vvv);
				/*
				}
				*/
				


			}


			//particles1 to particles10
			attraction1to10 = new Array();
			attraction10to20 = new Array();
			attraction20tomax = new Array();
			attractions = new Array();

			$.getJSON("../getRelations.php?w=<?php echo($www); ?>",{},function(data){

				//console.log(data);

				var lgeom = new THREE.Geometry();
		
		
		

				for(var i = 0; i<data.length; i++){
					var ffound1 = false;
					var ffound2 = false;
					var found1 = {
						in1: -1,
						in10: -1,
						in20: -1,
						inmax: -1
					};
					var found2 = {
						in1: -1,
						in10: -1,
						in20: -1,
						inmax: -1
					};

					var fv,tv;

					for(var j=0; j<groupparticles1.children.length  && (!ffound1.in1 || !ffound2); j++){
						if(groupparticles1.children[j].nick==data[i].nick1){
							found1.in1 = j;
							ffound1 = true;
							fv = groupparticles1.children[j].position;
						}
						if(groupparticles1.children[j].nick==data[i].nick2){
							found2.in1 = j;
							ffound2 = true;
							tv = groupparticles1.children[j].position;
						}
					}//for(var j=0; j<groupparticles1.children.length; j++)

					if(!ffound1 || !ffound2){
						for(var j=0; j<groupparticles10.children.length  && (!ffound1.in1 || !ffound2); j++){
							if(groupparticles10.children[j].nick==data[i].nick1){
								found1.in10 = j;
								ffound1 = true;
								fv = groupparticles10.children[j].position;
							}
							if(groupparticles10.children[j].nick==data[i].nick2){
								found2.in10 = j;
								ffound2 = true;
								tv = groupparticles10.children[j].position;
							}
						}//for(var j=0; j<groupparticles1.children.length; j++)
						if(!ffound1 || !ffound2){
							for(var j=0; j<groupparticles20.children.length  && (!ffound1.in1 || !ffound2); j++){
								if(groupparticles20.children[j].nick==data[i].nick1){
									found1.in20 = j;
									ffound1 = true;
									fv = groupparticles20.children[j].position;
								}
								if(groupparticles20.children[j].nick==data[i].nick2){
									found2.in20 = j;
									ffound2 = true;
									tv = groupparticles20.children[j].position;
								}
							}//for(var j=0; j<groupparticles1.children.length; j++)
							if(!ffound1 || !ffound2){
								for(var j=0; j<groupparticlesmax.children.length  && (!ffound1.in1 || !ffound2); j++){
									if(groupparticlesmax.children[j].nick==data[i].nick1){
										found1.inmax = j;
										ffound1 = true;
										fv = groupparticlesmax.children[j].position;
									}
									if(groupparticlesmax.children[j].nick==data[i].nick2){
										found2.inmax = j;
										ffound2 = true;
										tv = groupparticlesmax.children[j].position;
									}
								}//for(var j=0; j<groupparticles1.children.length; j++)
							}//if(!ffound1 || !ffound2){
						}//if(!ffound1 || !ffound2){
					}//if(!ffound1 || !ffound2){

					if(ffound1 && ffound2){
						var o = new Object();
						
						if(found1.in1!=-1){
							o.from = found1.in1;
							o.f = "1";	
						} else if(found1.in10!=-1){
							o.from = found1.in10;
							o.f = "10";	
						} else if(found1.in20!=-1){
							o.from = found1.in20;
							o.f = "20";	
						} else if(found1.inmax!=-1){
							o.from = found1.inmax;
							o.f = "max";	
						}

						if(found2.in1!=-1){
							o.to = found2.in1;
							o.t = "1";	
						} else if(found2.in10!=-1){
							o.to = found2.in10;
							o.t = "10";	
						} else if(found2.in20!=-1){
							o.to = found2.in20;
							o.t = "20";	
						} else if(found2.inmax!=-1){
							o.to = found2.inmax;
							o.t = "max";	
						}

						o.vx = 0;
						o.vy = 0;
						o.vz = 0;

						o.ax = 0;
						o.ay = 0;
						o.az = 0;


						o.finished = false;
						attractions.push(o);

						lgeom.vertices.push(  fv  );
						lgeom.vertices.push(  tv   );

					}//if(ffound1 && ffound2)

				}//for(var i = 0; i<data.length; i++)


				connections = new THREE.Line(
					lgeom,
					new THREE.LineBasicMaterial({ color: 0xffff00, linewidth: 1 , transparent: true, opacity: 0.5 }),
					THREE.LinePieces
				);

				scene.add(connections);
				

				connections.needsUpdate = true;
				connections.geometry.verticesNeedUpdate = true;


			});


			scene.add(groupparticles1);
			scene.add(groupparticles10);
			scene.add(groupparticles20);
			scene.add(groupparticlesmax);



		});

		
		directionalLight = new THREE.DirectionalLight( 0xffffff, 0.5 );
		directionalLight.position.set( 0, 0.5, 0 );
		directionalLight.castShadow = true;
		directionalLight.shadowCameraVisible = false;
		directionalLight.position.set(0,0,2000);
		scene.add( directionalLight );
		

		plight = new THREE.PointLight(0xFFFFFF, 1, 2000)
		plight.position.set(0,0,0);
		scene.add(plight);


		initEventHandling();

		requestAnimationFrame(render);


    });

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

	  			/*
				if(groupparticles1) { groupparticles1.rotation.y = time * 0.5; }
				if(groupparticles10) { groupparticles10.rotation.y = time * 0.5; }
				if(groupparticles20) { groupparticles20.rotation.y = time * 0.5; }
				if(groupparticlesmax) { groupparticlesmax.rotation.y = time * 0.5; }
				if(connections) { connections.rotation.y = time * 0.5; }
				*/


		doAnims();
				
	  
	  
	  renderer.render(scene, camera);
	};



	var smorzo = 1000;
	var repulsion = 10;
	var viscosity = 0.01;
	var nrepulsions = 200;


	function doAnims(){
		if(attractions && groupparticles1 && groupparticles10 && groupparticles20 && groupparticlesmax)
		{
			for(var i = 0 ; i<(attractions.length-1); i++   ){

				var vfrom, vto;
				
				if(attractions[i].f=="1"){
					vfrom = groupparticles1.children[ attractions[i].from ].position;
				} else if(attractions[i].f=="10"){
					vfrom = groupparticles10.children[ attractions[i].from ].position;
				} else if(attractions[i].f=="20"){
					vfrom = groupparticles20.children[ attractions[i].from ].position;
				} else if(attractions[i].f=="max"){
					vfrom = groupparticlesmax.children[ attractions[i].from ].position;
				}

				if(attractions[i].t=="1"){
					vto = groupparticles1.children[ attractions[i].to ].position;
				} else if(attractions[i].t=="10"){
					vto = groupparticles10.children[ attractions[i].to ].position;
				} else if(attractions[i].t=="20"){
					vto = groupparticles20.children[ attractions[i].to ].position;
				} else if(attractions[i].t=="max"){
					vto = groupparticlesmax.children[ attractions[i].to ].position;
				}


				var deltax = ( vto.x - vfrom.x );
				var deltay = ( vto.y - vfrom.y );
				var deltaz = ( vto.z - vfrom.z );

				var distance = Math.sqrt(  deltax*deltax + deltay*deltay + deltaz*deltaz  );

				if( distance>delta ){

					attractions[i].ax = attractions[i].ax + deltax/smorzo;
					attractions[i].ay = attractions[i].ay + deltay/smorzo;
					attractions[i].az = attractions[i].az + deltaz/smorzo;

				}
			}


			for(var i = 0; i<nrepulsions; i++){

				var idx1 = Math.floor((Math.random() * groupparticlesmax.children.length));
				var idx2 = Math.floor((Math.random() * groupparticlesmax.children.length));

				if(idx1!=idx2){

					var vfrom = groupparticlesmax.children[ idx1 ].position;
					var vto = groupparticlesmax.children[ idx2 ].position;

					var deltax = ( vto.x - vfrom.x );
					var deltay = ( vto.y - vfrom.y );
					var deltaz = ( vto.z - vfrom.z );

					var distance = Math.sqrt(  deltax*deltax + deltay*deltay + deltaz*deltaz  );

					if( distance<deltarepulsion ){
						vfrom.x = vfrom.x - deltax/repulsion;
						vfrom.y = vfrom.y - deltay/repulsion;
						vfrom.z = vfrom.z - deltaz/repulsion;

						vto.x = vto.x + deltax/repulsion;
						vto.y = vto.y + deltay/repulsion;
						vto.z = vto.z + deltaz/repulsion;

						groupparticlesmax.children[ idx1 ].position = vfrom;
						groupparticlesmax.children[ idx2 ].position = vto;


					}
				}

			}


			for(var i = 0 ; i<(attractions.length-1); i++   ){

				var vfrom, vto;
				
				if(attractions[i].f=="1"){
					vfrom = groupparticles1.children[ attractions[i].from ].position;
				} else if(attractions[i].f=="10"){
					vfrom = groupparticles10.children[ attractions[i].from ].position;
				} else if(attractions[i].f=="20"){
					vfrom = groupparticles20.children[ attractions[i].from ].position;
				} else if(attractions[i].f=="max"){
					vfrom = groupparticlesmax.children[ attractions[i].from ].position;
				}

				if(attractions[i].t=="1"){
					vto = groupparticles1.children[ attractions[i].to ].position;
				} else if(attractions[i].t=="10"){
					vto = groupparticles10.children[ attractions[i].to ].position;
				} else if(attractions[i].t=="20"){
					vto = groupparticles20.children[ attractions[i].to ].position;
				} else if(attractions[i].t=="max"){
					vto = groupparticlesmax.children[ attractions[i].to ].position;
				}


				attractions[i].ax = attractions[i].ax - attractions[i].ax*viscosity;
				attractions[i].ay = attractions[i].ay - attractions[i].ay*viscosity;
				attractions[i].az = attractions[i].az - attractions[i].az*viscosity;


				attractions[i].vx = attractions[i].vx + attractions[i].ax;
				attractions[i].vy = attractions[i].vy + attractions[i].ay;
				attractions[i].vz = attractions[i].vz + attractions[i].az;

				attractions[i].vx = attractions[i].vx - attractions[i].vx*viscosity;
				attractions[i].vy = attractions[i].vy - attractions[i].vy*viscosity;
				attractions[i].vz = attractions[i].vz - attractions[i].vz*viscosity;

				attractions[i].ax = 0;
				attractions[i].ay = 0;
				attractions[i].az = 0;

				
				vfrom.x = vfrom.x + attractions[i].vx;
				vfrom.y = vfrom.y + attractions[i].vy;
				vfrom.z = vfrom.z + attractions[i].vz;

				vto.x = vto.x - attractions[i].vx;
				vto.y = vto.y - attractions[i].vy;
				vto.z = vto.z - attractions[i].vz;


					
					if(attractions[i].f=="1"){
						groupparticles1.children[ attractions[i].from ].position = vfrom;
					} else if(attractions[i].f=="10"){
						groupparticles10.children[ attractions[i].from ].position = vfrom;
					} else if(attractions[i].f=="20"){
						groupparticles20.children[ attractions[i].from ].position = vfrom;
					} else if(attractions[i].f=="max"){
						groupparticlesmax.children[ attractions[i].from ].position = vfrom;
					}

					if(attractions[i].t=="1"){
						groupparticles1.children[ attractions[i].to ].position = vto;
					} else if(attractions[i].t=="10"){
						groupparticles10.children[ attractions[i].to ].position = vto;
					} else if(attractions[i].t=="20"){
						groupparticles20.children[ attractions[i].to ].position = vto;
					} else if(attractions[i].t=="max"){
						groupparticlesmax.children[ attractions[i].to ].position = vto;
					}

					if(connections && connections.geometry){
						connections.geometry.vertices[i*2] = vfrom;
						connections.geometry.vertices[i*2+1] = vto;	
					}


			}

			
			
			if(connections && connections.geometry){
				connections.needsUpdate = true;
				connections.geometry.verticesNeedUpdate = true;
			}

			groupparticles1.needsUpdate = true;
			groupparticles10.needsUpdate = true;
			groupparticles20.needsUpdate = true;
			groupparticlesmax.needsUpdate = true;
		}
	}


	

	initEventHandling = (function() {
		var _vector = new THREE.Vector3,
			projector = new THREE.Projector(),
			handleMouseDown, handleMouseMove, handleMouseUp;
		
		handleMouseDown = function( evt ) {
			var ray, intersections;

			_vector.set(
				( evt.clientX / window.innerWidth ) * 2 - 1,
				-( evt.clientY / window.innerHeight ) * 2 + 1,
				1
			);

			projector.unprojectVector( _vector, camera );
			
			ray = new THREE.Raycaster( camera.position, _vector.sub( camera.position ).normalize() );
			intersections = ray.intersectObjects( groupparticlesmax.children );

			if ( intersections.length > 0 ) {
				selected_block = intersections[0].object;
				console.log(selected_block);
				if(selected_block.nick){
					showBlock(selected_block, selected_block.position.clone() );
				}
			} else {
				intersections = ray.intersectObjects( groupparticles20.children );

				if ( intersections.length > 0 ) {
					selected_block = intersections[0].object;
					console.log(selected_block);
					if(selected_block.nick){
						showBlock(selected_block, selected_block.position.clone() );
					}
				} else {
					intersections = ray.intersectObjects( groupparticles10.children );

					if ( intersections.length > 0 ) {
						selected_block = intersections[0].object;
						console.log(selected_block);
						if(selected_block.nick){
							showBlock(selected_block, selected_block.position.clone() );
						}
					} else {
						intersections = ray.intersectObjects( groupparticles10.children );

						if ( intersections.length > 0 ) {
							selected_block = intersections[0].object;
							console.log(selected_block);
							if(selected_block.nick){
								showBlock(selected_block, selected_block.position.clone() );
							}
						}
					}
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
 		var ss = "<h1>" + s.nick + "</h1><br />Source:" + s.source + "<br /><a href='" + s.profile_url + "' target='_blank'>OPEN</a>";
 		
 		/*var ww = $("div#emc1container").width();
 		var hh = $( "div#emc1container" ).height();
		var widthHalf = ww / 2, heightHalf = hh / 2;

		var vector = new THREE.Vector3();
		var projector = new THREE.Projector();
		projector.projectVector( vector.getPositionFromMatrix( s.matrixWorld ), camera );

		console.log(vector);


		vector.x = ( vector.x * widthHalf ) + widthHalf;
		vector.y = - ( vector.y * heightHalf ) + heightHalf;

 		*/
 		$("div#infobox").html(ss);
 		//$("div#infobox").offset({top: vector.y, left: vector.x});
 		$("div#infobox").show();
 	}



 	
    </script>
</body>
</html>