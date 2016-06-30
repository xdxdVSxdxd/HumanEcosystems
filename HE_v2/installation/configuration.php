<html>
<head>
<title>Human Ecosystems Configuration</title>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="../visualizations/js/jquery.js"></script>
<script src="js/configuration.js"></script>
</head>
<body>
	<div class="page">
		<div class="header">
			<h1>Human Ecosystems : Configuration</h1>
		</div>
		<div class="breadcrumbs">
			<a href="index.php" title="go back to home">Home</a>
		</div>
		<?php
			if(file_exists("../API/db.php")){
				require("../API/db.php");
				
				checkCommands( $dbh );

				?>
					<div class="row">
						<h2>RESEARCHES</h2>
					</div>
					<div class="row">
						<div class="rowcontent">
							<select id="research">
								<option value="-1">Select Research</option>
								<?php 
									$r1 = $dbh->query("SELECT id,name,label FROM research");
									if($r1){
										foreach ($r1 as $row1 ) {
											echo("<option value='" . $row1["id"] .  "'>" . $row1["label"] .  "</option>");
										}
									}
								?>
							</select>
							<a href="#" id="del-research" title="delete research">DELETE</a>
							<a href="#" id="conf-research" title="delete research">CONFIGURE</a>
						</div>
					</div>
					<div class="row">
						<div class="rowcontent" id="researchdetails">
							
						</div>
					</div>
					<div class="row">
						<div class="rowcontent">
							<h2>Add research</h2>
						</div>
					</div>
					<form id="research-new" action="configuration.php" method="POST">
						<input type="hidden" name="cmd" id="cmd" value="new-research">
						<div class="row">
							<div class="rowcontent">
								<div class="inputbox">
									<div class="label">Research name</div>
									<div class="input"><input type="text" name="research-name" id="research-name"></div>
								</div>
								<div class="inputbox">
									<div class="label">Research label</div>
									<div class="input"><input type="text" name="research-label" id="research-label"></div>
								</div>
								<div class="inputbox">
									<div class="label">Latitude,Longitude</div>
									<div class="input">Lat: <input type="text" name="research-lat" id="research-lat"></div>
									<div class="input">Lon: <input type="text" name="research-lon" id="research-lon"></div>
									<div class="help">leave empty if this is not a geo-referenced research</div>
								</div>
								<div class="inputbox">
									<div class="label">Geographic Bounding Box</div>
									<div class="input">Min Lat: <input type="text" name="research-minlat" id="research-minlat"></div>
									<div class="input">Min Lon: <input type="text" name="research-minlon" id="research-minlon"></div>
									<div class="input">Max Lat: <input type="text" name="research-maxlat" id="research-maxlat"></div>
									<div class="input">Max Lon: <input type="text" name="research-maxlon" id="research-maxlon"></div>
									<div class="help">leave empty if this is not a geo-referenced research</div>
								</div>
								<div class="inputbox">
									<div class="label action-section"><a href="#" id="save-research" title="Save Research">SAVE</a></div>
								</div>
							</div>
						</div>
					</form>
				<?php
			} else{
				?>
					<div class="row">
						<div class="rowcontent">
							<h1>Installation not completed. <a href="index.php">Go Back.</a></h1>
						</div>
					</div>
				<?php
			}

		?>
	</div>
	<?php 
		function checkCommands($dbh){
			if( isset($_REQUEST["cmd"])){
				if($_REQUEST["cmd"]=="new-research"){
					$research_name = $_REQUEST["research-name"];
					$research_label = $_REQUEST["research-label"];
					$research_clat = $_REQUEST["research-lat"];
					$research_clon = $_REQUEST["research-lon"];
					$research_minlat = $_REQUEST["research-minlat"];
					$research_minlon = $_REQUEST["research-minlon"];
					$research_maxlat = $_REQUEST["research-maxlat"];
					$research_maxlon = $_REQUEST["research-maxlon"];
					if($research_clat=="" || $research_clon=="" || $research_minlat=="" || $research_minlon=="" || $research_maxlat=="" || $research_maxlon==""){
						$research_clat = 999;
						$research_clon = 999;
						$research_minlat = 999;
						$research_minlon = 999;
						$research_maxlat = 999;
						$research_maxlon = 999;
					}
					$q2 = "INSERT INTO research(name,label,clat,clon,minlat,minlon,maxlat,maxlon) VALUES ('" .  str_replace("'", " ", $research_name)  . "','" .  str_replace("'", " ", $research_label)  . "'," .  str_replace("'", " ", $research_clat)  . "," .  str_replace("'", " ", $research_clon)  . "," .  str_replace("'", " ", $research_minlat)  . "," .  str_replace("'", " ", $research_minlon)  . "," .  str_replace("'", " ", $research_maxlat)  . "," .  str_replace("'", " ", $research_maxlon)  . ")";
					$r2 = $dbh->query($q2);
				}
				else if($_REQUEST["cmd"]=="del-research"){
					$id = str_replace("'", "\'", $_REQUEST["id"]);
					$label = str_replace("'", "\'", $_REQUEST["label"]);
					$q2 = "DELETE FROM classes WHERE research='" . $label . "'";
					$r2 = $dbh->query($q2);
					$q2 = "DELETE FROM classifier_corecmessage WHERE research='" . $label . "'";
					$r2 = $dbh->query($q2);
					$q2 = "DELETE FROM classifier_corecurrence WHERE research='" . $label . "'";
					$r2 = $dbh->query($q2);
					$q2 = "DELETE FROM classifier_words WHERE research='" . $label . "'";
					$r2 = $dbh->query($q2);
					$q2 = "DELETE FROM content WHERE research='" . $label . "'";
					$r2 = $dbh->query($q2);
					$q2 = "DELETE FROM content_to_class WHERE research='" . $label . "'";
					$r2 = $dbh->query($q2);
					$q2 = "DELETE FROM relations WHERE research='" . $label . "'";
					$r2 = $dbh->query($q2);
					$q2 = "DELETE FROM users WHERE research='" . $label . "'";
					$r2 = $dbh->query($q2);
					$q2 = "DELETE FROM research WHERE label='" . $label . "'";
					$r2 = $dbh->query($q2);
					$q2 = "DELETE FROM words WHERE research='" . $label . "'";
					$r2 = $dbh->query($q2);
				}
			}
		}
	?>
</body>
</html>