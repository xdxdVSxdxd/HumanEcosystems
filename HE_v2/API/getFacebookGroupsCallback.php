<?php
session_start();

require_once('db.php');
require_once __DIR__ . '/facebook-sdk-v5/autoload.php';

$fp = fopen('facebookOutput.txt', 'w');

$source = "FB";


$fb = new Facebook\Facebook([
  'app_id' => $fb_app_id,
  'app_secret' => $fb_ap_secret,
  'default_graph_version' => 'v2.2',
  ]);


$helper = $fb->getRedirectLoginHelper();

try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
	fwrite($fp, 'Graph returned an error: ' . $e->getMessage());
  	//echo 'Graph returned an error: ' . $e->getMessage();
  	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  	fwrite($fp, 'Facebook SDK returned an error: ' . $e->getMessage() );
  	//echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (! isset($accessToken)) {
  if ($helper->getError()) {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } else {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}

// Logged in
fwrite($fp,'<h3>Access Token</h3>');
//var_dump($accessToken->getValue());
fwrite($fp,var_dump($accessToken->getValue()));

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
fwrite($fp,'<h3>Metadata</h3>');
//var_dump($tokenMetadata);
fwrite($fp,var_dump($tokenMetadata));

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId($config['app_id']);
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
  // Exchanges a short-lived access token for a long-lived one
  try {
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
  } catch (Facebook\Exceptions\FacebookSDKException $e) {
    fwrite($fp,"<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n");
    exit;
  }

  fwrite($fp,'<h3>Long-lived</h3>');
  fwrite($fp,var_dump($accessToken->getValue()));
  //var_dump($accessToken->getValue());
}

$_SESSION['fb_access_token'] = (string) $accessToken;

// User is logged in with a long-lived access token.
// You can redirect them to a members-only page.
//header('Location: https://example.com/members.php');

fclose($fp);

?>