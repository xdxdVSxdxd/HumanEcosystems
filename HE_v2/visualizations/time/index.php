<html>
<head>

		<title>Human Ecosystems – Time</title>

		<link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,200' rel='stylesheet' type='text/css'>

		<link href="../css/style.css" rel="stylesheet">

	
	</style>
</head>
<body>

	<?php

		require_once('../../API/db.php');

	?>

	<div id="emc1container"></div>
	<div id="classescontainer"></div>

	<script src="js/three.min.js"></script>
	<script src="js/controls/OrbitControls.js"></script>
	<script src="js/physi.js"></script>
	<script src="js/tween.min.js"></script>
	<script type="text/javascript" src="js/simplex-noise.js"></script>
	<script src="js/jquery-2.0.3.min.js"></script>
    <script>

    function loadTexture(e){
    	var t=new Image;
    	var n=new THREE.Texture(t);
    	t.onload=function(){n.needsUpdate=true};
    	t.src="proxy.php?url="+e;
    	return n;
    }

    function getUpdates(){
    	$.getJSON("../../API/getContentUpdate.php?w=<?php echo($research_code); ?>",{},function(e){
    		var t;
    		var n=0;
    		var r=0;
    		for(var i=0;i<e.length;i++){
    			t=true;
    			for(var s=0;s<scene.children.length&&t;s++){
    				if(scene.children[s].ids==e[i].ids){
    					t=false
    				}
    			}
    			for(var s=0;s<toPush.length&&t;s++){
    				if(toPush[s].ids==e[i].ids){
    					t=false
    				}
    			}
    			if(t){
    				//var o=new THREE.MeshLambertMaterial({color:parseInt(e[i].color,16),map:loadTexture(e[i].image)});
    				var o=new THREE.MeshLambertMaterial({color:parseInt(e[i].color,16)});
    				var u=new THREE.CubeGeometry(dsize,dsize,dsize,1,1,1);
    				var a=new Physijs.BoxMesh(u,o);
    				a.ids=e[i].ids;
    				a.rc=e[i].rc;
    				a.classe=e[i]["class"];
    				a.ru=e[i].ru;
    				a.link=e[i].link;
    				a.castShadow=true;
    				a.receiveShadow=true;
    				a.position.set(Math.random()*700-350,400,Math.random()*700-350);
    				a.rotation.set(Math.random()*Math.PI,Math.random()*Math.PI,Math.random()*Math.PI);
    				toPush.push(a);
    				sign=1;
    				if(r==0){
    					sign=-1
    				}
    				else if(r==1){
    					sign=1
    				}
    				r++;
    				if(r==2){
    					n=n+dsize*1.5;
    					r=0
    				}
    			}
    		}
    	});
		if(updatesTimeout){
			window.clearInterval(updatesTimeout)
		}
		updatesTimeout=setTimeout("getUpdates()",updateDelay);
		if(toPushTimer){
			window.clearInterval(toPushTimer)
		}
		toPushTimer=setTimeout("pusher()",updateDelay2)
	}

	function pusher(){
		if(toPush.length>0){
			var e=toPush.splice(0,1);
			scene.add(e[0])
		}
		if(toPushTimer){
			window.clearInterval(toPushTimer)
		}
		if(toPush.length>0){
			toPushTimer=setTimeout("pusher()",updateDelay2)
		}
	}

	function render(){
		requestAnimationFrame(render);
		controls.update();
		TWEEN.update();
		renderer.render(scene,camera)
	}

	function resetCamera(){
		camera.rotation.x=0;
		camera.rotation.y=0;
		camera.rotation.z=0;
		camera.position.x=0;
		camera.position.y=0;
		camera.position.z=1e3
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

	Physijs.scripts.worker="js/physijs_worker.js";
	Physijs.scripts.ammo="ammo.js";
	var classes,classesPS;
	var renderer,scene,camera,controls;
	var centerLat=<?php echo($research_clat); ?>;
    var centerLon=<?php echo($research_clon); ?>;
    var mLat=<?php echo($research_minlat); ?>,mLon=<?php echo($research_minlon); ?>,MLat=<?php echo($research_maxlat); ?>,MLon=<?php echo($research_maxlon); ?>;
	var dlat=mLat-MLat;
	var dlon=MLon-mLon;
	var WIDTH=window.innerWidth,HEIGHT=window.innerHeight;
	var VIEW_ANGLE=45,ASPECT=WIDTH/HEIGHT,NEAR=.1,FAR=1e4;
	var $container;
	var contentHolder;
	var updateDelay=1e4;
	var updateDelay2=1e3;
	var maxLeft=2e3;
	var dx=.1;
	var dsize=20;
	var lineHolder;
	var ground_material,ground_geometry,ground;
	var spotLight;
	var toPush,toPushTimer;
	var circles;
	var nCircles=20;
	var resolution=60;
	var baseAmplitude=60;
	var size=360/resolution;
	function toggleVisibility(na,legitem){
    	for(var n=0;n<scene.children.length;n++){
			if(scene.children[n].classe==na){
				scene.children[n].material.visible = !scene.children[n].material.visible;
				scene.children[n].material.needsUpdate = true;
			}
		}
		for(var n=0;n<toPush.length;n++){
			if(toPush[n].classe==na){
				toPush[n].material.visible = !toPush[n].material.visible;
				toPush[n].material.needsUpdate = true;
			}
		}
		$("#"+legitem).toggleClass("legend-highlighted");
    }
	$(document).ready(function(){
		toPush=new Array;
		$container=$("#emc1container");
		renderer=new THREE.WebGLRenderer;
		renderer.shadowMapEnabled=true;
		renderer.shadowMapSoft=true;
		camera=new THREE.PerspectiveCamera(VIEW_ANGLE,ASPECT,NEAR,FAR);
		camera.rotation.x=0;
		camera.position.z=0;
		camera.position.y=1e3;
		camera.position.x=900;
		scene=new Physijs.Scene({fixedTimeStep:1/120});
		scene.setGravity(new THREE.Vector3(0,-90,0));
		scene.addEventListener("update",function(){
			scene.simulate(undefined,2)
		});
		scene.add(camera);
		camera.lookAt(scene.position);
		controls=new THREE.OrbitControls(camera,renderer.domElement);
		renderer.setSize(WIDTH,HEIGHT);
		$container.append(renderer.domElement);
		$.getJSON("../../API/getClasses.php?w=<?php echo($research_code); ?>",{},function(e){
			for(var t=0;t<e.length;t++){
				var n="<div class='legendBox'>";
				var n="<div class='legendBox'>";
    			n=n+"<a href='javascript:toggleVisibility(\"" + e[t].name + "\",  \"legenditem-" + e[t].name + "\"  );'>";
    			n=n+"<div class='legendcolor' style='background:#"+e[t].color.substring(2)+"'></div>";
    			n=n+"<div class='legendname' id='legenditem-" + e[t].name + "'>"+e[t].name+"</div>";
    			n=n+"</a>";
    			n=n+"</div>";
				$("#classescontainer").append(n)
			}
			var n="<div class='legendBox'>";
			n=n+"<div class='legendcolor'></div>";
			n=n+"<div class='legendname' ><a href='javascript:resetCamera();'>Reset Camera</a></div>";
			n=n+"</div>";
			$("#classescontainer").append(n)
		});
		NoiseGen=new SimplexNoise;
		ground_material=Physijs.createMaterial(new THREE.MeshLambertMaterial({map:THREE.ImageUtils.loadTexture("img/ground.png")}),.8,.4);
		ground_geometry=new THREE.PlaneGeometry(2e3,2e3,50,50);
		ground_geometry.computeFaceNormals();
		ground_geometry.computeVertexNormals();
		ground=new Physijs.HeightfieldMesh(ground_geometry,ground_material,0,50,50);
		ground.rotation.x=Math.PI/-2;
		ground.receiveShadow=true;scene.add(ground);
		spotLight=new THREE.SpotLight(16777215,2,2e3,Math.PI/2);
		spotLight.position.set(0,1e3,0);
		spotLight.rotation.x=Math.PI/-2;
		spotLight.castShadow=true;
		spotLight.shadowCameraVisible=false;
		spotLight.shadowMapWidth=1024;
		spotLight.shadowMapHeight=1024;
		spotLight.shadowCameraNear=1e3;
		spotLight.shadowCameraFar=2e3;
		spotLight.shadowCameraFov=30;
		spotLight.visible=true;
		scene.add(spotLight);
		getUpdates();
		initEventHandling();
		requestAnimationFrame(render);
		scene.simulate()
	});
	var updatesTimeout;
	initEventHandling=function(){
		var e=new THREE.Vector3,t=new THREE.Projector,n,r,i;
		n=function(n){
			var r,i;
			e.set(n.clientX/window.innerWidth*2-1,-(n.clientY/window.innerHeight)*2+1,1);
			t.unprojectVector(e,camera);
			r=new THREE.Raycaster(camera.position,e.sub(camera.position).normalize());
			i=r.intersectObjects(scene.children);
			if(i.length>0){
				selected_block=i[0].object;
				if(selected_block.link){
					window.open(selected_block.link)
				}
			}
		};
		r=function(e){};
		i=function(e){
			if(selected_block!==null){
				selected_block=null
			}
		};
		return function(){
			renderer.domElement.addEventListener("mousedown",n);
			renderer.domElement.addEventListener("mousemove",r);
			renderer.domElement.addEventListener("mouseup",i)
		}
	}()
 
    </script>
</body>
</html>