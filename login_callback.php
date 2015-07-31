<?php
session_start();

set_include_path('vendor');
require_once("autoload.php");

$fb = new Facebook\Facebook([
        'app_id' => '106813412999326',
        'app_secret' => '4d29ada88e9072cd871a4afd34d88782',
        'default_graph_version' => 'v2.4',
        ]);

$helper = $fb->getRedirectLoginHelper();
try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (isset($accessToken)) {
  // Logged in!
  $_SESSION['facebook_access_token'] = (string) $accessToken;

  // Sets the default fallback access token so we don't have to pass it to each request
$fb->setDefaultAccessToken($accessToken);

try {
  $response = $fb->get('/me');
  $userNode = $response->getGraphUser();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

    header('Location: http://ignazio-castrogiovanni.com/angrytummy/index.php');
    $_SESSION['loginID'] = (string) $userNode->getId();
    $_SESSION['username'] = (string) $userNode->getName();
    die();

    echo 'Logged in as ' . $userNode->getName() . '<br>';
    echo 'Id is ' . $userNode->getId() . '<br>';



  // Now you can redirect to another page and use the
  // access token from $_SESSION['facebook_access_token']
} elseif ($helper->getError()) {
  // The user denied the request
  exit;
}
?>
