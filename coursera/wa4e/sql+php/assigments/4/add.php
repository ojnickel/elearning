<?php
session_start();

if (!isset($_SESSION['name'])) {
    die('Not logged in');
}

//cancel 
if ( isset($_POST['cancel'])) {
    $_SESSION['error'] = "No record inserted";
    header("Location: view.php");
    return;
}
//db connection
require_once 'pdo.php';

//global
$make = 0;
$year = 0;
$mil = 0;

if (
    isset($_POST['make']) &&
    isset($_POST['year']) &&
    isset($_POST['mileage'])
) {
    //prevent html injection
    $make = htmlentities($_POST['make']);
    $year = htmlentities($_POST['year']);
    $mil = htmlentities($_POST['mileage']);

    if (!is_numeric($year) || !is_numeric($mil)) {
        $_SESSION['error'] = "Mileage and year must be numeric";
        header("Location: add.php ");
        return;
    } elseif (strlen($make) < 1) {
        $_SESSION['error'] = "Make is required";
        header("Location: add.php ");
        return;
    } else {
        $sql = "INSERT INTO autos (make, year, mileage) 
              VALUES (:mk, :yr, :ml)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':mk' => $make,
            ':yr' => $year,
            ':ml' => $mil));
        $_SESSION['success']="Record inserted";
        header("Location: view.php");
        return;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css" media="all">
    <title>Oswaldo  Nickel's new in Garage</title>
</head>
<body>
    <div id="main">
        <h2>Add Autos for </h2>
            <?php 
                echo "<h4>" . htmlentities($_SESSION['name']) . "</h4>";
            ?>
        <?php
            if ( isset($_SESSION['error']) ) {
                echo '<p class="error">' . htmlentities($_SESSION['error']) . "</p>\n";
                unset($_SESSION['error']);
            }
        ?>
            <form action="" method="post">
                <label class="lbl" for="">Make</label>
                <input id="" type="text" name="make">
                <label class="lbl" for="">Year</label>
                <input id="" type="text" name="year">
                <label class="lbl" for="">Mileage</label>
                <input id="" type="text" name="mileage">
                <div class="lbl">
                    <input class="link" type="submit" value="Add" name="add">
                    <input class="link" type="submit" value="Cancel" name="cancel">
                </div>
            </form>
        </div>    
    </body>
</html>
