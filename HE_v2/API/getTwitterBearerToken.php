<?php

	require_once("db.php");
	require_once ('codebird.php');

	\Codebird\Codebird::setConsumerKey($tw_consumer_key, $tw_consumer_secret);

	$cb = \Codebird\Codebird::getInstance();

	$cb->setToken($tw_token, $tw_token_secret);
 
	$reply = $cb->oauth2_token();
	$bearer_token = $reply->access_token;

	echo($bearer_token);

?>