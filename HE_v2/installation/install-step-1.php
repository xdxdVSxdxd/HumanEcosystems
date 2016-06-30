<html>
<head>
<title>Human Ecosystems Installation</title>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="../visualizations/js/jquery.js"></script>
<script src="js/install-step-1.js"></script>
</head>
<body>
	<div class="page">
		<div class="header">
			<h1>Human Ecosystems : Installation, Step 1</h1>
		</div>
		<div class="row">
			<div class="rowcontent">
				<h2>Database Configuration</h2>
				<p>Insert the database parameters below, then press NEXT.</p>
			</div>
		</div>
		<?php 
			if(file_exists("../API/db.php")){
				?>
				<div class="row">
					<div class="alert">
						BE CAREFUL! traces of a previous installation/configuration have been located: by proceeding you will erase all your previous configurations, which may lead to unexpected results.
					</div>
				</div>
				<?php
			} 
		?>
		<div class="row">
			<div class="breadcrumbs">
				<a href="index.php" title="installation home">Installation Home</a>
				>
				<a href="install-step-1.php" title="Installation step 1: database">Installation step 1: database</a>
			</div>
		</div>
		<div class="row">
			<div class="rowcontent">
				<form name="database-data" id="database-data" method="POST" action="install-step-2.php">
					<div class="inputbox">
						<div class="label">Database Name</div>
						<div class="input"><input type="text" name="db-name" id="db-name"></div>
						<div class="help">Insert the name of the existing DB on which you want to install HE</div>
					</div>
					<div class="inputbox">
						<div class="label">Database Host</div>
						<div class="input"><input type="text" name="db-host" id="db-host"></div>
						<div class="help">Insert the host name (or localhost, or 127.0.0.1) for the database above</div>
					</div>
					<div class="inputbox">
						<div class="label">Database User</div>
						<div class="input"><input type="text" name="db-user" id="db-user"></div>
						<div class="help">Insert the username of a user on the above database who has full privileges</div>
					</div>
					<div class="inputbox">
						<div class="label">Database Password</div>
						<div class="input"><input type="password" name="db-pwd" id="db-pwd"></div>
						<div class="help">Insert the password for the database user above</div>
					</div>
				</form>
			</div>
		</div>
		<div class="row action-section">
			<div class="rowcontent">
				<a href="index.php" title="Back to install main page">Back to installation main page</a>
				<a href="#" id="submit" title="Next">Next</a>
			</div>
		</div>
	</div>
</body>
</html>