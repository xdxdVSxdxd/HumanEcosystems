<html>
	<head>
		<meta name="viewport" content="width=device-width" />
		<title>Human Ecosystems tools</title>
		<link href='http://fonts.googleapis.com/css?family=Roboto:900,900italic,500,400italic,100,300,100italic,300italic,400' rel='stylesheet' type='text/css'>
		<script src="jquery-2.1.3.min.js"></script>
		<link href="index.css" rel="stylesheet">
	</head>
	<body>
		<div class="section group">
			<div class="padded">
				<h1>Human Ecosystems</h1>
				<h2>Tools - Browse</h1>
			</div>
		</div>
<?php

require_once('../../API/db.php');

$word = "";
if(isset($_REQUEST["word"])){
	$word = $_REQUEST["word"];
}

$emotion = "";
if(isset($_REQUEST["emotion"])){
	$emotion = $_REQUEST["emotion"];
}


?>
		<div class="section group">
			<div class="padded">
				<div class="col span_1_of_4">Project: <?php echo($citycode); ?></div>
				<div class="col span_1_of_4">Topic: <?php echo($word); ?></div>
				<div class="col span_1_of_4">Emotion: <?php echo($emotion); ?></div>
				<div class="col span_1_of_4"></div>
			</div>
		</div>


<?php
		$q1 = "SELECT c.nick as nick, c.link as link, c.t as t, c.txt as txt, c.source as source, c. language as language FROM content c, emotions e, emotions_content ec, words w, content_to_class cc WHERE c.research='" . $research_code . "' AND ec.id_content=c.id AND cc.id_content=c.id AND e.label='" . $emotion . "' AND ec.id_emotion=e.id AND  w.word='" . $word . "' AND  cc.id_class=w.id_class ORDER by c.t DESC";

		$r1 = $dbh->query($q1);
		if($r1){
			foreach ( $r1 as $row1) {

				?>
				<div class="section group">
					<div class="padded">
						<div class="col span_1_of_4">
							<span class="boldtext large mrighttext"><?php echo($row1["nick"]); ?></span>
						</div>
						<div class="col span_1_of_4">
							<span class="superlighttext mrighttext"><?php echo($row1["t"]); ?></span>
						</div>
						<div class="col span_1_of_4">
							<span class="normaltext mrighttext"><?php echo($row1["txt"]); ?></span>
						</div>
						<div class="col span_1_of_4">
							<span class="superlighttext mrighttext">[<?php echo($row1["source"]); ?>,<?php echo($row1["language"]); ?>]</span>
							<span class="boldtext large mrighttext"><a href="<?php echo($row1["link"]); ?>" target="_blank" class='browselink'>[ >> ]</a></span>
						</div>
					</div>
				</div>
				<?php
				
			}
			$r1->closeCursor();
		}

?>
			
	</body>
</html>