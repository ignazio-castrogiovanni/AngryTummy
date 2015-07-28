<?php
session_start();
$_SESSION['loginID'] = '10206506391273655';
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "angrymemory";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed". $conn->connect_error);
}

if(!empty($_POST['check_box_foods']) && !empty($_POST['check_box_diseases'])) {
    foreach($_POST['check_box_foods'] as $checked) {
        // I have the user and the food id
        // Select FoodUSerXref.ID from FoodsUsersXref where Food.Id = ... AND Users = ...
        $sql_select_user = "Select ID from Users where LoginID ='" . $_SESSION['loginID'] . "'";
        $user_query_result = mysqli_query($conn, $sql_select_user) or die(mysql_error());
        $user = $user_query_result->fetch_assoc();

        echo '<br>' . $user['ID'] . '<br>';

        echo $sql_select_user;
        // If user experience doesn't exist, create it.
//        $sql_create_user_xp =  "INSERT IGNORE INTO
//                                `FoodsUsersExperience`(`FoodUser`, `NeutralExp`, `NegativeExp`)
//                                VALUES ('" . $food_user['ID'] . "',0,0)";
//        mysqli_query($conn, $sql_create_user_xp) or die(mysql_error());

//        if (!empty($_POST['foodXP']) && $_POST['foodXP'] == 'feelBad') {
//            echo "Set " . $checked . " as a bad experience<br>";
//            $sql_update_bad_xp =    "UPDATE FoodsUsersExperience
//                                     SET NegativeExp = NegativeExp + 1
//                                     WHERE FoodUser ='" . $food_user['ID'] . "'";
//            echo $sql_update_bad_xp;
//            mysqli_query($conn, $sql_update_bad_xp) or die(mysql_error());
//            } else
        {
            echo "Set " . $checked . " as a good experience<br>";
            // If I set a timestamp and add the same to all the TummyReactions, that could be used to identify a unique meal
            // In that case I can easily query with unique timestamp and count all the time that an even occurred in a single
            // meal. That's to avoid considering different reactions as part of different events (meals)

            // IMPORTANT
            // Set the $insert_timestamp here

            // IMPORTANT
            // if(empty($_POST['check_box_disease']))
            // Set All good disease value
            // $sql_create_user_xp =  "INSERT IGNORE INTO
            //                    `FoodsUsersExperience`(`Food`, `User`, `TummyReaction`)
            //                    VALUES ('" . $checked . "'" . $user['ID'] . "',0)";
            echo '<br/>';
            var_dump($_POST['check_box_diseases']);
            echo '<br/>';
            foreach($_POST['check_box_diseases'] as $disease) {
                echo '</br>' . $disease;
                $sql_create_user_xp =  "INSERT IGNORE INTO
                                `FoodsUsersExperience`(`Food`, `User`, `TummyReaction`)
                                VALUES ('" . $checked . "','" . $user['ID'] . "'," . $disease . "); ";

//            $sql_update_neutral_xp =    "UPDATE FoodsUsersExperience
//                                     SET NeutralExp = NeutralExp + 1
//                                     WHERE FoodUser ='" . $food_user['ID'] . "'";
            echo $sql_create_user_xp;
            mysqli_query($conn, $sql_create_user_xp) or die(mysql_error());

            // header('Location: http://localhost/home.php');
           // die();
            }

        }
    }
}

  mysqli_close($conn);
?>
