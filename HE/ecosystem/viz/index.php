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
	<div id="navContainer">
		<a href='/HE/index.php' title='Human Ecosystems'>
			<img src='img/HE_logo_transparent.png' title='Human Ecosystems' />
		</a>
		<a href='index.php?w=<?php echo($www); ?>' title='Space'>
			SPACE
		</a>
		<a href='time.php?w=<?php echo($www); ?>' title='Time'>
			TIME
		</a>
		<a href='relations.php?w=<?php echo($www); ?>' title='Relations'>
			RELATIONS
		</a>
	</div>


	<script src="js/three.min.js"></script>
	<script src="js/controls/OrbitControls.js"></script>
	<script src="js/tween.min.js"></script>
	<script src="js/jquery-2.0.3.min.js"></script>
    <script>

    <?php 

    	$www = "";
    	if(isset($_REQUEST["w"])){
    		$www = $_REQUEST["w"];
    	}

    ?>

    function loadTexture(e){
    	var t=new Image;
    	var n=new THREE.Texture(t);
    	t.onload=function(){
    		n.needsUpdate=true;
    		console.log("texture "+e+" loaded")
    	};
    	t.src=e;
    	return n;
    }

    function resetCamera(){
    	camera.rotation.x=0;
    	camera.rotation.y=0;
    	camera.rotation.z=0;
    	camera.position.x=0;
    	camera.position.y=0;
    	camera.position.z=1e3;
    }

    function toggleIntensity(){
    	italia2.visible=!italia2.visible;
    	italia.visible=!italia.visible;
    	spotLight.visible=!spotLight.visible;
    	var e=0;
    	if(italia2.visible){
    		e=1e3;
    	}
    	for(var t=0;t<classesMesh.children.length;t++){
    		for(var n=0;n<classesMesh.children[t].children.length;n++){
    			classesMesh.children[t].children[n].visible=!classesMesh.children[t].children[n].visible;
    		}
    	}
    }

    function augment(e,t,n,r,i){
    	var s=e-MLat;
    	var o=t-mLon;
    	var u=Math.round(heightSegments-heightSegments*s/dlat);
    	var a=Math.round(widthSegments*o/dlon);
    	if(u>=0&&u<heightSegments&&a>=0&&a<widthSegments){
    		italia2.geometry.vertices[a+u*(widthSegments+1)].z=italia2.geometry.vertices[a+u*(widthSegments+1)].z+n;
    		italia2.geometry.vertices[a+1+u*(widthSegments+1)].z=italia2.geometry.vertices[a+1+u*(widthSegments+1)].z+n;
    		italia2.geometry.vertices[a+1+(u+1)*(widthSegments+1)].z=italia2.geometry.vertices[a+1+(u+1)*(widthSegments+1)].z+n;
    		italia2.geometry.vertices[a+(u+1)*(widthSegments+1)].z=italia2.geometry.vertices[a+(u+1)*(widthSegments+1)].z+n;
    		var f=0;
    		for(var l=0;l<classes.length;l++){
    			if(r==classes[l].name){
    				var c=new THREE.Vector3(italia.geometry.vertices[a+u*(widthSegments+1)].x,italia.geometry.vertices[a+u*(widthSegments+1)].y,f);
    				//var h=new THREE.Mesh(new THREE.CubeGeometry(i*2,i*2,i*2,1,1,1),classesPS[l].material);
                    var h=new THREE.Mesh(new THREE.CubeGeometry(6,6,i*5,1,1,1),classesPS[l].material);
    				h.position={
    					x:italia.geometry.vertices[a+u*(widthSegments+1)].x,
    					y:italia.geometry.vertices[a+u*(widthSegments+1)].y,
    					z:f
    				};
    				classesPS[l].add(h);
    			}
    		}
    	}
    }

    function render(){
    	requestAnimationFrame(render);
    	controls.update();
    	TWEEN.update();
    	renderer.render(scene,camera);
    }

    var classes,classesPS;
    var renderer,scene,camera,controls;
    var centerLat=<?php echo($cityclat); ?>;
    var centerLon=<?php echo($cityclon); ?>;
    var mLat=<?php echo($cityminlat); ?>,mLon=<?php echo($cityminlon); ?>,MLat=<?php echo($citymaxlat); ?>,MLon=<?php echo($citymaxlon); ?>;
    var dlat=mLat-MLat;
    var dlon=MLon-mLon;
    var minZForParticles=200;
    var WIDTH=window.innerWidth,HEIGHT=window.innerHeight;
    var mapWidth=2e3;
    var mapHeight=2e3;
    var VIEW_ANGLE=45,ASPECT=WIDTH/HEIGHT,NEAR=.1,FAR=1e4;
    var $container;
    var italiaMaterial,italiaMaterial2;
    var widthSegments=300,heightSegments=300;
    var italia,italia2;
    var cameraP1X=0;
    var cameraP1Y=200;
    var cameraP2X=0;
    var cameraP2Y=-500;
    var timeTween=15e3;
    var mapTween1,mapTween2;
    var linesMesh,lineMaterial;
    var skyboxMesh,classesMesh,spotLight,directionalLight;

    function toggleVisibility(na,legitem){
    	for(var n=0;n<classes.length;n++){
    		console.log(classesPS[n]);
			if(classesPS[n].idname==na){
				classesPS[n].material.visible = !classesPS[n].material.visible;
				classesPS[n].material.needsUpdate = true;
				$("#"+legitem).toggleClass("legend-highlighted");
			}
		}
    }

    $(document).ready(function(){
    	$container=$("#emc1container");
    	renderer=new THREE.WebGLRenderer;
    	renderer.shadowMapEnabled=true;
    	renderer.shadowMapSoft=true;
    	camera=new THREE.PerspectiveCamera(VIEW_ANGLE,ASPECT,NEAR,FAR);
    	camera.rotation.x=0;
    	camera.position.y=0;
    	controls=new THREE.OrbitControls(camera,renderer.domElement);
    	scene=new THREE.Scene;scene.add(camera);
    	camera.position.z=1e3;
    	renderer.setSize(WIDTH,HEIGHT);
    	$container.append(renderer.domElement);
    	lineMaterial=new THREE.LineBasicMaterial({
    		color:4473924,
    		linewidth:1,
    		linecap:"square",
    		opacity:.3
    	});
    	linesMesh=new THREE.Object3D;scene.add(linesMesh);
    	classesMesh=new THREE.Object3D;
    	scene.add(classesMesh);
    	classesMesh.visible=true;
    	classesPS=new Array;
    	$.getJSON("getClasses.php?w=<?php echo($www); ?>",{},function(e){
    		classes=e;
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
    			classesPS.push(i);
    			classesMesh.add(i);
    		}
    		italia.geometry.verticesNeedUpdate=true;
    		var n="<div class='legendBox'>";
    		n=n+"<div class='legendcolor'></div>";
    		n=n+"<div class='legendname' ><a href='javascript:resetCamera();'>Reset Camera</a></div>";
    		n=n+"</div>";
    		$("#classescontainer").append(n);
    		n="<div class='legendBox'>";
    		n=n+"<div class='legendcolor'></div>";
    		n=n+"<div class='legendname' ><a href='javascript:toggleIntensity();'>Intensity ON/OFF</a></div>";
    		n=n+"</div>";$("#classescontainer").append(n)
    	});
		italiaMaterial=new THREE.MeshLambertMaterial({color:16777215,opacity:1,map:THREE.ImageUtils.loadTexture("img/<?php echo($www); ?>.png",{},function(){italia.material.map.needsUpdate=true})});
		italiaMaterial2=new THREE.MeshBasicMaterial({color:32768,wireframe:true,transparent:true,opacity:.3});
		italia=new THREE.Mesh(new THREE.PlaneGeometry(mapWidth,mapHeight,widthSegments,heightSegments),italiaMaterial);
		italia.castShadow=true;
		italia.receiveShadow=true;
		italia.dynamic=true;
		italia2=new THREE.Mesh(new THREE.PlaneGeometry(mapWidth,mapHeight,widthSegments,heightSegments),italiaMaterial);
		italia2.position.z=0;
		italia2.castShadow=true;
		italia2.receiveShadow=true;
		italia2.visible=false;
		italia2.dynamic=true;
		scene.add(italia);
		scene.add(italia2);
		directionalLight=new THREE.PointLight(16777215,2,3e3);
		directionalLight.position.set(0,0,2e3);
		scene.add(directionalLight);
		spotLight=new THREE.SpotLight(16711680,2,2e3,Math.PI/2);
		spotLight.position.set(0,0,1e3);
		spotLight.castShadow=true;
		spotLight.shadowCameraVisible=false;
		spotLight.shadowMapWidth=1024;
		spotLight.shadowMapHeight=1024;
		spotLight.shadowCameraNear=1e3;
		spotLight.shadowCameraFar=2e3;
		spotLight.shadowCameraFov=30;
		spotLight.visible=false;
		scene.add(spotLight);
		requestAnimationFrame(render);

		$.getJSON("getContentForMap.php?w=<?php echo($www); ?>",{},function(e){
			for(var t=0;t<e.length;t++){
				augment(parseFloat(e[t].lat),parseFloat(e[t].lng),parseFloat(e[t].c)*10,e[t].name,e[t].c);
			}
			italia2.geometry.verticesNeedUpdate=true;
			for(var n=0;n<classes.length;n++){
				classesPS[n].geometry.__dirtyVertices=true;
			}
		});

		camera.position.x=cameraP1X;
		camera.position.y=cameraP1Y
	});
 
    </script>
</body>
</html>