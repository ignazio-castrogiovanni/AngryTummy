<?php
session_start();

$servername = "localhost";
$username = "ignazio1_root";
$password = "19Baltic";
$dbname = "ignazio1_angrymemory";

$conn =  new msqli($servername, $username, $password, $dbname);
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

// Get all the foods
$sql_query_foods = "SELECT * FROM Foods";
$result_foods = mysqli_query($conn, $sql_query_foods) or die("Error in querying foods");
$food_data_name = array();
$food_data_id = array();

while($food = $result_foods->fetch_array()) {
    $food_data_name[] = $food['Name'];
    $food_data_id[] = $food['ID'];
}

for ($tummy_reactions_iter = 0; $tummy_reactions_iter < array_length($tummy_reactions_data_id) - 1; ++$tummy_reactions_iter) {
    echo '<h1>Stomach disease: ' . $tummy_reactions_data_description[$tummy_reactions_iter];
    for($foods_iter = 0; $food_iter < array_lenght($food_data_id) - 1; ++$food_iter) {
        echo '<p>Food: ' . $food_data_name[$food_iter] . '</p>';

        // A = Tutte le volte che HO MANGIATO quel cibo e HO AVUTO quell’effetto collaterale.
        // SELECT COUNT(*) FROM FoodsUsersExperience WHERE User = Z AND Food = Y AND TummyReaction = X
        $sql_count_food_disease = "SELECT COUNT(*) AS countxp FROM FoodsUsersExperience WHERE User = " .
            $_POST['userID'] . " AND Food = " .
            $food_data_id[$foods_iter] . " AND TummyReaction = " .
            . $tummy_reactions_data_id[$tummy_reactions_iter];
        $sql_result = mysqli_query($conn, $sql_count_food_disease);
        $count = $sql_result->fetch_assoc();
        echo '$sql_count_food_disease = ' .  $count['countxp'];

        // B = Tutte le volte che HO MANGIATO quel cibo e NON HO AVUTO quell’effetto collaterale.
        // SELECT COUNT(*) AS countxp FROM FoodsUsersExperience WHERE User = Z AND Food = Y AND TummyReaction != X
        $sql_count_food_not_disease = "SELECT COUNT(*) AS countxp FROM FoodsUsersExperience WHERE User = " .
            $_POST['userID'] . " AND Food = " .
            $food_data_id[$foods_iter] . " AND TummyReaction != " .
            . $tummy_reactions_data_id[$tummy_reactions_iter];
        $sql_result = mysqli_query($conn, $sql_count_food_not_disease);
        $count = $sql_result->fetch_assoc();
        echo '$sql_count_food_not_disease = ' .  $count['countxp'];

        // C = Tutte le volte che NON HO MANGIATO quel cibo e HO AVUTO  quell’effetto collaterale.
        // SELECT COUNT(*) AS countxp FROM FoodsUsersExperience WHERE User = Z AND Food != Y AND TummyReaction = X
        $sql_count_not_food_disease = "SELECT COUNT(*) AS countxp FROM FoodsUsersExperience WHERE User = " .
            $_POST['userID'] . " AND Food != " .
            $food_data_id[$foods_iter] . " AND TummyReaction = " .
            . $tummy_reactions_data_id[$tummy_reactions_iter];
        $sql_result = mysqli_query($conn, $sql_count_not_food_disease);
        $count = $sql_result->fetch_assoc();
        echo '$sql_count_not_food_disease = ' .  $count['countxp'];

        // D = Tutte le volte che NON HO MANGIATO quel cibo e NON HO AVUTO quell’effetto collaterale.
        // SELECT COUNT(*) AS countxp FROM FoodsUsersExperience WHERE User = Z AND Food != Y AND TummyReaction != X
        $sql_count_not_food_not_disease = "SELECT COUNT(*) AS countxp FROM FoodsUsersExperience WHERE User = " .
            $_POST['userID'] . " AND Food != " .
            $food_data_id[$foods_iter] . " AND TummyReaction != " .
            . $tummy_reactions_data_id[$tummy_reactions_iter];
        $sql_result = mysqli_query($conn, $sql_count_not_food_not_disease);
        $count = $sql_result->fetch_assoc();
        echo '$sql_count_not_food_not_disease = ' .  $count['countxp'];
    }
}
?>
