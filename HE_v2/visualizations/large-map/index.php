<html>
<head>

        <title>large map</title>

		<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200' rel='stylesheet' type='text/css'>


<style>
html,body{
    margin: 0px;
    padding: 0px;
    width:100%;
    height: 100%;
    background: #FFFFFF;
    color: #000000;
    font: 10px Helvetica, Arial, sans-serif;
    overflow: hidden;
}
div#emc1container{
    margin: 0px;
    padding: 0px;
    width:100%;
    height: 100%;
    background: #FFFFFF;
    color: #000000;
    font: 10px Helvetica, Arial, sans-serif;
    overflow: hidden;
}

        #classescontainer{
            position: absolute;
            z-index: 900;
            background: transparent;
            color: #FFFFFF;
            top: 5px;
            left: 5px;
            width: 100px;
            padding: 0px;
            margin: 0px;
        }

</style>

<link href="../css/style.css" rel="stylesheet">

</head>
<body>

	<?php

		require_once('../../API/db.php');

	?>
	<div id="emc1container"></div>
	<div id="classescontainer"></div>

	<script src="../js/three.min.js"></script>
	<script src="../js/controls/OrbitControls.js"></script>
	<script src="../js/tween.min.js"></script>
	<script src="../js/jquery-2.0.3.min.js"></script>
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
        
        console.log("[1]" + e + "," + t);
    	
        var s=e-mLat;
    	var o=t-mLon;

        console.log("[2]" + s + "," + o);

    	var u=Math.round(heightSegments-heightSegments*s/dlat);
    	var a=Math.round(widthSegments*o/dlon);

        console.log("[3]" + u + "," + a);

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

<?php

$mapname = $www;

if($research_clat==999 || $research_clon==999){
    $research_clat = 0;
    $research_clon = 0;
    $research_minlat = -84.67351256610522;
    $research_minlon = -175.78125;
    $research_maxlat = 84.67351256610522;
    $research_maxlon = 175.78125;

    $mapname = "world";
}

?>


    var classes,classesPS;
    var renderer,scene,camera,controls;
    var centerLat=<?php echo($research_clat); ?>;
    var centerLon=<?php echo($research_clon); ?>;
    var mLat=<?php echo($research_minlat); ?>,mLon=<?php echo($research_minlon); ?>,MLat=<?php echo($research_maxlat); ?>,MLon=<?php echo($research_maxlon); ?>;
    var dlat=MLat-mLat;
    var dlon=MLon-mLon;
    var minZForParticles=200;
    var WIDTH=$(window).innerWidth(); var HEIGHT=$(window).innerHeight();
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
    	$.getJSON("../../API/getClasses.php?w=<?php echo($www); ?>",{},function(e){
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
		italiaMaterial=new THREE.MeshLambertMaterial({color:16777215,opacity:1,map:THREE.ImageUtils.loadTexture("../assets/<?php echo($mapname); ?>.png",{},function(){italia.material.map.needsUpdate=true})});
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

		$.getJSON("../../API/getContentForMap.php?w=<?php echo($www); ?>",{},function(e){
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