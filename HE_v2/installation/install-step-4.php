<html>
<head>
<title>Human Ecosystems Installation</title>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="../visualizations/js/jquery.js"></script>
<script src="js/install-step-4.js"></script>
</head>
<body>
	<div class="page">
		<div class="header">
			<h1>Human Ecosystems : Installation, Step 4</h1>
		</div>
		<div class="row">
			<div class="rowcontent">
				<h2>Social Network Configuration</h2>
				<p>View results, then press NEXT.</p>
			</div>
		</div>
		<div class="row">
			<div class="breadcrumbs">
				<a href="index.php" title="installation home">Installation Home</a>
				>
				<a href="install-step-1.php" title="Installation step 1: database">Installation step 1: database</a>
				>
				<a href="install-step-3.php" title="Installation step 3: social networks">Installation step 3: social networks</a>
			</div>
		</div>
		<?php 

			$success = true;
			$errormessages = "";

			// cancella db.php in API
			if(file_exists("../API/parameter-parser.php")){
				unlink("../API/parameter-parser.php");
			}
			// cp db.php da templates a API
			if(!copy("templatefiles/parameter-parser.php","../API/parameter-parser.php")){
				$success = false;
				$errormessages = "Could not copy social network configuration file to API.";
			}
			if($success){

				// replace su db.php in API con i parametri del db
				$parametersfile = file_get_contents("../API/parameter-parser.php");

				$parametersfile = str_replace("[FB_APP_ID]", $_REQUEST["fb-app-id"] ,$parametersfile );
				$parametersfile = str_replace("[FB_APP_SECRET]", $_REQUEST["fb-app-secret"] ,$parametersfile );
				$parametersfile = str_replace("[TW_CONSUMER_KEY]", $_REQUEST["tw-consumer-key"] ,$parametersfile );
				$parametersfile = str_replace("[TW_CONSUMER_SECRET]", $_REQUEST["tw-consumer-secret"] ,$parametersfile );
				$parametersfile = str_replace("[TW_TOKEN]", $_REQUEST["tw-token"] ,$parametersfile );
				$parametersfile = str_replace("[TW_TOKEN_SECRET]", $_REQUEST["tw-token-secret"] ,$parametersfile );
				$parametersfile = str_replace("[TW_BEARER_TOKEN]", $_REQUEST["tw-bearer-token"] ,$parametersfile );
				$parametersfile = str_replace("[IN_CLIENT_ID]", $_REQUEST["inst-client-id"] ,$parametersfile );

				file_put_contents('../API/parameter-parser.php', $parametersfile );

			}


		?>
		<div class="row">
			<div class="rowcontent">
				<?php
					if(!$success){
						?>
							<h2>ERROR writing social network configuration files</h2>
							<p><?php echo($errormessages); ?></p>
						<?php
					} else {
						?>
							<h2>SUCCESS: wrote social network configuration files.</h2>
							<p>press NEXT to continue.</p>
						<?php
					}
				?>
			</div>
		</div>
		<div class="row action-section">
			<div class="rowcontent">
				<a href="install-step-3.php" title="Back to social network configuration">Back to social network configuration</a>
				<?php 
					if($success){
						?>
							<a href="configuration.php" id="submit" title="Next">Next</a>
						<?php
					}
				?>
			</div>
		</div>
	</div>
</body>
</html>