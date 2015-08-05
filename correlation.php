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
</head>';
echo '<body>';

echo '<div id="page-wrap">';
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

$conn =  new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error) {
    die("DB connection error: " . connect_error);
}

// Get all the tummy reactions
$sql_query_tummy_reactions = "SELECT * FROM TummyReactions";
$result_tummy_reactions = mysqli_query($conn, $sql_query_tummy_reactions) or die("Error in querying tummy reactions");
$tummy_reactions_data_name = array();
$tummy_reactions_data_id = array();


while($tummy_reaction = $result_tummy_reactions->fetch_array()) {
    $tummy_reactions_data_description[] = $tummy_reaction['Description'];
    $tummy_reactions_data_id[] = $tummy_reaction['ID'];
}

// Get all the foods from a user
// SELECT DISTINCT Name, Foods.ID FROM Foods, FoodsUsersExperience WHERE User = 8

$sql_query_foods = "SELECT DISTINCT Name, Foods.ID FROM Foods, FoodsUsersExperience WHERE User = " . $_SESSION['userID'];
$result_foods = mysqli_query($conn, $sql_query_foods) or die("Error in querying foods");
$food_data_name = array();
$food_data_id = array();

while($food = $result_foods->fetch_array()) {
    $food_data_name[] = $food['Name'];
    $food_data_id[] = $food['ID'];
}

if ($DEBUG) {
    var_dump($food_data_name);
    var_dump($food_data_id);
    var_dump($tummy_reactions_data_description);
    var_dump($tummy_reactions_data_id);
}

// Skip the All good 'disease'
for ($tummy_reactions_iter = 1; $tummy_reactions_iter < count($tummy_reactions_data_id) - 1; ++$tummy_reactions_iter) {
    echo '<h1>Stomach disease: ' . $tummy_reactions_data_description[$tummy_reactions_iter];
    for($food_iter = 0; $food_iter < count($food_data_id) - 1; ++$food_iter) {
        if ($DEBUG) {
            echo 'Food iter ' . $food_iter . '<br>';
        }
        echo '<h2>Food: ' . $food_data_name[$food_iter] . '</h2>';

        // A = Tutte le volte che HO MANGIATO quel cibo e HO AVUTO quell’effetto collaterale.
        // SELECT COUNT(*) FROM FoodsUsersExperience WHERE User = Z AND Food = Y AND TummyReaction = X
        $sql_count_food_disease = "SELECT COUNT(*) AS countxp FROM FoodsUsersExperience WHERE User = " .
            $_SESSION['userID'] . " AND Food = " .
            $food_data_id[$food_iter] . " AND TummyReaction = " .
            $tummy_reactions_data_id[$tummy_reactions_iter];

        $sql_result = mysqli_query($conn, $sql_count_food_disease) or die(mysql_error());
        $count_f_d = $sql_result->fetch_assoc();

        if ($DEBUG) {
            echo $sql_count_food_disease;
            echo '$sql_count_food_disease = ' .  $count_f_d['countxp'] . '<br>';
        }

        // B = Tutte le volte che HO MANGIATO quel cibo e NON HO AVUTO quell’effetto collaterale.
        // SELECT COUNT(*) AS countxp FROM FoodsUsersExperience WHERE User = Z AND Food = Y AND TummyReaction != X
        $sql_count_food_not_disease = "SELECT COUNT(*) AS countxp FROM FoodsUsersExperience WHERE User = " .
            $_SESSION['userID'] . " AND Food = " .
            $food_data_id[$food_iter] . " AND TummyReaction != " .
            $tummy_reactions_data_id[$tummy_reactions_iter];
        $sql_result = mysqli_query($conn, $sql_count_food_not_disease);
        $count_f_n_d = $sql_result->fetch_assoc();
        if ($DEBUG) {
            echo '$sql_count_food_not_disease = ' .  $count_f_n_d['countxp'] . '<br>';
        }

        // C = Tutte le volte che NON HO MANGIATO quel cibo e HO AVUTO  quell’effetto collaterale.
        // SELECT COUNT(*) AS countxp FROM FoodsUsersExperience WHERE User = Z AND Food != Y AND TummyReaction = X
        $sql_count_not_food_disease = "SELECT COUNT(*) AS countxp FROM FoodsUsersExperience WHERE User = " .
            $_SESSION['userID'] . " AND Food != " .
            $food_data_id[$food_iter] . " AND TummyReaction = " .
            $tummy_reactions_data_id[$tummy_reactions_iter];
        $sql_result = mysqli_query($conn, $sql_count_not_food_disease);
        $count_n_f_d = $sql_result->fetch_assoc();
        if ($DEBUG) {
            echo '$sql_count_not_food_disease = ' .  $count_n_f_d['countxp'] . '<br>';
        }

        // D = Tutte le volte che NON HO MANGIATO quel cibo e NON HO AVUTO quell’effetto collaterale.
        // SELECT COUNT(*) AS countxp FROM FoodsUsersExperience WHERE User = Z AND Food != Y AND TummyReaction != X
        $sql_count_not_food_not_disease = "SELECT COUNT(*) AS countxp FROM FoodsUsersExperience WHERE User = " .
            $_SESSION['userID'] . " AND Food != " .
            $food_data_id[$food_iter] . " AND TummyReaction != " .
            $tummy_reactions_data_id[$tummy_reactions_iter];
        $sql_result = mysqli_query($conn, $sql_count_not_food_not_disease);
        $count_n_f_n_d = $sql_result->fetch_assoc();
        if ($DEBUG) {
            echo '$sql_count_not_food_not_disease = ' .  $count['countxp'] . '<br>';
        }
       // echo '<p><mark>You ate ' . $food_data_name[$food_iter] . ' ';
        echo '<p><mark>You ate ' . $food_data_name[$food_iter] . ' ' . $count_f_d['countxp'] + $count_f_n_d['countxp'] . ' time/s and you got ' . $tummy_reactions_data_description[$tummy_reactions_iter] . ' ' . $count_f_d['countxp'] . ' time/s </mark></p>';
    }
}
echo '</div>';
echo '</body>';
?>
