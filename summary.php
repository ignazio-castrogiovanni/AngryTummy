<?php
session_start();
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

    $servername = "localhost";
    $username = "ignazio1_root";
    $password = "19Baltic";
    $dbname = "ignazio1_angrymemory";

$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error) {
    die("DB connection error: " . $conn->connect_error);
}

// IMPORTANT - Try SELECT UNIQUE in different flavours to display the list of food for each timestamp and the list of diseases for each timestamp (meal)

//Temporary query
// SELECT Foods.Name FROM FoodsUsersExperience, Foods WHERE User = 6 AND Foods.ID = Food;
// SELECT TummyReactions.Description FROM FoodsUsersExperience, TummyReactions WHERE User = 6 AND TummyReactions.ID = TummyReaction;


// SELECT all distinct dates of a user.
// For each date display Food and diseases.
$sql_distinct_dates = "SELECT DISTINCT Date FROM FoodsUsersExperience WHERE User = " . $_SESSION['userID'];
$sql_result_dates = mysqli_query($conn, $sql_distinct_dates) or die();
$dates = array();

while($new_date = $sql_result_dates->fetch_array()) {
    $dates[] = $new_date['Date'];
}
echo '<div id="page-wrap">';
echo '<a href="http://ignazio-castrogiovanni.com/angrytummy/index.php" class = "btn btn-default pull-right" role = "button" >Home</a>';

foreach($dates as $date) {
    //echo $dates[$i];
    //echo $dates[$i];echo $dates[$i];
    echo '<div class = "well">';
    echo '<h1>' . $date . '</h1>';
    echo '<h2>Foods</h2>';

    // Foods query
    $sql = "SELECT DISTINCT Foods.Name, Date FROM FoodsUsersExperience, Foods
    WHERE User = " . $_SESSION['userID'] . " AND Foods.ID = Food AND Date = '" . $date . "'";
    $sql_result = mysqli_query($conn, $sql) or die();

    // Print foods
    while ($foods = $sql_result->fetch_assoc()) {
        // Food display
        echo $foods['Name'] . '<br>';
    }

    echo '<h2>Diseases</h2>';

    // Diseases query
    $sql = "SELECT DISTINCT TummyReactions.Description, Date FROM FoodsUsersExperience, TummyReactions
    WHERE User = " . $_SESSION['userID'] . " AND TummyReactions.ID = TummyReaction AND Date = '" . $date . "'";
    $sql_result = mysqli_query($conn, $sql) or die();

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
