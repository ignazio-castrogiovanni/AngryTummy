<?php
session_start();
$local = FALSE;
$DEBUG = FALSE;

$servername = "localhost";
if ($local) {
    $username = "root";
    $password = "root";
} else {
    $username = "ignazio1_root";
    $password = "19Baltic";
}
// Remote

$dbname = "ignazio1_angrymemory";

if($DEBUG) {
    var_dump($_POST);
}
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed". $conn->connect_error);
}

if(!empty($_POST['check_box_foods']) && !empty($_POST['check_box_diseases'])) {
    for($i = 0; $i < count($_POST['check_box_foods']); $i++) {
        if($DEBUG) {
            echo '</br>' . $_POST['check_box_foods'][$i];
        }
        // I have the user and the food id
        // Select FoodUSerXref.ID from FoodsUsersXref where Food.Id = ... AND Users = ...
        $sql_select_user = "Select ID from Users where LoginID ='" . $_SESSION['loginID'] . "'";
        $user_query_result = mysqli_query($conn, $sql_select_user) or die(mysql_error());
        $user = $user_query_result->fetch_assoc();

            for($j = 0; $j < count($_POST['check_box_diseases']); $j++) {
                if($DEBUG) {
                    echo '</br>' . $_POST['check_box_diseases'][$j];
                }
                $sql_create_user_xp =  "INSERT IGNORE INTO
                                `FoodsUsersExperience`(`Food`, `User`, `Date`, `TummyReaction`)
                                VALUES ('" . $_POST['check_box_foods'][$i] . "','" . $user['ID'] .
                    "','" . $_POST['date'] . "'," . $_POST['check_box_diseases'][$j] . "); ";

            mysqli_query($conn, $sql_create_user_xp) or die(mysql_error());
            }
    }
            ob_start();
                if ($local) {
                   header('Location: http://localhost/home.php');
                } else {
                    header('Location: http://ignazio-castrogiovanni.com/angrytummy/home.php');
                }
            ob_end_flush();
            die();
            }

  mysqli_close($conn);
?>
