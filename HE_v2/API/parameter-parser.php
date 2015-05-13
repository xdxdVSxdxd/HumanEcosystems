<?php

$parameters = array();

foreach ($_REQUEST as $key => $value) {
	$parameters[$key] = $value ;
}


$mainLat = 0;
$mainLng = 0;
$research_name = '';


$fb_app_id="[FB_APP_ID]";
$fb_ap_secret="[FB_APP_SECRET]";
$tw_consumer_key="[TW_CONSUMER_KEY]";
$tw_consumer_secret="[TW_CONSUMER_SECRET]";
$tw_token="[TW_TOKEN]";
$tw_token_secret="[TW_TOKEN_SECRET]";
$tw_bearer_token="[TW_BEARER_TOKEN]";
$in_client_id="[IN_CLIENT_ID]";

?>