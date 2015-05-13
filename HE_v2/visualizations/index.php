<html>
<head>
	<title>Current Visualizations</title>
	<style>
		html,body{
			background: #FFFFFF;
			color: #333333;
			margin: 0px;
			padding: 0px;
		}
		h1{
			font: bold 18px Helvetica, Arial, sans-serif;
			padding: 10px;
		}
		h2{
			font: 16px Helvetica, Arial, sans-serif;
			padding: 10px;
		}
		h3{
			font: bold 12px Helvetica, Arial, sans-serif;
			padding: 0px;
		}
		h4{
			font: 10px Helvetica, Arial, sans-serif;
			text-align: center;
			padding: 0px;
		}
		.container{
			padding: 10px;
			clear: auto;
		}
		.vizblock{
			float: left;
			width: 400px;
			color: #333333;
			background: #EEEEEE;
			padding: 4px;
			margin: 4px;
		}
		.vizblock:hover{
			color: #333333;
			background: #CCCCCC;
		}
	</style>
	<script type="text/javascript" src="js/jquery-2.0.3.min.js"></script>
</head>
<body>
<?php 
	require_once("../API/db.php");
?>
<h1>Human Ecosystems</h1>
<h2>Current Visualizations</h2>
<div class="container">
	<h3>Select research to visualize</h3>
	<select id="selectresearch" name="selectresearch">
		<?php
			$q1 = "SELECT DISTINCT name, label FROM research ORDER BY name ASC";
			$r1 = $dbh->query($q1);
			if($r1){
				$isFirst = true;
				foreach ( $r1 as $row1) {
					$name = $row1["name"];
					$label = $row1["label"];
					?>
						<option value="<?php echo($label); ?>" <?php  if($isFirst){ echo("SELECTED");  $isFirst=false; } ?>><?php echo($name); ?></option>
					<?php
				}
				$r1->closeCursor();
			}

		?>
	</select>
</div>


<div class="container">
	<?php
		foreach(glob('./*', GLOB_ONLYDIR) as $dir) {
		    $dirname = basename($dir);

		    if(  $dirname!="assets"  && $dirname!="css" && $dirname!="js"){
		    	echo("<a href='" . $dirname . "' target='_blank'>");
		    	?>
			    
		    	<div class="vizblock">
		    		<img src="<?php echo($dirname); ?>/screenshot.png" width="400" height="200" border="0" />
		    		<h4><?php echo($dirname); ?></h4>
		    	</div>

			    <?php
			    echo("</a>");	
		    }
		    
		}
	?>
</div>

<script type="text/javascript">

	var selectedresearch = "";

	$( document ).ready(function() {
		selectedresearch = $("#selectresearch").val();


		$("a").click(function(){
		    selectedresearch = $("#selectresearch").val();
		    window.open(  $(this).attr("href")  + "/?w=" + selectedresearch  );
		});

	});
</script>
</body>
</html>