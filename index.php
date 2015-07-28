<?php
    @ob_start();
    session_start();

    set_include_path('/Applications/MAMP/htdocs/vendor');
    require_once("autoload.php");
    //use Facebook\Facebook;

    $fb = new Facebook\Facebook([
        'app_id' => '106813412999326',
        'app_secret' => '4d29ada88e9072cd871a4afd34d88782',
        'default_graph_version' => 'v2.4',
        ]);

    $helper = $fb->getRedirectLoginHelper();
    $permissions = ['email', 'user_likes']; // optional
    $loginUrl = $helper->getLoginUrl('http://localhost/login_callback.php', $permissions);


echo
'<head>

    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/font-awesome.css" rel="stylesheet">
    <link href="assets/css/docs.css" rel="stylesheet" >
    <link rel="stylesheet" type="text/css" href="bootstrap-social.css">
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="container-fluid">
    <div class="row">
        <div class="col-sm-8"><br></div>
        <div class="col-sm-8"><br></div>
    <div class="col-sm-8">
   <a class="btn btn-block btn-social btn-facebook" href="' . $loginUrl . '">
  <i class="fa fa-facebook"></i>
  Sign in with Facebook
            </a>

        </div>
        </div>
        </div>
    ';

if (isset($_SESSION['facebook_access_token']) && !is_null($_SESSION['facebook_access_token'])) {

    header("Location: http://localhost/home.php");
    die();
      // Sets the default fallback access token so we don't have to pass it to each request
$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);

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

echo 'Logged in as ' . $userNode->getName() . '<br>';
echo 'Id is ' . $userNode->getId() . '<br>';

  // Now you can redirect to another page and use the
  // access token from $_SESSION['facebook_access_token']
} elseif ($helper->getError()) {
  // The user denied the request
  exit;
}
?>
<?php
$servername = "localhost";
$username = "root";
$password = "root";

// Create connection
$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
	die("Connection failed". $conn->connect_error);
}


//if(true) {
//	echo '<h1>Oh yeah!</h1>
//	<h2>We made it!</h2>
//	';
////echo '
////<form action="insertFood.php">
////	Food name: <input type=""text" name="foodName">
////	<input type="submit" value="Submit">
////</form>
////
////';
//}
?>

</body>
