<?php
    @ob_start();
    session_start();

    set_include_path('/Applications/MAMP/htdocs/vendor');
    define('FACEBOOK_SDK_V4_SRC_DIR','/Applications/MAMP/htdocs/vendor/');
    require_once("autoload.php");
    //use Facebook\Facebook;

    $fb = new Facebook\Facebook([
        'app_id' => '106813412999326',
        'app_secret' => '4d29ada88e9072cd871a4afd34d88782',
        'default_graph_version' => 'v2.4',
        ]);

//    try {
//      // Get the Facebook\GraphNodes\GraphUser object for the current user.
//      // If you provided a 'default_access_token', the '{access-token}' is optional.
//      $response = $fb->get('/me', '{access-token}');
//    } catch(Facebook\Exceptions\FacebookResponseException $e) {
//      // When Graph returns an error
//      echo 'Graph returned an error: ' . $e->getMessage();
//      exit;
//    } catch(Facebook\Exceptions\FacebookSDKException $e) {
//      // When validation fails or other local issues
//      echo 'Facebook SDK returned an error: ' . $e->getMessage();
//      exit;
//    }
//
//    $me = $response->getGraphUser();
//    echo 'Logged in as ' . $me->getName();

    $helper = $fb->getRedirectLoginHelper();
    $permissions = ['email', 'user_likes']; // optional
    $loginUrl = $helper->getLoginUrl('http://localhost/login_callback.php', $permissions);

    echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
?>
