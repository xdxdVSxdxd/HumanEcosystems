
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>three.js webgl - shaders - sky sun shader</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
		<style>

			body {
				color: #000;
				font-family:Monospace;
				font-size:13px;
				text-align:center;
				font-weight: bold;

				background-color: #fff;
				margin: 0px;
				overflow: hidden;
				text
			}

			
		</style>
	</head>
	<body>

		
		<script src="js/three.min.js"></script>

		<script src="js/controls/TrackballControls.js"></script>
		<script src="js/SkyShader.js"></script>

		<script src="js/Detector.js"></script>
		<script src="js/libs/stats.min.js"></script>
		<script src="js/libs/dat.gui.min.js"></script>
		<script src="jquery-2.1.3.min.js"></script>


		<script>


			if ( ! Detector.webgl ) Detector.addGetWebGLMessage();


			var project;

			var container, stats;

			var camera, controls, scene, renderer;

			var sky, sunSphere;

			var azimuthanim = 0;

			var emotionMeshes = new Array();


			var effectController  = {
					turbidity: 10,
					reileigh: 2,
					mieCoefficient: 0.005,
					mieDirectionalG: 0.8,
					luminance: 1,
					inclination: 0.49, // elevation / inclination
					azimuth: 0.25, // Facing front,
					sun: !true
				}


			var distance = 400000;


			init();
			animate();

			function initSky(){

				// Add Sky Mesh
				sky = new THREE.Sky();
				scene.add( sky.mesh );


				// Add Sun Helper
				sunSphere = new THREE.Mesh( new THREE.SphereGeometry( 20000, 30, 30 ),
					new THREE.MeshBasicMaterial({color: 0xffffff, wireframe: false }));
				sunSphere.position.y = -700000;
				sunSphere.visible = true;
				scene.add( sunSphere );

				/// GUI

				

				

				function guiChanged() {
					var uniforms = sky.uniforms;
					uniforms.turbidity.value = effectController.turbidity;
					uniforms.reileigh.value = effectController.reileigh;
					uniforms.luminance.value = effectController.luminance;
					uniforms.mieCoefficient.value = effectController.mieCoefficient;
					uniforms.mieDirectionalG.value = effectController.mieDirectionalG;

					var theta = Math.PI * (effectController.inclination - 0.5);
					var phi = 2 * Math.PI * (effectController.azimuth - 0.5);

					sunSphere.position.x = distance * Math.cos(phi);
					sunSphere.position.y = distance * Math.sin(phi) * Math.sin(theta);
					sunSphere.position.z = distance * Math.sin(phi) * Math.cos(theta);

					sunSphere.visible = effectController.sun;

					sky.uniforms.sunPosition.value.copy(sunSphere.position);

				}

				

				/*
				var gui = new dat.GUI();


				gui.add( effectController, "turbidity", 1.0, 20.0, 0.1 ).onChange( guiChanged );
				gui.add( effectController, "reileigh", 0.0, 4, 0.001 ).onChange( guiChanged );
				gui.add( effectController, "mieCoefficient", 0.0, 0.1, 0.001 ).onChange( guiChanged );
				gui.add( effectController, "mieDirectionalG", 0.0, 1, 0.001 ).onChange( guiChanged );
				gui.add( effectController, "luminance", 0.0, 2).onChange( guiChanged );;
				gui.add( effectController, "inclination", 0, 1, 0.0001).onChange( guiChanged );
				gui.add( effectController, "azimuth", 0, 1, 0.0001).onChange( guiChanged );
				gui.add( effectController, "sun").onChange( guiChanged );


				guiChanged();
				
				*/

				camera.lookAt(sunSphere.position)


			}



				function animAzimuth(){

					azimuthanim = azimuthanim + 0.001;
					if(azimuthanim>1){ azimuthanim = 0; }
					effectController.azimuth = azimuthanim;


					var theta = Math.PI * (effectController.inclination - 0.5);
					var phi = 2 * Math.PI * (azimuthanim - 0.5);

					//console.log(theta + "::" + phi);

					sunSphere.position.x = distance * Math.cos(phi);
					sunSphere.position.y = distance * Math.sin(phi) * Math.sin(theta);
					sunSphere.position.z = distance * Math.sin(phi) * Math.cos(theta);

					sunSphere.visible = effectController.sun;

					sky.uniforms.sunPosition.value.copy(sunSphere.position);


				}



			var timerUpdateEmotions;

			var updateEmotions = function(){

				if(timerUpdateEmotions!=null){
					clearTimeout(timerUpdateEmotions);
				}

				$.getJSON("../../API/getLatestEmotions.php?w=" + project)
				.success(function(data) { 
					console.log(data);

					var maxvalue = 0;
					for(var i = 0; i<data.length; i++){
						if(eval(data[i].c)>maxvalue ){ maxvalue = eval(data[i].c); }
					}

					for(var i = 0; i<data.length; i++){
						var vv = eval(data[i].c) / maxvalue;
						if(emotionMeshes[data[i].l]!=null){
							emotionMeshes[data[i].l].scale.y = 3*vv;
						}
					}					


					timerUpdateEmotions = setTimeout(updateEmotions,4000);
				 })
				.error(function() {
					console.log("error updateemotions");
					timerUpdateEmotions = setTimeout(updateEmotions,4000);
				 });




			};


			function init() {

				project = getUrlParameter("w");

				camera = new THREE.PerspectiveCamera( 60, window.innerWidth / window.innerHeight, 0.5, 2000000 );
				camera.position.z = 2000;

				camera.position.y = 100;
				camera.setLens(20);

				scene = new THREE.Scene();

				/*
				var helper = new THREE.GridHelper( 5000, 5000 );
				helper.color1.setHex( 0xffffff );
				helper.color2.setHex( 0xffffff );
				scene.add( helper );
				*/


				initSky();

				var nemotions = 13;
				var delta = 5000/nemotions;

				var geometryLove = new THREE.BoxGeometry( 100, 100, 100 );
				var materialLove = new THREE.MeshBasicMaterial( { color: 0xff8080 } );
				var meshLove = new THREE.Mesh( geometryLove, materialLove );
				scene.add( meshLove );
				meshLove.position.x = -2500 + delta*0;
				emotionMeshes["Love"] = meshLove;


				var geometryAnger = new THREE.BoxGeometry( 100, 100, 100 );
				var materialAnger = new THREE.MeshBasicMaterial( { color: 0x800000 } );
				var meshAnger = new THREE.Mesh( geometryAnger, materialAnger );
				scene.add( meshAnger );
				meshAnger.position.x = -2500 + delta*1;
				emotionMeshes["Anger"] = meshAnger;


				var geometryDisgust = new THREE.BoxGeometry( 100, 100, 100 );
				var materialDisgust = new THREE.MeshBasicMaterial( { color: 0x800080 } );
				var meshDisgust = new THREE.Mesh( geometryDisgust, materialDisgust );
				scene.add( meshDisgust );
				meshDisgust.position.x = -2500 + delta*2;
				emotionMeshes["Disgust"] = meshDisgust;

				var geometryBoredom = new THREE.BoxGeometry( 100, 100, 100 );
				var materialBoredom = new THREE.MeshBasicMaterial( { color: 0xDD00DD } );
				var meshBoredom = new THREE.Mesh( geometryBoredom, materialBoredom );
				scene.add( meshBoredom );
				meshBoredom.position.x = -2500 + delta*3;
				emotionMeshes["Boredom"] = meshBoredom;


				var geometryFear = new THREE.BoxGeometry( 100, 100, 100 );
				var materialFear = new THREE.MeshBasicMaterial( { color: 0x00FF00 } );
				var meshFear = new THREE.Mesh( geometryFear, materialFear );
				scene.add( meshFear );
				meshFear.position.x = -2500 + delta*4;
				emotionMeshes["Fear"] = meshFear;


				var geometryHate = new THREE.BoxGeometry( 100, 100, 100 );
				var materialHate = new THREE.MeshBasicMaterial( { color: 0xFF0000 } );
				var meshHate = new THREE.Mesh( geometryHate, materialHate );
				scene.add( meshHate );
				meshHate.position.x = -2500 + delta*5;
				emotionMeshes["Hate"] = meshHate;


				var geometryJoy = new THREE.BoxGeometry( 100, 100, 100 );
				var materialJoy = new THREE.MeshBasicMaterial( { color: 0xFFFF00 } );
				var meshJoy = new THREE.Mesh( geometryJoy, materialJoy );
				scene.add( meshJoy );
				meshJoy.position.x = -2500 + delta*6;
				emotionMeshes["Joy"] = meshJoy;

				var geometrySurprise = new THREE.BoxGeometry( 100, 100, 100 );
				var materialSurprise = new THREE.MeshBasicMaterial( { color: 0x0060FF } );
				var meshSurprise = new THREE.Mesh( geometrySurprise, materialSurprise );
				scene.add( meshSurprise );
				meshSurprise.position.x = -2500 + delta*7;
				emotionMeshes["Surprise"] = meshSurprise;


				var geometryTrust = new THREE.BoxGeometry( 100, 100, 100 );
				var materialTrust = new THREE.MeshBasicMaterial( { color: 0x60FF00 } );
				var meshTrust = new THREE.Mesh( geometryTrust, materialTrust );
				scene.add( meshTrust );
				meshTrust.position.x = -2500 + delta*8;
				emotionMeshes["Trust"] = meshTrust;


				var geometrySadness = new THREE.BoxGeometry( 100, 100, 100 );
				var materialSadness = new THREE.MeshBasicMaterial( { color: 0x0000FF } );
				var meshSadness = new THREE.Mesh( geometrySadness, materialSadness );
				scene.add( meshSadness );
				meshSadness.position.x = -2500 + delta*9;
				emotionMeshes["Sadness"] = meshSadness;


				var geometryAnticipation = new THREE.BoxGeometry( 100, 100, 100 );
				var materialAnticipation = new THREE.MeshBasicMaterial( { color: 0xFF8000 } );
				var meshAnticipation = new THREE.Mesh( geometryAnticipation, materialAnticipation );
				scene.add( meshAnticipation );
				meshAnticipation.position.x = -2500 + delta*10;
				emotionMeshes["Anticipation"] = meshAnticipation;


				var geometryViolence = new THREE.BoxGeometry( 100, 100, 100 );
				var materialViolence = new THREE.MeshBasicMaterial( { color: 0xFF4000 } );
				var meshViolence = new THREE.Mesh( geometryViolence, materialViolence );
				scene.add( meshViolence );
				meshViolence.position.x = -2500 + delta*11;
				emotionMeshes["Violence"] = meshViolence;


				var geometryTerror = new THREE.BoxGeometry( 100, 100, 100 );
				var materialTerror = new THREE.MeshBasicMaterial( { color: 0x008000 } );
				var meshTerror = new THREE.Mesh( geometryTerror, materialTerror );
				scene.add( meshTerror );
				meshTerror.position.x = -2500 + delta*12;
				emotionMeshes["Terror"] = meshTerror;


				renderer = new THREE.WebGLRenderer( { antialias: false } );
				renderer.setPixelRatio( window.devicePixelRatio );
				renderer.setSize( window.innerWidth, window.innerHeight );
				document.body.appendChild( renderer.domElement );

				controls = new THREE.TrackballControls( camera, renderer.domElement );

				/*
				stats = new Stats();
				stats.domElement.style.position = 'absolute';
				stats.domElement.style.top = '0px';
				stats.domElement.style.zIndex = 100;
				document.body.appendChild( stats.domElement );
				*/

				//

				window.addEventListener( 'resize', onWindowResize, false );


				timerUpdateEmotions = setTimeout("updateEmotions()",2000);

			}




			function onWindowResize() {

				camera.aspect = window.innerWidth / window.innerHeight;
				camera.updateProjectionMatrix();

				renderer.setSize( window.innerWidth, window.innerHeight );

				render();

			}

			var time = 0;

			function animate() {

				time = Date.now();

				animAzimuth();

				requestAnimationFrame( animate );

				controls.update();

				render();

			}

			function render() {

				renderer.render( scene, camera );
				//stats.update();

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


		</script>
	</body>
</html>