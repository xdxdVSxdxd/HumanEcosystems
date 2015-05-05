<html>
<head>
	<meta charset="UTF-8">

	<link href="../css/style.css" rel="stylesheet">

	<style>
		html,body{
			margin: 0px;
			padding: 0px;
			background: #FFFFFF;
			color: #000000;
			font: 10px Helvetica, Arial, sans-serif;
			width:1280px;
			height: 480px; 
			overflow: hidden;
		}

		
		#wrapper{
			margin: 0px;
			padding: 0px;
			background: #FFFFFF;
			color: #000000;
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
			background: #FFFFFF;
			color: #000000;
			font: 10px Helvetica, Arial, sans-serif;
			width:2048px;
			height: 768px;	
			z-index: 100;
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
    background: #FFFFFF;
    color: #000000;
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

		div#music{
			width: 0px;
			height: 0px;
			overflow: hidden;
			max-width: 0px;
			max-height: 0px;
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

			/*
			setupBoxes();

 			loadProfiles();

 			timerInsert1 = window.setTimeout("manageInsert1();", 500);
 			timerInsert2 = window.setTimeout("manageInsert2();", 800);
 			timerInsert3 = window.setTimeout("manageInsert3();", 1100);
 			timerInsert4 = window.setTimeout("manageInsert4();", 600);
 			timerInsert5 = window.setTimeout("manageInsert5();", 1300);

			*/

			$("div#mask").css("height",maskheight+"px");
			$("div#part2").css("height",canvasheight+"px");

 			initRelations();

 			$("div#popover").click(function(){
 				$("div#popover").animate(
					{
						top: "-400px"
					},500,function(){

						$("#popoverwrap").html("<div class='noResults'>?</div>");
						
					}
				);
 			});

 			initMapMap();


 			variateSounds();

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

				//console.log(data);

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
						//nodes.push(  {  id: idx1 , label: n1, image: i1  , shape: 'image'} );
						nodes.push(  {  id: idx1 , label: n1, shape: 'dot'} );
					}

					if(idx2==-1){
						idx2 = nodes.length;
						//nodes.push( {  id: idx2 , label: n2, image: i2  , shape: 'image' } );
						nodes.push( {  id: idx2 , label: n2, shape: 'dot' } );
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
    	var WIDTH = 2048;//3840;//window.innerWidth;
		var HEIGHT = canvasheight;//window.innerHeight;

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
		var gmatmax = new THREE.MeshBasicMaterial( { color: 0xCC0916 , opacity: 0.8} );

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
								new THREE.LineBasicMaterial({ color: 0xAAAAAA, linewidth: 1 , transparent: true, opacity: 0.5 }),
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
					( evt.clientX / 2048 ) * 2 - 1,
					-( (evt.clientY-maskheight) / canvasheight  ) * 2 + 1,
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






	 	/*  

		///////
	 	DA QUI MAPPA ////////
	 	*/


	<?php 

    	$www = "";
    	if(isset($_REQUEST["w"])){
    		$www = $_REQUEST["w"];
    	} else {

    		$www = "saopaulo";

    	}
    ?>




	function loadTexturemap(e){
    	var t=new Image;
    	var n=new THREE.Texture(t);
    	t.onload=function(){
    		n.needsUpdate=true;
    		//console.log("texture "+e+" loaded")
    	};
    	t.src=e;
    	return n;
    }

    function resetCameramap(){
    	cameramap.rotation.x=0;
    	cameramap.rotation.y=0;
    	cameramap.rotation.z=0;
    	cameramap.position.x=0;
    	cameramap.position.y=0;
    	cameramap.position.z=1e3;
    }

    function toggleIntensitymap(){
    	italiamap.visible=!italiamap.visible;
    	italia2map.visible=!italia2map.visible;
    	spotLightmap.visible=!spotLightmap.visible;
    	var e=0;
    	if(italia2map.visible){
    		e=1e3;
    	}
    	for(var t=0;t<classesMeshmap.children.length;t++){
    		for(var n=0;n<classesMeshmap.children[t].children.length;n++){
    			classesMeshmap.children[t].children[n].visible=!classesMeshmap.children[t].children[n].visible;
    		}
    	}
    }

    function augmentmap(e,t,n,r,i){
    	var s=e-MLatmap;
    	var o=t-mLonmap;
    	var u=Math.round(heightSegmentsmap-heightSegmentsmap*s/dlatmap);
    	var a=Math.round(widthSegmentsmap*o/dlonmap);
    	if(u>=0&&u<heightSegmentsmap&&a>=0&&a<widthSegmentsmap){
    		italia2map.geometry.vertices[a+u*(widthSegmentsmap+1)].z=italia2map.geometry.vertices[a+u*(widthSegmentsmap+1)].z+n;
    		italia2map.geometry.vertices[a+1+u*(widthSegmentsmap+1)].z=italia2map.geometry.vertices[a+1+u*(widthSegmentsmap+1)].z+n;
    		italia2map.geometry.vertices[a+1+(u+1)*(widthSegmentsmap+1)].z=italia2map.geometry.vertices[a+1+(u+1)*(widthSegmentsmap+1)].z+n;
    		italia2map.geometry.vertices[a+(u+1)*(widthSegmentsmap+1)].z=italia2map.geometry.vertices[a+(u+1)*(widthSegmentsmap+1)].z+n;
    		var f=0;
    		for(var l=0;l<classesmap.length;l++){
    			if(r==classesmap[l].name){
    				var c=new THREE.Vector3(italiamap.geometry.vertices[a+u*(widthSegmentsmap+1)].x,italiamap.geometry.vertices[a+u*(widthSegmentsmap+1)].y,f);
    				//var h=new THREE.Mesh(new THREE.CubeGeometry(i*2,i*2,i*2,1,1,1),classesPS[l].material);
                    var h=new THREE.Mesh(new THREE.CubeGeometry(6,6,i*5,1,1,1),classesPSmap[l].material);
    				h.position={
    					x:italiamap.geometry.vertices[a+u*(widthSegmentsmap+1)].x,
    					y:italiamap.geometry.vertices[a+u*(widthSegmentsmap+1)].y,
    					z:f
    				};
    				classesPSmap[l].add(h);
    			}
    		}
    	}
    }

    function rendermap(){
    	requestAnimationFrame(rendermap);
    	controlsmap.update();
    	TWEEN.update();
    	renderermap.render(scenemap,cameramap);
    }

    var classesmap,classesPSmap;
    var renderermap,scenemap,cameramap,controlsmap;
    var centerLatmap=<?php echo($cityclat); ?>;
    var centerLonmap=<?php echo($cityclon); ?>;
    var mLatmap=<?php echo($cityminlat); ?>,mLonmap=<?php echo($cityminlon); ?>,MLatmap=<?php echo($citymaxlat); ?>,MLonmap=<?php echo($citymaxlon); ?>;
    var dlatmap=mLatmap-MLatmap;
    var dlonmap=MLonmap-mLonmap;
    var minZForParticlesmap=200;
    var WIDTHmap=1024,HEIGHTmap=568;
    var mapWidthmap=2e3;
    var mapHeightmap=2e3;
    var VIEW_ANGLEmap=45,ASPECTmap=WIDTHmap/HEIGHTmap,NEARmap=.1,FARmap=1e4;
    var $containermap;
    var italiaMaterialmap,italiaMaterial2map;
    var widthSegmentsmap=300,heightSegmentsmap=300;
    var italiamap,italia2map;
    var cameraP1Xmap=0;
    var cameraP1Ymap=200;
    var cameraP2Xmap=0;
    var cameraP2Ymap=-500;
    var timeTweenmap=15e3;
    var mapTween1map,mapTween2map;
    var linesMeshmap,lineMaterialmap;
    var skyboxMeshmap,classesMeshmap,spotLightmap,directionalLightmap;

    function toggleVisibilitymap(na,legitem){
    	for(var n=0;n<classesmap.length;n++){
    		//console.log(classesPSmap[n]);
			if(classesPSmap[n].idname==na){
				classesPSmap[n].material.visible = !classesPSmap[n].material.visible;
				classesPSmap[n].material.needsUpdate = true;
				$("#"+legitem).toggleClass("legend-highlighted");
			}
		}
    }

    function initMapMap(){
    	$containermap=$("#emc1container");
    	renderermap=new THREE.WebGLRenderer;
    	renderermap.shadowMapEnabled=true;
    	renderermap.shadowMapSoft=true;
    	cameramap=new THREE.PerspectiveCamera(VIEW_ANGLEmap,ASPECTmap,NEARmap,FARmap);
    	cameramap.rotation.x=0;
    	cameramap.position.y=0;
    	controlsmap=new THREE.OrbitControls(cameramap,renderermap.domElement);
    	scenemap=new THREE.Scene;scenemap.add(cameramap);
    	cameramap.position.z=1e3;
    	renderermap.setSize(WIDTHmap,HEIGHTmap);
    	$containermap.append(renderermap.domElement);
    	lineMaterialmap=new THREE.LineBasicMaterial({
    		color:4473924,
    		linewidth:1,
    		linecap:"square",
    		opacity:.3
    	});
    	linesMeshmap=new THREE.Object3D;scenemap.add(linesMeshmap);
    	classesMeshmap=new THREE.Object3D;
    	scenemap.add(classesMeshmap);
    	classesMeshmap.visible=true;
    	classesPSmap=new Array;
    	$.getJSON("../ecosystem/viz/getClasses.php?w=<?php echo($www); ?>",{},function(e){
    		classesmap=e;
    		for(var t=0;t<e.length;t++){
    			var n="<div class='legendBox'>";
    			n=n+"<a href='javascript:toggleVisibility(\"" + e[t].name + "\",  \"legenditem-" + e[t].name + "\"  );'>";
    			n=n+"<div class='legendcolor' style='background:#"+e[t].color.substring(2)+"'></div>";
    			n=n+"<div class='legendname' id='legenditem-" + e[t].name + "'>"+e[t].name+"</div>";
    			n=n+"</a>";
    			n=n+"</div>";
    			$("#classescontainer").append(n);
    			var r=new THREE.ParticleBasicMaterial({
    				color:parseInt(e[t].color,16),size:20,transparent:true,opacity:.7
    			});
    			var i=new THREE.ParticleSystem(new THREE.Geometry,r);
    			i.idname = e[t].name;
    			classesPSmap.push(i);
    			classesMeshmap.add(i);
    		}
    		italiamap.geometry.verticesNeedUpdate=true;
    		var n="<div class='legendBox'>";
    		n=n+"<div class='legendcolor'></div>";
    		n=n+"<div class='legendname' ><a href='javascript:resetCameramap();'>Reset Camera</a></div>";
    		n=n+"</div>";
    		$("#classescontainer").append(n);
    		n="<div class='legendBox'>";
    		n=n+"<div class='legendcolor'></div>";
    		n=n+"<div class='legendname' ><a href='javascript:toggleIntensitymap();'>Intensity ON/OFF</a></div>";
    		n=n+"</div>";$("#classescontainer").append(n)
    	});
		italiaMaterialmap=new THREE.MeshLambertMaterial({color:16777215,opacity:1,map:THREE.ImageUtils.loadTexture("../ecosystem/viz/img/<?php echo($www); ?>.png",{},function(){italiamap.material.map.needsUpdate=true})});
		italiaMaterial2map=new THREE.MeshBasicMaterial({color:32768,wireframe:true,transparent:true,opacity:.3});
		italiamap=new THREE.Mesh(new THREE.PlaneGeometry(mapWidthmap,mapHeightmap,widthSegmentsmap,heightSegmentsmap),italiaMaterialmap);
		italiamap.castShadow=true;
		italiamap.receiveShadow=true;
		italiamap.dynamic=true;
		italia2map=new THREE.Mesh(new THREE.PlaneGeometry(mapWidthmap,mapHeightmap,widthSegmentsmap,heightSegmentsmap),italiaMaterialmap);
		italia2map.position.z=0;
		italia2map.castShadow=true;
		italia2map.receiveShadow=true;
		italia2map.visible=false;
		italia2map.dynamic=true;
		scenemap.add(italiamap);
		scenemap.add(italia2map);
		directionalLightmap=new THREE.PointLight(16777215,2,3e3);
		directionalLightmap.position.set(0,0,2e3);
		scenemap.add(directionalLightmap);
		spotLightmap=new THREE.SpotLight(16711680,2,2e3,Math.PI/2);
		spotLightmap.position.set(0,0,1e3);
		spotLightmap.castShadow=true;
		spotLightmap.shadowCameraVisible=false;
		spotLightmap.shadowMapWidth=1024;
		spotLightmap.shadowMapHeight=1024;
		spotLightmap.shadowCameraNear=1e3;
		spotLightmap.shadowCameraFar=2e3;
		spotLightmap.shadowCameraFov=30;
		spotLightmap.visible=false;
		scenemap.add(spotLightmap);
		requestAnimationFrame(rendermap);

		updateMapTexture();
		

		cameramap.position.x=cameraP1Xmap;
		cameramap.position.y=cameraP1Ymap;
	}
 

	var mapTextureTimer = null;

	function updateMapTexture(){

		if(mapTextureTimer!=null){
			window.clearTimeout(mapTextureTimer);
		}

		$.getJSON("../ecosystem/viz/getContentForMap.php?w=<?php echo($www); ?>",{})
		.done(function(e){


			for(var i = 0; i<italia2map.geometry.vertices.length;i++){
				italia2map.geometry.vertices[i].z = 0;
			}

			for(var i = 0; i<classesPSmap.length;i++){
				for(var j = classesPSmap[i].children.length-1; j>=0;j--){
					classesPSmap[i].remove(  classesPSmap[i].children[j] );
				}				
			}

			for(var t=0;t<e.length;t++){
				augmentmap(parseFloat(e[t].lat),parseFloat(e[t].lng),parseFloat(e[t].c)*10,e[t].name,e[t].c);
			}
			italia2map.geometry.verticesNeedUpdate=true;
			for(var n=0;n<classesmap.length;n++){
				classesPSmap[n].geometry.__dirtyVertices=true;
			}
			mapTextureTimer = setTimeout("updateMapTexture()",2000);
		})
		.fail(
			function( jqxhr, textStatus, error ) {
				mapTextureTimer = setTimeout("updateMapTexture()",2000);
			}
		);

	}



	 	/*  

		///////
	 	FIN QUI MAPPA ////////
	 	*/




	</script>

	<!-- relations -->
    
</head>
<body>
	<!--div id="wrapper"-->
		<div id="part2">
		</div>

		<div id="mapholder">
			<div id="blackbar">
			</div>
			<div id="emc1container">
			</div>
		</div>

	<!--/div-->


	<div id="classescontainer"></div>

	<div id="popover">
		<div id="popoverwrap">
		</div>
		<img id="popoverimg" src="blank.png" border="0" />
		<div id="popovername"></div>
	</div>

	<div id="music">
		<audio id= "audioback" controls="controls" autoplay loop onloadeddata="playBack()">
    		<source src="sounds/back.ogg"  type="audio/ogg">
		</audio>
		<audio id= "audios1" controls="controls" autoplay loop onloadeddata="playS1()">
    		<source src="sounds/s1.ogg"  type="audio/ogg">
		</audio>
		<audio id= "audios2" controls="controls" autoplay loop onloadeddata="playS2()">
    		<source src="sounds/s2.ogg"  type="audio/ogg">
		</audio>
		<audio id= "audios3" controls="controls" autoplay loop onloadeddata="playS3()">
    		<source src="sounds/s3.ogg"  type="audio/ogg">
		</audio>
		<audio id= "audios4" controls="controls" autoplay loop onloadeddata="playS4()">
    		<source src="sounds/s4.ogg"  type="audio/ogg">
		</audio>
		<audio id= "audios5" controls="controls" autoplay loop onloadeddata="playS5()">
    		<source src="sounds/s5.ogg"  type="audio/ogg">
		</audio>
	</div>

	<script>
	function playBack(){
		var a = document.getElementById("audioback");
		a.volume = 0.8;
	}
	function playS1(){
		var a = document.getElementById("audios1");
		a.volume = 0.0;
	}
	function playS2(){
		var a = document.getElementById("audios2");
		a.volume = 0.0;
	}
	function playS3(){
		var a = document.getElementById("audios3");
		a.volume = 0.0;
	}
	function playS4(){
		var a = document.getElementById("audios4");
		a.volume = 0.0;
	}
	function playS5(){
		var a = document.getElementById("audios5");
		a.volume = 0.0;
	}


	var timerSounds = null;

	function variateSounds(){
		if(timerSounds!=null){
			window.clearTimeout(timerSounds);
		}
		
		var a = document.getElementById("audios1");
		var vol = a.volume;
		vol = vol + 0.05*(Math.random() - 0.5);
		if(vol<0){ vol =0; }
		if(vol>1){ vol = 1;}
		//console.log("sv1=" + vol);
		a.volume = vol;


		a = document.getElementById("audios2");
		vol = a.volume;
		vol = vol + 0.05*(Math.random() - 0.5);
		if(vol<0){ vol =0; }
		if(vol>1){ vol = 1;}
		//console.log("sv2=" + vol);
		a.volume = vol;

		a = document.getElementById("audios3");
		vol = a.volume;
		vol = vol + 0.05*(Math.random() - 0.5);
		if(vol<0){ vol =0; }
		if(vol>1){ vol = 1;}
		//console.log("sv3=" + vol);
		a.volume = vol;

		a = document.getElementById("audios4");
		vol = a.volume;
		vol = vol + 0.05*(Math.random() - 0.5);
		if(vol<0){ vol =0; }
		if(vol>1){ vol = 1;}
		//console.log("sv4=" + vol);
		a.volume = vol;

		a = document.getElementById("audios5");
		vol = a.volume;
		vol = vol + 0.05*(Math.random() - 0.5);
		if(vol<0){ vol =0; }
		if(vol>1){ vol = 1;}
		//console.log("sv5=" + vol);
		a.volume = vol;


		timerSounds = window.setTimeout("variateSounds();", 500);

	}

	</script>

</body>
</html>