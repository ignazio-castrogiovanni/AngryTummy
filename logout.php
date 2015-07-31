<?php
    session_start();

    $indexPagePath = "http://ignazio-castrogiovanni.com/angrytummy/index.php";

    set_include_path('vendor');
    require_once("autoload.php");
    //use Facebook\Facebook;

    $fb = new Facebook\Facebook([
        'app_id' => '106813412999326',
        'app_secret' => '4d29ada88e9072cd871a4afd34d88782',
        'default_graph_version' => 'v2.4',
        ]);
    $fbToken = $_SESSION['facebook_access_token'];
    $urlFbLogout = 'https://www.facebook.com/logout.php?next=' . $indexPagePath . '&access_token=' . $fbToken;

    session_destroy();
    header("Location: " . $urlFbLogout);
    die();
?>
