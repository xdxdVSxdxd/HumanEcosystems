<html>
<head>
	<meta charset="UTF-8">
	<style>
		html,body{
			margin: 0px;
			padding: 0px;
			background: #000000;
			color: #FFFFFF;
			font: 10px Helvetica, Arial, sans-serif;
			width:100%;
			height: 2880px; 
		}
		#wrapper{
			margin: 0px;
			padding: 0px;
			background: #000000;
			color: #FFFFFF;
			font: 10px Helvetica, Arial, sans-serif;
			width:1280px;
			height: 2880px;
			float: left;	
		}
		#part1{
			margin: 0px;
			padding: 0px;
			background: #000000;
			color: #FFFFFF;
			font: 10px Helvetica, Arial, sans-serif;
			width:1280px;
			height: 2160px;
			overflow: hidden;
			float: left;
			z-index: 100;
		}
		#part2{
			margin: 0px;
			padding: 0px;
			background: #000000;
			color: #FFFFFF;
			font: 10px Helvetica, Arial, sans-serif;
			width:1280px;
			height: 720px;	
			float: left;
			z-index: 100;
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




		div#insert1{
			position: absolute;
			width: 300px;
			height: 80px;
			min-width: 300px;
			min-height: 80px;
			max-width: 300px;
			max-height: 80px;
			top: 300px;
			left: -300px;
			overflow: hidden;
			background: #FF00FF;
			z-index: 300;
		}

		img#insert1img{
			display: block;
			margin: 0px;
			padding: 0px;
			border: 0px;
			width: 60px;
			height: 60px;
			overflow: hidden;
			position: relative;
			top: 10px;
			left: 10px;
		}

		div#insert1txt{
			display: block;
			margin: 0px;
			padding: 0px;
			border: 0px;
			width: 200px;
			height: 60px;
			overflow: hidden;
			position: relative;
			top: -50px;
			left: 90px;
			color: #FFFFFF;
			font: bold 12px Helvetica,Arial,sans-serif;	
		}





		div#insert2{
			position: absolute;
			width: 300px;
			height: 80px;
			min-width: 300px;
			min-height: 80px;
			max-width: 300px;
			max-height: 80px;
			top: 900px;
			left: -300px;
			overflow: hidden;
			background: #FF00FF;
			z-index: 300;
		}

		img#insert2img{
			display: block;
			margin: 0px;
			padding: 0px;
			border: 0px;
			width: 60px;
			height: 60px;
			overflow: hidden;
			position: relative;
			top: 10px;
			left: 10px;
		}

		div#insert2txt{
			display: block;
			margin: 0px;
			padding: 0px;
			border: 0px;
			width: 200px;
			height: 60px;
			overflow: hidden;
			position: relative;
			top: -50px;
			left: 90px;
			color: #FFFFFF;
			font: bold 12px Helvetica,Arial,sans-serif;	
		}




		div#insert3{
			position: absolute;
			width: 300px;
			height: 80px;
			min-width: 300px;
			min-height: 80px;
			max-width: 300px;
			max-height: 80px;
			top: 1600px;
			left: -300px;
			overflow: hidden;
			background: #FF00FF;
			z-index: 300;
		}

		img#insert3img{
			display: block;
			margin: 0px;
			padding: 0px;
			border: 0px;
			width: 60px;
			height: 60px;
			overflow: hidden;
			position: relative;
			top: 10px;
			left: 10px;
		}

		div#insert3txt{
			display: block;
			margin: 0px;
			padding: 0px;
			border: 0px;
			width: 200px;
			height: 60px;
			overflow: hidden;
			position: relative;
			top: -50px;
			left: 90px;
			color: #FFFFFF;
			font: bold 12px Helvetica,Arial,sans-serif;	
		}



		div#insert4{
			position: absolute;
			width: 300px;
			height: 80px;
			min-width: 300px;
			min-height: 80px;
			max-width: 300px;
			max-height: 80px;
			top: 500px;
			right: -300px;
			overflow: hidden;
			background: #FF00FF;
			z-index: 300;
		}

		img#insert4img{
			display: block;
			margin: 0px;
			padding: 0px;
			border: 0px;
			width: 60px;
			height: 60px;
			overflow: hidden;
			position: relative;
			top: -50px;
			left: 210px;
		}

		div#insert4txt{
			display: block;
			margin: 0px;
			padding: 0px;
			border: 0px;
			width: 200px;
			height: 60px;
			overflow: hidden;
			position: relative;
			top: 10px;
			left: 10px;
			color: #FFFFFF;
			font: bold 12px Helvetica,Arial,sans-serif;	
		}




		div#insert5{
			position: absolute;
			width: 300px;
			height: 80px;
			min-width: 300px;
			min-height: 80px;
			max-width: 300px;
			max-height: 80px;
			top: 1300px;
			right: -300px;
			overflow: hidden;
			background: #FF00FF;
			z-index: 300;
		}

		img#insert5img{
			display: block;
			margin: 0px;
			padding: 0px;
			border: 0px;
			width: 60px;
			height: 60px;
			overflow: hidden;
			position: relative;
			top: -50px;
			left: 210px;
		}

		div#insert5txt{
			display: block;
			margin: 0px;
			padding: 0px;
			border: 0px;
			width: 200px;
			height: 60px;
			overflow: hidden;
			position: relative;
			top: 10px;
			left: 10px;
			color: #FFFFFF;
			font: bold 12px Helvetica,Arial,sans-serif;	
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
			left: 340px;
			background: #800080;
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

	</style>
	<script type="text/javascript" src="../js/jquery.min.js"></script>
	<?php

		require_once('../ecosystem/db.php');

	?>

	<script src="../ecosystem/viz/js/three.min.js"></script>
	<script src="../ecosystem/viz/js/controls/OrbitControls.js"></script>
	<script src="../ecosystem/viz/js/tween.min.js"></script>

	<script type="text/javascript" src="js/vis.js"></script>
	<link href="js/vis.css" rel="stylesheet" type="text/css" />

	<script type="text/javascript">

		var counterBoxes = 0;
		var counterProfiles = 0;
		var totBoxes = 9216;


		//for graphviz in popover
		var nodes = null;
	    var edges = null;
	    var network = null;
	    //for graphviz in popover
		

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

			setupBoxes();

 			loadProfiles();

 			timerInsert1 = window.setTimeout("manageInsert1();", 500);
 			timerInsert2 = window.setTimeout("manageInsert2();", 800);
 			timerInsert3 = window.setTimeout("manageInsert3();", 1100);
 			timerInsert4 = window.setTimeout("manageInsert4();", 600);
 			timerInsert5 = window.setTimeout("manageInsert5();", 1300);

 			initRelations();

 			$("div#popover").click(function(){
 				$("div#popover").animate(
					{
						top: "-400px"
					},500,function(){
						
					}
				);
 			});

 			$(".imProfIm").click(function(){
 				var elem = $(this);
 				//console.log(elem.attr("nick"));
 				slideInPopover(elem.attr("nick"));
 			});
    
		});


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

			$.getJSON("http://human-ecosystems.com/HE/ecosystem/getUserProfile.php",{n: currentNick},function(data){

				console.log(data);

				// preparare

				$("img#popoverimg").attr("src",data["user"].image_url);

				$("div#popovername").text(data["user"].nick);

				$("div#popoverwrap").text("");

				nodes = new Array();
				edges = new Array();

				var color = '#BFBFBF';

				for(var i = 0 ; i<data["relations"].length; i++){

					var n1 = data["relations"][i].n1;
					var n2 = data["relations"][i].n2;
					var c = data["relations"][i].c;
					var i1 = data["relations"][i].i1;
					var i2 = data["relations"][i].i2;

					//console.log(n1 + "-->" + n2);

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
						nodes.push(  {  id: idx1 , label: n1, image: i1  , shape: 'image'} );
					}

					if(idx2==-1){
						idx2 = nodes.length;
						nodes.push( {  id: idx2 , label: n2, image: i2  , shape: 'image' } );
					}

					edges.push(  {from: idx1, to: idx2, value: c, label: c, color: color}  );


				}

				//console.log(edges);
				//console.log(nodes);

				if(nodes.length==0 || edges.length==0){

					$("#popoverwrap").html("<div class='noResults'>?</div>");

				}
				else {

					
					var container = document.getElementById('popoverwrap');
					var data = {
						nodes: nodes,
						edges: edges
					};
					var options = {};
					network = new vis.Network(container, data, options);

					network.on('select', function(properties) {
						console.log(properties);
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
						top: "1500px"
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

			$.getJSON("http://human-ecosystems.com/HE/ecosystem/getUsers.php?w=saopaulo",{  fromID: highestProfileID  },function(data){
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

		

		function manageInsert1(){
			if(timerInsert1!=null){
				window.clearTimeout(timerInsert1);
			}
			$.getJSON( "http://human-ecosystems.com/HE/ecosystem/getRandomMessage.php?w=saopaulo",function(data){
				$("img#insert1img").attr("src",data[0].iurl);
				$("div#insert1txt").text(data[0].txt);
				$("div#insert1").animate(
					{
						left: "+=300"
					},500,function(){
						setTimeout("hideInsert1();",2000);
					}
				);
			} );
		}

		function hideInsert1(){
			$("div#insert1").animate(
				{
					left: "-=300"
				},500,function(){
					timerInsert1 = window.setTimeout("manageInsert1();", 500);
				}
			);
		}





		function manageInsert2(){
			if(timerInsert2!=null){
				window.clearTimeout(timerInsert2);
			}
			$.getJSON( "http://human-ecosystems.com/HE/ecosystem/getRandomMessage.php?w=saopaulo",function(data){
				$("img#insert2img").attr("src",data[0].iurl);
				$("div#insert2txt").text(data[0].txt);
				$("div#insert2").animate(
					{
						left: "+=300"
					},500,function(){
						setTimeout("hideInsert2();",2000);
					}
				);
			} );
		}

		function hideInsert2(){
			$("div#insert2").animate(
				{
					left: "-=300"
				},500,function(){
					timerInsert2 = window.setTimeout("manageInsert2();", 500);
				}
			);
		}




		function manageInsert3(){
			if(timerInsert3!=null){
				window.clearTimeout(timerInsert3);
			}
			$.getJSON( "http://human-ecosystems.com/HE/ecosystem/getRandomMessage.php?w=saopaulo",function(data){
				$("img#insert3img").attr("src",data[0].iurl);
				$("div#insert3txt").text(data[0].txt);
				$("div#insert3").animate(
					{
						left: "+=300"
					},500,function(){
						setTimeout("hideInsert3();",2000);
					}
				);
			} );
		}

		function hideInsert3(){
			$("div#insert3").animate(
				{
					left: "-=300"
				},500,function(){
					timerInsert3 = window.setTimeout("manageInsert3();", 500);
				}
			);
		}





		function manageInsert4(){
			if(timerInsert4!=null){
				window.clearTimeout(timerInsert4);
			}
			$.getJSON( "http://human-ecosystems.com/HE/ecosystem/getRandomMessage.php?w=saopaulo",function(data){
				$("img#insert4img").attr("src",data[0].iurl);
				$("div#insert4txt").text(data[0].txt);
				$("div#insert4").animate(
					{
						right: "+=300"
					},500,function(){
						setTimeout("hideInsert4();",2000);
					}
				);
			} );
		}

		function hideInsert4(){
			$("div#insert4").animate(
				{
					right: "-=300"
				},500,function(){
					timerInsert4 = window.setTimeout("manageInsert4();", 500);
				}
			);
		}




		function manageInsert5(){
			if(timerInsert5!=null){
				window.clearTimeout(timerInsert5);
			}
			$.getJSON( "http://human-ecosystems.com/HE/ecosystem/getRandomMessage.php?w=saopaulo",function(data){
				$("img#insert5img").attr("src",data[0].iurl);
				$("div#insert5txt").text(data[0].txt);
				$("div#insert5").animate(
					{
						right: "+=300"
					},500,function(){
						setTimeout("hideInsert5();",2000);
					}
				);
			} );
		}

		function hideInsert5(){
			$("div#insert5").animate(
				{
					right: "-=300"
				},500,function(){
					timerInsert5 = window.setTimeout("manageInsert5();", 500);
				}
			);
		}



	

		var classes,classesPS;
		var renderer,scene,camera,controls;
		var mindelta = 30;
		var particles1, particles10, particles20, particlesmax;
    	var groupparticles1, groupparticles10, groupparticles20, groupparticlesmax;
		var connections;
    	var WIDTH = 1280;//window.innerWidth;
		var HEIGHT = 720;//window.innerHeight;

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

		var gmat1 = new THREE.MeshBasicMaterial( { color: 0x555555} );
		var gmat10 = new THREE.MeshBasicMaterial( { color: 0xAAAAAA } );
		var gmat20 = new THREE.MeshBasicMaterial( { color: 0x00aa00 } );
		var gmatmax = new THREE.MeshBasicMaterial( { color: 0xFF8000 , opacity: 0.8} );

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

			$.getJSON("../ecosystem/getLatestRelations.php?w=saopaulo",{},function(data){

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
								new THREE.LineBasicMaterial({ color: 0xffff00, linewidth: 1 , transparent: true, opacity: 0.5 }),
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

					if(groupparticles1) { groupparticles1.rotation.y = time * 0.5; }
					if(groupparticles10) { groupparticles10.rotation.y = time * 0.5; }
					if(groupparticles20) { groupparticles20.rotation.y = time * 0.5; }
					if(groupparticlesmax) { groupparticlesmax.rotation.y = time * 0.5; }
					if(connections) { connections.rotation.y = time * 0.5; }


			doAnims();
					
		  
		  
		  renderer.render(scene, camera);
		};




		function doAnims(){

			//console.log("--- anim ---");

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
					//console.log(selected_block);
					if(selected_block.nick){
						showBlock(selected_block, selected_block.position.clone() );
					}
				} else {
					intersections = ray.intersectObjects( groupparticles20.children );

					if ( intersections.length > 0 ) {
						selected_block = intersections[0].object;
						//console.log(selected_block);
						if(selected_block.nick){
							showBlock(selected_block, selected_block.position.clone() );
						}
					} else {
						intersections = ray.intersectObjects( groupparticles10.children );

						if ( intersections.length > 0 ) {
							selected_block = intersections[0].object;
							//console.log(selected_block);
							if(selected_block.nick){
								showBlock(selected_block, selected_block.position.clone() );
							}
						} else {
							intersections = ray.intersectObjects( groupparticles10.children );

							if ( intersections.length > 0 ) {
								selected_block = intersections[0].object;
								//console.log(selected_block);
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
	 		console.log(s);
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

	<div id="mask"></div>

	<div id="wrapper">
		<div id="part1">
		</div>
		<div id="part2">
		</div>
	</div>
	

	<div id="insert1">
		<img src="blank.png" id="insert1img" />
		<div id="insert1txt"></div>
	</div>


	<div id="insert2">
		<img src="blank.png" id="insert2img" />
		<div id="insert2txt"></div>
	</div>


	<div id="insert3">
		<img src="blank.png" id="insert3img" />
		<div id="insert3txt"></div>
	</div>


	<div id="insert4">
		<div id="insert4txt"></div>
		<img src="blank.png" id="insert4img" />
	</div>


	<div id="insert5">
		<div id="insert5txt"></div>
		<img src="blank.png" id="insert5img" />
	</div>


	<div id="popover">
		<div id="popoverwrap">
		</div>
		<img id="popoverimg" src="blank.png" border="0" />
		<div id="popovername"></div>
	</div>

</body>
</html>