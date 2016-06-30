<html>
<head>
<title>Human Ecosystems Configuration</title>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="../visualizations/js/jquery.js"></script>
<script src="js/jscolor.min.js"></script>
<script src="js/configuration-research.js"></script>
</head>
<body>
	<div class="page">
		<div class="header">
			<h1>Human Ecosystems : Configuration : Research</h1>
		</div>
		<div class="breadcrumbs">
			<a href="configuration.php" title="go back to general configuration">Main configuration</a>
		</div>
		<?php
			if(file_exists("../API/db.php")){
				require("../API/db.php");

				$researchID = $_REQUEST["researchid"];
				$researchLabel = $_REQUEST["researchlabel"];
				
				checkCommands( $dbh );

				?>
					<div class="row">
						<h2>Configuring research: <?php  echo($researchLabel); ?></h2>
					</div>
					<div class="row">
						<h2>listeners</h2>
					</div>
					<?php 
						$q3 = "SELECT id,name,color,isgeodependent FROM classes WHERE research='" . str_replace("'", "\'", $researchLabel) . "'";
						$r3 = $dbh->query($q3);
						if($r3){
							foreach ($r3 as $row3) {
								?>
								<div class="row">
									<h3>
										<a href="configuration-research.php?researchid=<?php echo($researchID); ?>&researchlabel=<?php echo($researchLabel); ?>&cmd=del-class&idclass=<?php echo($row3["id"]); ?>" >X</a>
										<?php echo($row3["name"]); ?><div class="class-color-block" style="background:#<?php echo( substr($row3["color"], 2) ); ?>"></div>
									</h3>
								</div>
								<div class="row">
									<div class="rowcontent">
										<?php
											$q4 = "SELECT id, word, t FROM words WHERE id_class=" . $row3["id"];
											$r4 = $dbh->query($q4);
											if($r4){
												foreach ($r4 as $row4) {
													?>
													<a href="configuration-research.php?researchid=<?php echo($researchID); ?>&researchlabel=<?php echo($researchLabel); ?>&cmd=del-word&idword=<?php echo($row4["id"]); ?>" >(X)</a><?php echo($row4["word"]); ?> | 
													<?php 
												}
											}
										?>
									</div>
								</div>		
								<?php
							}
						}
					?>
					<div class="row">
						<h2>Add listeners</h2>
					</div>
					<form id="new-class-form" action="configuration-research.php" method="POST">
						<input type="hidden" name="cmd" value="new-class">
						<input type="hidden" name="researchid" value="<?php echo($researchID); ?>">
						<input type="hidden" name="researchlabel" value="<?php echo($researchLabel); ?>">
						<div class="row">
							<div class="rowcontent">
								<div class="inputbox">
									<div class="label">Class Name</div>
									<div class="input"><input type="text" id="class-name" name="class-name" ></div>
									<div class="help">Insert a name for a new class of listeners</div>
								</div>
								<div class="inputbox">
									<div class="label">Color</div>
									<div class="input"><input type="text" id="class-color" class="jscolor" name="class-color" ></div>
									<div class="help">Insert a color in HTML format (RRGGBB)</div>
								</div>
								<div class="inputbox">
									<div class="label">Geographic?</div>
									<div class="input"><input type="checkbox" id="class-geo" name="class-geo" ></div>
									<div class="help">Check if this class is to be listened in a geographic context (using the coordinates defined in the research)</div>
								</div>
								<div class="inputbox">
									<div class="label">Words</div>
									<div class="input"><input type="text" id="class-words" name="class-words" ></div>
									<div class="help">Insert the words for this class, separated by commas (word1,word2,word3...)</div>
								</div>
								<div class="inputbox">
									<div class="label action-section"><a href="#" id="save-class" title="Save Class">SAVE</a></div>
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
				if($_REQUEST["cmd"]=="new-class"){

					$researchID = $_REQUEST["researchid"];
					$researchLabel = str_replace("'", "\'", $_REQUEST["researchlabel"]);
					$className = str_replace("'", "\'", $_REQUEST["class-name"]);
					$classColor = "0x" . str_replace("'", "", $_REQUEST["class-color"]);
					$classIsGeo = "";
					if(isset($_REQUEST["class-geo"])){
						$classIsGeo = $_REQUEST["class-geo"];
					}
					if($classIsGeo=="on"){ $classIsGeo = 1; } else { $classIsGeo = 0; }
					$classWords = explode(",", $_REQUEST["class-words"]);

					$q2 = "INSERT INTO classes(name,color,research,isgeodependent) VALUES ('" . $className . "', '" . $classColor . "','" . $researchLabel . "'," . $classIsGeo . ")";
					$r2 = $dbh->query($q2);

					$classId = $dbh->lastInsertId();

					foreach ($classWords as $word) {
						$word = trim($word);
						if($word!=""){
							$q2 = "INSERT INTO words(id_class,word,t,research) VALUES(" . $classId . ", '" . str_replace("'", "\'", $word) . "', NOW(), '" . $researchLabel .  "')";
							$r2 = $dbh->query($q2);
						}
					}
					
				}

				else if($_REQUEST["cmd"]=="del-word"){

					$researchID = $_REQUEST["researchid"];
					$researchLabel = str_replace("'", "\'", $_REQUEST["researchlabel"]);
					$idword = str_replace("'", "\'", $_REQUEST["idword"]);

					$q2 = "DELETE FROM words WHERE id=" . $idword . " AND research='" . $researchLabel . "'";
					$r2 = $dbh->query($q2);
					
				}

				else if($_REQUEST["cmd"]=="del-class"){

					$researchID = $_REQUEST["researchid"];
					$researchLabel = str_replace("'", "\'", $_REQUEST["researchlabel"]);
					$idclass = str_replace("'", "\'", $_REQUEST["idclass"]);

					$q2 = "DELETE FROM words WHERE id_class=" . $idclass . " AND research='" . $researchLabel . "'";
					$r2 = $dbh->query($q2);

					$q2 = "DELETE FROM classes WHERE id=" . $idclass . " AND research='" . $researchLabel . "'";
					$r2 = $dbh->query($q2);
					
				}

			}
		}
	?>
</body>
</html>