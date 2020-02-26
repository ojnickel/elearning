<?php
session_start();

//db connection
require_once 'pdo.php';

//get a list of autos
function make_list($pdo)
{
    $stmt = $pdo->query(
        "SELECT make, model, year, mileage, autos_id FROM autos"
    );
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
//collect the list
$data = make_list($pdo);

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
    <title>Oswaldo Nickel - Autodatabase</title>
    <link rel="stylesheet" href="css/style.css" media="all">
</head>
<body>
    <div id="main">
    <h1>Welcome to My Garage!</h1>
      <?php
      if (isset($_SESSION['error'])) {
          echo '<p class="error">' .
              htmlentities($_SESSION['error']) .
              "</p>\n";
          unset($_SESSION['error']);
      }
      if (isset($_SESSION["success"])) {
          echo '<p  class="success">' . $_SESSION["success"] . "</p>\n";
          unset($_SESSION["success"]);
      }

      //check if logged in
      if (!isset($_SESSION['name'])) {
          //print login optioon
          ?>
        <h2>Go ahead!</h2>
        <div class="login">
            <p>Do your thing:</p>
            <a href="login.php"><span>Please log in</span></a>
        </divi>
        <div class="message">
            <h4>if you don't log in or attempt to go to </h4>
            <ul>
                <li><a class="link" href="add.php">add.php</a></li>
                <li><a class="link" href="edit.php">edit.php</a></li>
            </ul>
            <h4>no game :-(</h4>
        </div>
    <?php } else {
          //logged in
          ?>
        <h2>Track Autos for </h2>
            <?php echo "<h4>" . htmlentities($_SESSION['name']) . "</h4>"; ?>
        <?php
        $data = make_list($pdo);
        // don't show table, if db is empty
        if (!empty($data)) { ?>
<table>
    <tr>
        <th>Make</th>
        <th>Model</th>
        <th>Year</th>
        <th>Mileage</th>
        <th>Actions</th>
    </tr>
<?php foreach ($data as $row) {
    echo "<tr><td>";
    echo $row['make'];
    echo "</td><td>";
    echo $row['model'];
    echo "</td><td>";
    echo $row['year'];
    echo "</td><td>";
    echo $row['mileage'];
    echo "</td><td>";
    echo '<a class="link" href="edit.php?autos_id='  . $row['autos_id'] . '">Edit</a>';
    echo '<a class="link" href="delete.php?autos_id=' .  $row['autos_id'] . '">Delete</a>';
    echo "</td></tr>\n";
            }
        } else {
            echo '<p class="error">No rows found</p>';
        }
?>
        </table>
        <div class="message">
            <a class="link" href="add.php">Add New Entry</a>
            <a class="link" href="logout.php">Logout</a>
        </div>
<?php 
        }
      ?>
    </div>
</body>
</html>
