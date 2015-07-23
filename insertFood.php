<head>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="main.css">
</head>

<body>
<!-- <img src ="mela.jpg"> -->

<?php
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "angrytummy";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
	   die("Connection failed". $conn->connect_error);
    }

    if(isset($_GET['foodName'])) {
        $foodName = $conn->real_escape_string($_GET['foodName']);
        $datetime = date('Y-m-d H:i:s');

        $sql = "INSERT INTO `angrytummy`.`Foods` (`Name`, `NeutralEffect`, `NegativeEffect`, `Date`) VALUES ('".$foodName."', 0, 0,             '".$datetime."')";

        if($conn->query($sql) === TRUE) {
            echo "New record correctly created";
        } else {
            echo "Error: " .$sql ."<br>" . mysqli_error($conn);
        }
    }

       $sql = "SELECT * FROM `angrytummy`.`Foods`";

$query_resource = mysqli_query($conn, $sql) or die(mysql_error());

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
   <a class="btn btn-block btn-social btn-facebook" href="logout.php">
  <i class="fa fa-facebook"></i>
  Logout
            </a>

        </div>
        </div>
        </div>
    ';

echo '<br>';
echo '<div id="page-wrap">';
echo '<h1>What did you eat?</h1>';
echo '<form>';
while ( $food = $query_resource->fetch_assoc() ) {
    echo '<div>';
    echo '<input type="checkbox" id = "' . $food["Name"] .'" name="check_box[]" value="'. $food["Name"] . '" /> <label for="' . $food["Name"] .'">' . $food["Name"] . '</label> <br/>';
    echo '</div>';
}
echo '<input type="submit" value = "Submit" />';
echo '</form>';
echo '</div>';
mysqli_close($conn);
?>

    </body>
