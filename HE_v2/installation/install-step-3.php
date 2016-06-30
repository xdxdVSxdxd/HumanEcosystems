<html>
<head>
<title>Human Ecosystems Installation</title>
<link rel="stylesheet" type="text/css" href="style.css">
<script src="../visualizations/js/jquery.js"></script>
<script src="js/install-step-3.js"></script>
</head>
<body>
	<div class="page">
		<div class="header">
			<h1>Human Ecosystems : Installation, Step 3</h1>
		</div>
		<div class="row">
			<div class="rowcontent">
				<h2>Social Network Configuration</h2>
				<p>Insert the parameters below, then press NEXT.</p>
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
		<form name="social-data" id="social-data" method="POST" action="install-step-4.php">
			<div class="row">
				<h2>Facebook</h2>
			</div>
			<div class="row">
				<div class="rowcontent">
						<div class="inputbox">
							<div class="label">Facebook App ID</div>
							<div class="input"><input type="text" name="fb-app-id" id="fb-app-id"></div>
							<div class="help">Your Facebook App ID (<a href="https://developers.facebook.com/apps" target="_blank">look here</a>)</div>
						</div>
						<div class="inputbox">
							<div class="label">Facebook App Secret</div>
							<div class="input"><input type="text" name="fb-app-secret" id="fb-app-secret"></div>
							<div class="help">Your Facebook App Secret (<a href="https://developers.facebook.com/apps" target="_blank">look here</a>)</div>
						</div>
				</div>
			</div>
			<div class="row">
				<h2>Twitter</h2>
			</div>
			<div class="row">
				<div class="rowcontent">
						<div class="inputbox">
							<div class="label">Twitter Consumer Key</div>
							<div class="input"><input type="text" name="tw-consumer-key" id="tw-consumer-key"></div>
							<div class="help">Your Twitter Consumer Key (<a href="https://apps.twitter.com/" target="_blank">look here</a>)</div>
						</div>
						<div class="inputbox">
							<div class="label">Twitter Consumer Secret</div>
							<div class="input"><input type="text" name="tw-consumer-secret" id="tw-consumer-secret"></div>
							<div class="help">Your Twitter Consumer Secret (<a href="https://apps.twitter.com/" target="_blank">look here</a>)</div>
						</div>
						<div class="inputbox">
							<div class="label">Twitter Token</div>
							<div class="input"><input type="text" name="tw-token" id="tw-token"></div>
							<div class="help">Your Twitter Token (<a href="https://apps.twitter.com/" target="_blank">look here</a> in each App, in "manage keys and access tokens")</div>
						</div>
						<div class="inputbox">
							<div class="label">Twitter Token Secret</div>
							<div class="input"><input type="text" name="tw-token-secret" id="tw-token-secret"></div>
							<div class="help">Your Twitter Token Secret (<a href="https://apps.twitter.com/" target="_blank">look here</a> in each App, in "manage keys and access tokens")</div>
						</div>
						<div class="inputbox">
							<div class="label">Twitter Bearer Token</div>
							<div class="input"><input type="text" name="tw-bearer-token" id="tw-bearer-token"></div>
							<div class="help">Your Twitter Bearer Token (<span id="bearer-holder"></span>)</div>
						</div>

				</div>
			</div>
			<div class="row">
				<h2>Instagram</h2>
			</div>
			<div class="row">
				<div class="rowcontent">
						<div class="inputbox">
							<div class="label">Instagram Client ID</div>
							<div class="input"><input type="text" name="inst-client-id" id="inst-client-id"></div>
							<div class="help">Your Instagram Client ID (<a href="https://www.instagram.com/developer/authentication/" target="_blank">look here</a>)</div>
						</div>
				</div>
			</div>
		</form>
		<div class="row action-section">
			<div class="rowcontent">
				<a href="install-step-1.php" title="Back to database install">Back to database install</a>
				<a href="#" id="submit" title="Next">Next</a>
			</div>
		</div>
	</div>
</body>
</html>