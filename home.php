<?php
    session_start();
echo '  <head>
            <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
            <link rel="stylesheet" type="text/css" href="main.css">
        </head>
        <body>';


    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "angrymemory";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
	   die("Connection failed". $conn->connect_error);
    }

    // Check whether the user exists, create it if it doesn't
    $sqlQueryUser = "SELECT * FROM Users WHERE LoginID = '" . $_SESSION['loginID'] . "';";

    $query_user = mysqli_query($conn, $sqlQueryUser);
    if ($query_user->num_rows == 0) {
        echo "null value";
        // Create User.
        $sql_insert_user = "INSERT INTO `angrymemory`.`Users` (`Name`, `LoginID`) VALUES ('" . $_SESSION['username'] . "', '" . $_SESSION['loginID'] . "')";
        //$sql_insert_user = "INSERT INTO Users('Name', 'LoginID') VALUES ('" . $_SESSION['username'] . "','" . $_SESSION['loginID'] . "')";
        if($conn->query($sql_insert_user) === TRUE) {
            echo "New record correctly created";
        } else {
            echo "Error: " .$sql_insert_user ."<br>" . mysqli_error($conn);
        }

    } else {

        if(isset($_GET['foodName'])) {
            $foodName = $conn->real_escape_string($_GET['foodName']);

            // Check whether the food already exist in the db
            $sql_food_query = "SELECT * FROM `Foods` WHERE `Name` = '" . $foodName . "'";
            $query_resource = mysqli_query($conn, $sql_food_query) or die(mysql_error());
            $food = $query_resource->fetch_assoc();

            $food_id = "";
            // If it exist, extract the ID
            if ($query_resource->num_rows != 0) {
                $food_id = $food["ID"];
            } else {  // If it doesn't create the record in the 'Foods' table and get the ID
                $sql_insert_food = "INSERT INTO `angrymemory`.`Foods` (`Name`) VALUES ('".$foodName."')";
                mysqli_query($conn, $sql_insert_food) or die(mysql_error());

                $food_id = mysqli_insert_id($conn);
            }

            echo $food_id . "created";



            // Check if the Food exists in the 'UsersFoodsXref'
            $sql_food_query = "SELECT * FROM `FoodsUsersXref` WHERE `ID` = '" . $food_id . "'";
            $query_resource = mysqli_query($conn, $sql_food_query) or die(mysql_error());

            // If it doesn't, create a new food experience for the user.
            if ($query_resource->num_rows == 0) {
                 $sql_insert_foods_users_xref = "INSERT INTO `angrymemory`.`FoodsUsersXref` (`Food`, `User`) VALUES ('" . $food_id . "', '" . $_SESSION['loginID'] . "')";
        //$sql_insert_user = "INSERT INTO Users('Name', 'LoginID') VALUES ('" . $_SESSION['username'] . "','" . $_SESSION['loginID'] . "')";
        if($conn->query($sql_insert_foods_users_xref) === TRUE) {
            echo "New food users xref record correctly created";
        } else {
            echo "Error: " .$sql_insert_foods_users_xref ."<br>" . mysqli_error($conn);
        }
        }





        //if($conn->query($sql) === TRUE) {
        //echo "New record correctly created";
    //} else {
      //  echo "Error: " .$sql ."<br>" . mysqli_error($conn);
        //    }
        //}
    }
    }
    //$user = $query_resource->fetch_assoc();
    //$IDstr = $user['Name'];
    //        echo $IDstr;

    // If user doesn't exist create it

    // It it exists, check

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
echo '<form action="submit.php" method="post">';
$sql_query_user_foods = "SELECT * FROM `angrymemory`.`FoodsUsersXref`, `angrymemory`.`Foods`
WHERE `angrymemory`.`Foods`.`ID` = `angrymemory`.`FoodsUsersXref`.`Food`";

        //$sql = "SELECT * FROM `angrytummy`.`FoodsUsers`";

        $query_resource = mysqli_query($conn, $sql_query_user_foods) or die(mysql_error());

while ( $food = $query_resource->fetch_assoc() ) {
    echo "<div class = 'checkbox'>";
    echo '<input type="checkbox" id = "' . $food["Name"] .'" name="check_box_foods[]" value="'. $food["ID"] . '" /> <label for="' . $food["Name"] .'">' . $food["Name"] . '</label> <br/>';
    echo '</div>';
}
//echo "<div class = 'radio'>";
//    echo "<label><input type='radio' name='foodXP' value = 'feelGood'>I'm feeling alright</label>";
//echo "</div>";
//echo "<div class = 'radio'>";
//    echo "<label><input type='radio' name='foodXP' value = 'feelBad'>I'm feeling bad!</label>";
//echo "</div>";
//

echo '<h1>Disease</h1>';
$sql_query_user_foods = "SELECT * FROM `angrymemory`.`TummyReactions`";
$query_resource = mysqli_query($conn, $sql_query_user_foods) or die(mysql_error());

echo "<div class = 'checkbox'>";
while ( $disease = $query_resource->fetch_assoc() ) {
    echo '<div>';
    echo '<input type="checkbox" id = "' . $disease["Description"] .'" name="check_box_diseases[]" value="'. $disease["ID"] . '" /> <label for="' . $disease["Description"] .'">' . $disease["Description"] . '</label> <br/>';
    echo '</div>';
}

echo '</div>';

echo '<input type="submit" value = "Submit" />';
echo '</form>';
echo '</div>';

mysqli_close($conn);
?>

    </body>
