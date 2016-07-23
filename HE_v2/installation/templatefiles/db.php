<?php

require_once("parameter-parser.php");

try {
  $dbh = new PDO(
  					'mysql:host=[HE_DB_HOST];dbname=[HE_DB_NAME];charset=utf8', 
  					'[HE_DB_USER]', 
  					'[HE_DB_PASSWORD]', 
      				array(PDO::ATTR_PERSISTENT => true)
      			);

  //echo "Connected\n";

} catch (Exception $e) {
  die("Unable to connect: " . $e->getMessage());
}


$research_code = "";
$research_name = "";
$research_clat = 0;
$research_clon = 0;
$research_minlat = 0;
$research_minlon = 0;
$research_maxlat = 0;
$research_maxlon = 0;

if(isset($parameters["w"])){
	$prep = $dbh->prepare("SELECT * FROM research WHERE label=:w");
	$prep->bindParam(':w', $parameters["w"]);

	if($prep->execute()){
		if ($row = $prep->fetch()){
			$research_code = $row["label"];
			$research_name = $row["name"];
			$research_clat = $row["clat"];
			$research_clon = $row["clon"];
			$research_minlat = $row["minlat"];
			$research_minlon = $row["minlon"];
			$research_maxlat = $row["maxlat"];
			$research_maxlon = $row["maxlon"];
			$mainLat = $research_clat;
			$mainLng = $research_clon;
			$locName = $research_name;

		}
	}

}

require_once( "prepared_statements.php" );

?>