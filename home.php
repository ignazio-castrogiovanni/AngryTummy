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
            <script>
                $(document).ready(function(){

                    $("input[class^=\"class\"]").click(function() {
                        var $this = $(this);
                        if ($this.is(".class0")) {
                            if($(".class0:checked").length > 0) {
                                $(".class1").prop({ disabled: true, checked: false });
                            } else {
                                $(".class1").prop("disabled", false );
                            }
                        }
                    });
                });
            </script>
</head>';
$local = FALSE;

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

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
	   die("Connection failed". $conn->connect_error);
    }


    // Check whether the user exists, create it if it doesn't
    $sqlQueryUser = "SELECT * FROM Users WHERE LoginID = '" . $_SESSION['loginID'] . "';";

    $query_user = mysqli_query($conn, $sqlQueryUser);
    if ($query_user->num_rows == 0) {
       // echo "null value";
        // Create User.
        $sql_insert_user = "INSERT INTO `Users` (`Name`, `LoginID`) VALUES ('" . $_SESSION['username'] . "', '" . $_SESSION['loginID'] . "')";

        if($conn->query($sql_insert_user) === TRUE) {
         //   echo "New record correctly created";
        } else {
           // echo "Error: " .$sql_insert_user ."<br>" . mysqli_error($conn);
        }

    } else {

        // Cache the user ID
        $sqlUserIDQuery = "SELECT ID FROM Users WHERE LoginID = '" . $_SESSION['loginID'] . "';";
        $query_user = mysqli_query($conn, $sqlQueryUser);
        $user = $query_user->fetch_assoc();
        $_SESSION['userID'] = $user['ID'];

        if(isset($_POST['foodName'])) {
            $foodName = $conn->real_escape_string($_POST['foodName']);

            // Check whether the food already exist in the db
            $sql_food_query = "SELECT * FROM `Foods` WHERE `Name` = '" . $foodName . "'";
            $query_resource = mysqli_query($conn, $sql_food_query) or die(mysql_error());
            $food = $query_resource->fetch_assoc();

            $food_id = "";
            // If it exist, extract the ID
            if ($query_resource->num_rows != 0) {
                $food_id = $food["ID"];
            } else {  // If it doesn't create the record in the 'Foods' table and get the ID
                $sql_insert_food = "INSERT INTO `Foods` (`Name`) VALUES ('".$foodName."')";
                mysqli_query($conn, $sql_insert_food) or die(mysql_error());

                $food_id = mysqli_insert_id($conn);
            }

         //   echo $food_id . "created";



            // Check if the Food exists in the 'UsersFoodsXref'
            $sql_food_query = "SELECT * FROM `FoodsUsersXref` WHERE `ID` = '" . $food_id . "'";
            $query_resource = mysqli_query($conn, $sql_food_query) or die(mysql_error());

            // If it doesn't, create a new food experience for the user.
            if ($query_resource->num_rows == 0) {
                 $sql_insert_foods_users_xref = "INSERT INTO `FoodsUsersXref` (`Food`, `User`) VALUES ('" . $food_id . "', '" . $_SESSION['loginID'] . "')";

        if($conn->query($sql_insert_foods_users_xref) === TRUE) {
        //    echo "New food users xref record correctly created";
        } else {
        //    echo "Error: " .$sql_insert_foods_users_xref ."<br>" . mysqli_error($conn);
        }
        }



    }
    }


echo
'<body>
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

echo '<form action="submit.php" method="post">';
echo '<h1>Pick up a date</h1>';

echo '<div class="container">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name = "date" class="form-control" id="datetimepicker4" placeholder="Pick up a date"/>
                </div>
                <script type="text/javascript">
                    $(function () {
                    $("#datetimepicker4").datetimepicker({
                    format: "YYYY-MM-DD HH:MM:SS",
                    sideBySide: true});
                    });
                </script>
            </div>
        </div>';

echo '<h1>What did you eat?</h1>';
$sql_query_user_foods = "SELECT * FROM `FoodsUsersXref`, `Foods`
WHERE `Foods`.`ID` = `FoodsUsersXref`.`Food` AND `User` = " . $_SESSION['loginID'];

        //$sql = "SELECT * FROM `angrytummy`.`FoodsUsers`";

        $query_resource = mysqli_query($conn, $sql_query_user_foods) or die(mysql_error());

while ( $food = $query_resource->fetch_assoc() ) {
    echo "<div class = 'checkbox'>";
    echo '<input type="checkbox" id = "' . $food["Name"] .'" name="check_box_foods[]" value="'. $food["ID"] . '" /> <label for="' . $food["Name"] .'">' . $food["Name"] . '</label> <br/>';
    echo '</div>';
}

echo '<div class="container">
        <div class="row">
            <div>
                <input id = "addFood" name="foodName" type="text" class="form-control" placeholder="Insert your own food and press enter">
                <button id = "btnAddFood" type="submit" class="btn btn-default" formaction="home.php">Add</button>
            </div>

        </div>
      </div>';
// Script to enable adding food on enter pressed
echo '<script>
    document.getElementById("btnAddFood").style.visibility = "hidden";
    $("addFood").keyup(function(event) {
    if(event.keyCode == 13) {
        $("btnAddFood").click();
    }
});
    </script>';

echo '<h1>What did you get?</h1>';

echo '<p>[...] There are many types of chronic disorders which affect the stomach. However, since the symptoms are localized to this organ, the typical symptoms of stomach problems include <strong>nausea</strong>, <strong>vomiting</strong>, <strong>bloating</strong>, <strong>cramps</strong>, <strong>diarrhea</strong> and <strong>pain</strong>. [Wikipedia]</p>';
$sql_query_user_foods = "SELECT * FROM `TummyReactions`";
$query_resource = mysqli_query($conn, $sql_query_user_foods) or die(mysql_error());

echo "<div class = 'checkbox'>";
while ( $disease = $query_resource->fetch_assoc() ) {
    echo '<div>';
    echo '<input class = "' . $disease["Class"] . '" type="checkbox" id = "' . $disease["Description"] .'" name="check_box_diseases[]" value="'. $disease["ID"] . '" /> <label for="' . $disease["Description"] .'">' . $disease["Description"] . '</label> <br/>';
    echo '</div>';
}

echo '</div>';

echo '<input  class = "btn btn-primary pull-left" type="submit" value = "Submit" />';
if ($local) {
    echo '<a href="http://localhost/summary.php" class = "btn btn-default pull-right" role = "button" >Summary</a>';
} else {
    echo '<a href="http://ignazio-castrogiovanni.com/angrytummy/summary.php" class = "btn btn-default pull-right" role = "button" >Summary</a>';
}

echo '</form>';
echo '</div>';


mysqli_close($conn);
?>

    </body>
