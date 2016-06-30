<?php

	//require_once("db.php");
	/*
	require_once ('codebird.php');

	\Codebird\Codebird::setConsumerKey($_REQUEST["tw-consumer-key"], $_REQUEST["tw-consumer-secret"]);

	$cb = \Codebird\Codebird::getInstance();

	$cb->setToken($_REQUEST["tw-token"], $_REQUEST["tw-token-secret"]);
 
	$reply = $cb->oauth2_token();
	$bearer_token = $reply->access_token;

	echo("<h1>Your Bearer Token</h1><br />");
	echo($bearer_token);
	*/


	$key = $_REQUEST["tw-consumer-key"];
	$secret = $_REQUEST["tw-consumer-secret"];
	//$api_endpoint = 'https://api.twitter.com/1.1/users/show.json?screen_name=marcosfernandez'; // endpoint must support "Application-only authentication"

	// request token
	$basic_credentials = base64_encode($key.':'.$secret);
	$tk = curl_init('https://api.twitter.com/oauth2/token');
	curl_setopt($tk, CURLOPT_HTTPHEADER, array('Authorization: Basic '.$basic_credentials, 'Content-Type: application/x-www-form-urlencoded;charset=UTF-8'));
	curl_setopt($tk, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
	curl_setopt($tk, CURLOPT_RETURNTRANSFER, true);
	$token = json_decode(curl_exec($tk));
	curl_close($tk);

	echo("<h1>Your Bearer Token</h1><br />");
	echo($token->access_token);


?>