<?php

//artisopensource_net_ecomuni1
//hostingmysql162.register.it
//SI1664_td689djj
//Yuu.kIo9

$mainLat = 41.8947400;
$mainLng = 12.4839000;
$locName = 'Rome';

$fb_appID = "APP ID";
$fb_appSecret = "APP Secret";

$prefix = "";



try {
  $dbh = new PDO(
  					'mysql:host=DATABASE_HOST;dbname=DATABASE_NAME', 
  					'DATABASE_USER', 
  					'DATABASE_PASSWORD', 
      				array(PDO::ATTR_PERSISTENT => true)
      			);

  //echo "Connected\n";

} catch (Exception $e) {
  die("Unable to connect: " . $e->getMessage());
}

$citycode = "";
$cityname = "";
$cityclat = 0;
$cityclon = 0;
$cityminlat = 0;
$cityminlon = 0;
$citymaxlat = 0;
$citymaxlon = 0;

$www ="";
if(isset($_REQUEST["w"])){
	$www = $_REQUEST["w"];

	$prep = $dbh->prepare("SELECT * FROM cities WHERE code=:w");
	$prep->bindParam(':w', $www);
	
	if($prep->execute()){
		if ($row = $prep->fetch()){
			$citycode = $www;
			$cityname = $row["city"];
			$cityclat = $row["clat"];
			$cityclon = $row["clon"];
			$cityminlat = $row["minlat"];
			$cityminlon = $row["minlon"];
			$citymaxlat = $row["maxlat"];
			$citymaxlon = $row["maxlon"];
			$mainLat = $cityclat;
			$mainLng = $cityclon;
			$locName = $cityname;

		}
	}


}


?>