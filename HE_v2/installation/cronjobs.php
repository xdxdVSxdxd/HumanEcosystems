<html>
<head>
<title>Human Ecosystems Configuration</title>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="../visualizations/js/jquery.js"></script>
<script src="js/cronjobs.js"></script>
</head>
<body>
	<div class="page">
		<div class="header">
			<h1>Human Ecosystems : Configuration : CRON Jobs</h1>
		</div>
		<div class="breadcrumbs">
			<a href="index.php" title="go back to home">Home</a>
		</div>
		<?php
			if(file_exists("../API/db.php")){
				require("../API/db.php");
				
				checkCommands( $dbh );



				?>

					<script>
						var serverUrl = "<?php  
						
						$urlo = 'http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

						$urlo = str_replace("installation/cronjobs.php", "", $urlo);

						echo($urlo);

						?>";
					</script>
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
						</div>
					</div>
					<div class="row">
						<div class="rowcontent" id="researchdetails">
							
						</div>
					</div>
					<div class="row">
						<div class="rowcontent" id="cronjobsdetails">
							<pre></pre>
							
						</div>
					</div>
					<div class="row">
						<div class="rowcontent">
							<p>This page gives out instructions on how to set up CRON jobs (scheduled tasks) on your Unix/Linux machine.</p>
							<p>To do this, you will need to have proper systems permissions to schedule chron jobs and to access the crontab. Check with your system administrator.</p>
							<p>By selecting one of your configured researches above, you will generate some text. Copy it and insert it into a textfile (for example named <em>crontab.txt</em>, save it and execute the following command on it:</p>
							<pre>crontab crontab.txt</pre>
							<p>Note that this command needs to be executed on the machine which hosts the Human Ecosystems installation. If you create the text file on another machine you will need to upload it through FTP on the Human Ecosystems machine, and access the system shell to execute the command above from there.</p>
							<p>We provide a series of "standard" schedulings, but you can choose your own by varying the contents of the file. For example you can look <a href="http://www.thesitewizard.com/general/set-cron-job.shtml" target="_blank">HERE</a> for a nice tutorial to learn how crontab works.</p>
						</div>
					</div>
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
				if($_REQUEST["cmd"]=="XXXXXX"){
				}
			}
		}
	?>
</body>
</html>