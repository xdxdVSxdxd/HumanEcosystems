<html>
<head>
<title>Human Ecosystems Installation</title>
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div class="page">
		<div class="header">
			<h1>Human Ecosystems : install/configure</h1>
		</div>
		<div class="row">
			<div class="rowcontent">
				<p>Use the following links to install and configure your Human Ecosystems instance</p>
			</div>
		</div>
		<div class="row">
			<div class="rowcontent">
				<ul>
					<li>
						<a href="install-step-1.php" title="Start Installation">Start Installation</a>
					</li>
					<li>
						<a href="configuration.php" title="Configuration">Configuration</a>
					</li>
					<li>
						<a href="cronjobs.php" title="Configuration">Set up CRON jobs</a>
					</li>
					<li>
						<a href="../visualizations" title="Configuration">Visualizations</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="rowcontent">
				<p>Strongly take in consideration protecting this folder on your web server. If you leave it open, it will be possible for anyone to reconfigure (read: erase) your whole Human Ecosystem configuration and reset all the data you have harvested so far.</p>
				<p>For example, it is possible to upload a <em>.htaccess</em> file in the <em>installation</em> folder on your web server, right in the folder in which you copied the Human Ecosystems file, to password protect it.</p>
				<p>An example <em>.htaccess</em> file can be seen here below</p>
				<pre>
					AuthName "Human Ecosystems Secure Area"
					AuthType Basic
					AuthUserFile /path/to/your/directory/.htpasswd
					require valid-user
				</pre>
				<p>As you can see, the script points to an <em>.htpasswd</em> file, somewhere on your server (possibly somewhere safe, out of the web space. This file contains the passwords which allow users into your protected space. The content in this file comes in the format of a series of lines like these:</p>
				<pre>
					username:encryptedpassword
				</pre>
				<p>To create these files, you can use the <em>htpasswd</em> command from your unix shell, for example like this:</p>
				<pre>
					htpasswd -c .htpasswd your-user-name
				</pre>
				<p>This will prompt you for a password for that user. The resulting <em>.htpasswd</em> file is created in your current directory, and then in can be moved to the folder you indicated in the <em>.htaccess</em> file.</p>
				<p>Remember to protect your files (especially your important and security related ones, like these) also using the file system security features, for example, by setting the correct read/write/execute properties for these files (for example using the 644 mode, allowing you to read and write, but other users only to read). You can do this, for example on Unix, through this command:</p>
				<pre>chmod 644 .htpasswd</pre>
				<p>Also remember to remove the files contained in the <em>database-schema</em> folder on your Human Ecosystems installation: these are the files containing the database structure, and you wouldn't want them to be accessible everywhere.</p>
				<p><strong>Don't be a fool!</strong> If you are not a security expert, seek the knowledge of someone who knows how to do this job: your data is in peril!</p>
			</div>
		</div>
	</div>
</body>
</html>