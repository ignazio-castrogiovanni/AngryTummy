<?php
session_start();
$local = FALSE;
$DEBUG = FALSE;

echo '  <head>
            <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
            <link href="assets/css/bootstrap.css" rel="stylesheet">
            <link href="assets/css/font-awesome.css" rel="stylesheet">
            <link href="assets/css/docs.css" rel="stylesheet" >
            <link rel="stylesheet" type="text/css" href="bootstrap-social.css">
            <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css" />
            <link rel="stylesheet" href="bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
            <link rel="stylesheet" href="main.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <script type="text/javascript" src="bower_components/jquery/jquery.min.js"></script>
            <script type="text/javascript" src="bower_components/moment/min/moment.min.js"></script>
            <script type="text/javascript" src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
            <script type="text/javascript" src="bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
            <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
            <link rel="stylesheet" type="text/css" href="main.css">';


if($local) {

    // Temp for local user - comment for remote
    $_SESSION['loginID'] = '10206506391273655';
    $_SESSION['username'] = 'TempUser';

// Local
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "ignazio1_angrymemory";
} else {
    $servername = "localhost";
    $username = "ignazio1_root";
    $password = "19Baltic";
    $dbname = "ignazio1_angrymemory";
}

$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error) {
    die("DB connection error: " . $conn->connect_error);
}

// Get all the different dates.
$sql_distinct_dates = "SELECT DISTINCT Date FROM FoodsUsersExperience WHERE User = " . $_SESSION['userID'];
$sql_result_dates = mysqli_query($conn, $sql_distinct_dates) or die("Error in querying distinct Food Experience Dates");
$dates = array();

while($new_date = $sql_result_dates->fetch_array()) {
    $dates[] = $new_date['Date'];
}

echo '<div id="page-wrap">';
echo '<a href="http://ignazio-castrogiovanni.com/angrytummy/index.php"
        class = "btn btn-default pull-right"
        role = "button" >Home</a>';

foreach($dates as $date) {
    echo '<div class = "well">';
    echo '<h1>' . $date . '</h1>';
    echo '<h2>Foods</h2>';

    // Foods query
    $sql_food_query = "SELECT DISTINCT Foods.Name, Date FROM FoodsUsersExperience, Foods
    WHERE User = " . $_SESSION['userID'] . " AND Foods.ID = Food AND Date = '" . $date . "'";

    if($DEBUG) {
        echo $sql_food_query;
    }

    $sql_result = mysqli_query($conn, $sql_food_query) or die();

    // Print foods
    while ($foods = $sql_result->fetch_assoc()) {
        // Food display
        echo $foods['Name'] . '<br>';
    }

    echo '<h2>Diseases</h2>';

    // Diseases query
    $sql_tummy_reactions = "SELECT DISTINCT TummyReactions.Description, Date FROM FoodsUsersExperience, TummyReactions
    WHERE User = " . $_SESSION['userID'] . " AND TummyReactions.ID = TummyReaction AND Date = '" . $date . "'";
    if($DEBUG) {
        echo $sql_tummy_reactions;
    }
    $sql_result = mysqli_query($conn, $sql_tummy_reactions) or die();

    // Print diseases
    while ($diseases = $sql_result->fetch_assoc()) {
        // Diseases display
        echo $diseases['Description']. '<br>';
    }
    echo '</div>';
}
echo '</div>';
mysqli_close($conn);
?>
