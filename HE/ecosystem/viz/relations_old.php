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

	<?php

		require_once('../db.php');

	?>

	<div id="emc1container"></div>
	<div id="classescontainer"></div>
	<div id="navContainer">
		<a href='/HE/index.php' title='Human Ecosystems'>
			<img src='img/HE_logo_transparent.png' title='Human Ecosystems' />
		</a>
		<a href='index.php?w=<?php echo($w); ?>' title='Space'>
			SPACE
		</a>
		<a href='time.php?w=<?php echo($w); ?>' title='Time'>
			TIME
		</a>
		<a href='relations.php?w=<?php echo($w); ?>' title='Relations'>
			RELATIONS
		</a>
	</div>


	<script src="js/three.min.js"></script>
	<script src="js/controls/OrbitControls.js"></script>
	<script src="js/tween.min.js"></script>
	<script src="js/jquery-2.0.3.min.js"></script>
    <script>

    function loadTexture(e){
    	var t=new Image;
    	var n=new THREE.Texture(t);
    	t.onload=function(){
    		n.needsUpdate=true;
    		console.log("texture "+e+" loaded")
    	};
    	t.src=e;
    	return n
    }

    function resetCamera(){
    	camera.rotation.x=0;camera.rotation.y=0;camera.rotation.z=0;camera.position.x=0;camera.position.y=0;camera.position.z=1e3
    }

    function render(){
    	requestAnimationFrame(render);
    	controls.update();
    	TWEEN.update();
    	var e=Date.now()*5e-5;
    	if(particles1){
    		particles1.rotation.y=e*.5
    	}
    	if(particles10){
    		particles10.rotation.y=e*.5
    	}
    	if(particles20){
    		particles20.rotation.y=e*.5
    	}
    	if(particlesmax){
    		particlesmax.rotation.y=e*.5
    	}
    	doAnim20();
    	doAnim10();
    	doAnim1();
    	renderer.render(scene,camera)
    }

    function doAnim20(){
    	if(attraction20tomax&&particles20&&particlesmax){
    		for(var e=0;e<attraction20tomax.length-1;e++){
    			var t=particlesmax.geometry.vertices[attraction20tomax[e].to].x-particles20.geometry.vertices[attraction20tomax[e].from].x;
    			var n=particlesmax.geometry.vertices[attraction20tomax[e].to].y-particles20.geometry.vertices[attraction20tomax[e].from].y;
    			var r=particlesmax.geometry.vertices[attraction20tomax[e].to].z-particles20.geometry.vertices[attraction20tomax[e].from].z;
    			if(Math.abs(t)>delta||Math.abs(n)>delta||Math.abs(r)>delta){
    				particles20.geometry.vertices[attraction20tomax[e].from].x=particles20.geometry.vertices[attraction20tomax[e].from].x+t/steps;
    				particles20.geometry.vertices[attraction20tomax[e].from].y=particles20.geometry.vertices[attraction20tomax[e].from].y+n/steps;
    				particles20.geometry.vertices[attraction20tomax[e].from].z=particles20.geometry.vertices[attraction20tomax[e].from].z+r/steps
    			}
    		}
    		particles20.geometry.verticesNeedUpdate=true;
    		particles20.verticesNeedUpdate=true;
    		particles20.needUpdate=true
    	}
    }

    function doAnim10(){
    	if(attraction10to20&&particles10&&particles20){
    		for(var e=0;e<attraction10to20.length-1;e++){
    			var t=particles20.geometry.vertices[attraction10to20[e].to].x-particles10.geometry.vertices[attraction10to20[e].from].x;
    			var n=particles20.geometry.vertices[attraction10to20[e].to].y-particles10.geometry.vertices[attraction10to20[e].from].y;
    			var r=particles20.geometry.vertices[attraction10to20[e].to].z-particles10.geometry.vertices[attraction10to20[e].from].z;
    			if(Math.abs(t)>delta||Math.abs(n)>delta||Math.abs(r)>delta){
    				particles10.geometry.vertices[attraction10to20[e].from].x=particles10.geometry.vertices[attraction10to20[e].from].x+t/steps;
    				particles10.geometry.vertices[attraction10to20[e].from].y=particles10.geometry.vertices[attraction10to20[e].from].y+n/steps;
    				particles10.geometry.vertices[attraction10to20[e].from].z=particles10.geometry.vertices[attraction10to20[e].from].z+r/steps
    			}
    		}
    		particles10.geometry.verticesNeedUpdate=true;
    		particles10.verticesNeedUpdate=true;
    		particles10.needUpdate=true
    	}
    }

    function doAnim1(){
    	if(attraction1to10&&particles10&&particles1){
    		for(var e=0;e<attraction1to10.length-1;e++){
    			var t=particles10.geometry.vertices[attraction1to10[e].to].x-particles1.geometry.vertices[attraction1to10[e].from].x;
    			var n=particles10.geometry.vertices[attraction1to10[e].to].y-particles1.geometry.vertices[attraction1to10[e].from].y;
    			var r=particles10.geometry.vertices[attraction1to10[e].to].z-particles1.geometry.vertices[attraction1to10[e].from].z;
    			if(Math.abs(t)>delta||Math.abs(n)>delta||Math.abs(r)>delta){
    				particles1.geometry.vertices[attraction1to10[e].from].x=particles1.geometry.vertices[attraction1to10[e].from].x+t/steps;
    				particles1.geometry.vertices[attraction1to10[e].from].y=particles1.geometry.vertices[attraction1to10[e].from].y+n/steps;
    				particles1.geometry.vertices[attraction1to10[e].from].z=particles1.geometry.vertices[attraction1to10[e].from].z+r/steps
    			}
    		}
    		particles1.geometry.verticesNeedUpdate=true;
    		particles1.verticesNeedUpdate=true;
    		particles1.needUpdate=true
    	}
    }

    function handleRelations(){
    	if(relations){
    		var e=false;
    		var t=false;
    		for(var n=0;n<200;n++){
    			i=(currRelation+n)%relations.length;
    			if(i<relations.length){
    				if(!relations[i].finished){
    					e=false;
    					t=false;
    					for(var r=0;r<particles.geometry.vertices.length&&!e;r++){
    						if(particles.geometry.vertices[r].id_social==relations[i].id_social){
    							e=true;
    							for(var s=0;s<particles.geometry.vertices.length&&!t;s++){
    								if(particles.geometry.vertices[s].id_social==relations[i].reply_to){
    									t=true;
    									particles.geometry.vertices[r].x=particles.geometry.vertices[r].x+(particles.geometry.vertices[s].x-particles.geometry.vertices[r].x)/40;
    									particles.geometry.vertices[r].y=particles.geometry.vertices[r].y+(particles.geometry.vertices[s].y-particles.geometry.vertices[r].y)/40;
    									particles.geometry.vertices[r].z=particles.geometry.vertices[r].z+(particles.geometry.vertices[s].z-particles.geometry.vertices[r].z)/40
    								}
    							}
    						}
    					}
    				}
    			}
    		}
    		particles.geometry.verticesNeedUpdate=true;
    		currRelation++;
    		if(currRelation>=relations.length){
    			currRelation=0
    		}
    	}
    }

    var classes,classesPS;
    var renderer,scene,camera,controls;
    var mindelta=30;
    var particles1,particles10,particles20,particlesmax;
    var WIDTH=window.innerWidth,HEIGHT=window.innerHeight;
    var VIEW_ANGLE=45,ASPECT=WIDTH/HEIGHT,NEAR=.1,FAR=1e4;
    var $container;
    var directionalLight;
    var amplitude=4e3;
    var circleStep;
    var users,psize;
    var selected_block;
    var relations,particles,currRelation;
    var attraction1to10,attraction10to20,attraction20tomax;
    var steps=50;
    var delta=30;

    $(document).ready(function(){
    	psize=30;
    	currRelation=0;
    	$container=$("#emc1container");
    	renderer=new THREE.WebGLRenderer;
    	renderer.shadowMapEnabled=true;
    	renderer.shadowMapSoft=true;
    	camera=new THREE.PerspectiveCamera(VIEW_ANGLE,ASPECT,NEAR,FAR);
    	camera.rotation.x=0;
    	camera.position.y=0;
    	controls=new THREE.OrbitControls(camera,renderer.domElement);
    	scene=new THREE.Scene;
    	scene.fog=new THREE.FogExp2(0,2e-4);
    	scene.add(camera);
    	camera.position.z=1e3;
    	renderer.setSize(WIDTH,HEIGHT);
    	$container.append(renderer.domElement);
    	classesPS=new Array;
    	var e="<div class='legendBox'>";
    	e=e+"<div class='legendcolor' style='background:#FF8000'></div>";
    	e=e+"<div class='legendname' >Influencers / Operators</div>";
    	e=e+"</div>";
    	$("#classescontainer").append(e);
    	e="<div class='legendBox'>";
    	e=e+"<div class='legendcolor' style='background:#00AA00'></div>";
    	e=e+"<div class='legendname' >Bridges</div>";
    	e=e+"</div>";
    	$("#classescontainer").append(e);
    	e="<div class='legendBox'>";
    	e=e+"<div class='legendcolor' style='background:#AAAAAA'></div>";
    	e=e+"<div class='legendname' >Hubs</div>";
    	e=e+"</div>";$("#classescontainer").append(e);
    	e="<div class='legendBox'>";
    	e=e+"<div class='legendcolor' style='background:#555555'></div>";
    	e=e+"<div class='legendname' >Simple Nodes</div>";
    	e=e+"</div>";$("#classescontainer").append(e);
    	e="<div class='legendBox'>";
    	e=e+"<div class='legendcolor'></div>";
    	e=e+"<div class='legendname' ><a href='javascript:resetCamera();'>Reset Camera</a></div>";
    	e=e+"</div>";$("#classescontainer").append(e);
    	var t=new THREE.MeshBasicMaterial({color:8947967});
    	var n=new THREE.MeshBasicMaterial({color:136});
    	var r=new THREE.MeshBasicMaterial({color:136});
    	$.getJSON("getUsers.php?w=<?php echo($w); ?>",{},function(e){
    		var t=new THREE.Geometry;
    		var n=new THREE.Geometry;
    		var r=new THREE.Geometry;
    		var i=new THREE.Geometry;
    		for(var s=0;s<e.length;s++){
    			var o=new THREE.Vector3;
    			o.x=Math.random()*4e3-2e3;
    			o.y=Math.random()*4e3-2e3;
    			o.z=Math.random()*4e3-2e3;
    			o.idd=e[s].id;
    			o.id_social=e[s].id_social;
    			o.nick=e[s].nick;
    			o.profile_url=e[s].profile_url;
    			o.image_url=e[s].image_url;
    			o.source=e[s]["source"];
    			if(e[s].c<=15){
    				t.vertices.push(o)
    			}
    			else if(e[s].c<=30){
    				n.vertices.push(o)
    			}
    			else if(e[s].c<=40){
    				r.vertices.push(o)
    			}
    			else{
    				i.vertices.push(o)
    			}
    		}
    		attraction1to10=new Array;
    		var u=Math.round(t.vertices.length*.9);
    		for(var s=0;s<u;s++){
    			var a=new Object;
    			a.from=Math.round(Math.random()*(t.vertices.length-1));
    			a.to=Math.round(Math.random()*(n.vertices.length-1));
    			a.finished=false;
    			attraction1to10.push(a)
    		}
    		attraction10to20=new Array;
    		u=Math.round(n.vertices.length*.8);
    		for(var s=0;s<u;s++){
    			var a=new Object;
    			a.from=Math.round(Math.random()*(n.vertices.length-1));
    			a.to=Math.round(Math.random()*(r.vertices.length-1));
    			a.finished=false;
    			attraction10to20.push(a)
    		}
    		attraction20tomax=new Array;
    		u=Math.round(r.vertices.length*.7);
    		for(var s=0;s<u;s++){
    			var a=new Object;
    			a.from=Math.round(Math.random()*(r.vertices.length-1));
    			a.to=Math.round(Math.random()*(i.vertices.length-1));
    			a.finished=false;
    			attraction20tomax.push(a)
    		}
    		var f=new THREE.ParticleBasicMaterial({color:5592405,size:10});
    		particles1=new THREE.ParticleSystem(t,f);
    		particles1.rotation.y=Math.random()*6;
    		scene.add(particles1);
    		var l=new THREE.ParticleBasicMaterial({color:11184810,size:30});
    		particles10=new THREE.ParticleSystem(n,l);
    		particles10.rotation.y=Math.random()*6;
    		scene.add(particles10);
    		var c=new THREE.ParticleBasicMaterial({color:43520,size:50});
    		particles20=new THREE.ParticleSystem(r,c);
    		particles20.rotation.y=Math.random()*6;
    		scene.add(particles20);
    		var h=new THREE.ParticleBasicMaterial({color:16744448,size:100});
    		particlesmax=new THREE.ParticleSystem(i,h);
    		particlesmax.rotation.y=Math.random()*6;
    		scene.add(particlesmax)
    	});
	directionalLight=new THREE.DirectionalLight(16777215,.5);
	directionalLight.position.set(0,.5,0);
	directionalLight.castShadow=true;
	directionalLight.shadowCameraVisible=false;
	directionalLight.position.set(0,0,2e3);
	scene.add(directionalLight);
	initEventHandling();
	requestAnimationFrame(render)
});

initEventHandling=function(){
	var e=new THREE.Vector3,t=new THREE.Projector,n,r,i;
	n=function(n){
		var r,i;
		e.set(n.clientX/window.innerWidth*2-1,-(n.clientY/window.innerHeight)*2+1,1);
		t.unprojectVector(e,camera);
		r=new THREE.Raycaster(camera.position,e.sub(camera.position).normalize());
		i=r.intersectObjects(scene);
		console.log("mousedown");
		if(i.length>0){
			console.log("[0]");
			selected_block=i[0].object;
			console.log(selected_block);
			if(selected_block.nick){
				console.log(selected_block.nick)
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