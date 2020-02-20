<?php
session_start();

if ( ! isset($_SESSION['name']) ) {
  die('Not logged in');
}

//db connection
require_once 'pdo.php';

//get a list of autos
function make_list($pdo)
{
    $stmt = $pdo->query("SELECT make, year, mileage FROM autos");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

//go to add.php
if (isset($_POST['add'])) {
    header('Location: add.php');
    return;
}

// If the user requested logout go back to index.php
if (isset($_POST['logout'])) {
    session_start();
    session_destroy();
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oswaldo Nickel's Garage</title>
    <link rel="stylesheet" href="css/style.css" media="all">
</head>
<body>
    <div id="main">
      <?php
        if ( isset($_SESSION['error']) ) {
            echo '<p class="error">' . htmlentities($_SESSION['error']) . "</p>\n";
            unset($_SESSION['error']);
        }
        if ( isset($_SESSION["success"]) ) {
            echo '<p  class="success">' .$_SESSION["success"] . "</p>\n";
            unset($_SESSION["success"]);
        }  
      ?>
        <h2>Track Autos for </h2>
            <?php 
                echo "<h4>" . htmlentities($_SESSION['name']) . "</h4>";
            ?>
        <?php
            $data = make_list($pdo);
      // don't show table, if db is empty
        if (!empty($data)) { ?>
<table>
    <tr>
        <th>Make</th>
        <th>Year</th>
        <th>Mileage</th>
    </tr>
<?php foreach ($data as $row) {
    echo "<tr><td>";
    echo $row['make'];
    echo "</td><td>";
    echo $row['year'];
    echo "</td><td>";
    echo $row['mileage'];
    echo "</td></tr>\n";
}}
        ?>
        </table>
        <div class="message">
            <a class="link" href="add.php">Add New</a>
            <a class="link" href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
