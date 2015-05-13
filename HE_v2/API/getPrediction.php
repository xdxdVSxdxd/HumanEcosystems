<?php

$research = $_REQUEST["w"];

$urls = array();

$urls[] = "http://human-ecosystems.com/HE/ecosystem/pattern_place_mono.php";
$urls[] = "http://human-ecosystems.com/HE/ecosystem/pattern_place_mono.php";
$urls[] = "http://human-ecosystems.com/HE/ecosystem/pattern_place_mono.php";
$urls[] = "http://human-ecosystems.com/HE/ecosystem/pattern_place_multi.php";
$urls[] = "http://human-ecosystems.com/HE/ecosystem/pattern_word_mono.php";
$urls[] = "http://human-ecosystems.com/HE/ecosystem/pattern_word_mono.php";
$urls[] = "http://human-ecosystems.com/HE/ecosystem/pattern_word_mono.php";
$urls[] = "http://human-ecosystems.com/HE/ecosystem/pattern_graphic.php";

$idx = mt_rand(0,(count($urls)-1));

$getu = $urls[$idx] . "?w=" . $research;

$result = file_get_contents($getu);

echo ($result);

?>