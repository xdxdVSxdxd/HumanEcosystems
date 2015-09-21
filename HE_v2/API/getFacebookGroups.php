<?php
session_start();

function my_url(){
 
    $url = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
 
    return $url;
}

require_once('db.php');
require_once __DIR__ . '/facebook-sdk-v5/autoload.php';


$source = "FB";


$fb = new Facebook\Facebook([
  'app_id' => $fb_app_id,
  'app_secret' => $fb_ap_secret,
  'default_graph_version' => 'v2.2',
  ]);


$helper = $fb->getRedirectLoginHelper();

$permissions = [];

$url = my_url();

$url = str_replace("getFacebookGroups.php", "getFacebookGroupsCallback.php", $url);

$_SERVER['SERVER_NAME'] . dirname(__FILE__) . "/getFacebookGroupsCallback.php";

$loginUrl = $helper->getLoginUrl( $url , $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';



?>