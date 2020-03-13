<?php
session_start();

//db connection
require_once 'pdo.php';

//for checking if user is logged in
require_once 'check.php';

//get a list of profiles
function make_list($pdo)
{
    $stmt = $pdo->query("SELECT profile_id, first_name, headline FROM Profile");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
//collect the list
$data = make_list($pdo);

// If the user requested logout go back to index.php
if (isset($_POST['logout'])) {
    require 'logout.php';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oswaldo Nickel's Resume registry</title>
    <link rel="stylesheet" href="css/style.css" media="all">
</head>
<body>
    <div id="main">
    <h1>Welcome to My Registry!</h1>
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
      if (!checkUserLogIn()) {
          //print login optioon
          ?>
        <h2>Go ahead!</h2>
        <div class="login">
            <p>Do your thing:</p>
            <a href="login.php"><span>Please log in</span></a>
        </div>
    <?php } else {//logged in
          echo "<h2>Welcome back </h2>\n<h4>" .
              htmlentities($_SESSION['name']) .
              "</h4>";}
      //show profiles table
      //fi0rst, data from db
      $data = make_list($pdo);
      // don't show table, if db is empty
      if (!empty($data)) { ?>
<table>
    <tr>
        <th>Name</th>
        <th>Headline</th>
        <?php if (checkUserLogIn()) {
            echo "<th>Action</th>";
        } ?>
    </tr>
<?php
foreach ($data as $row) {
    echo "<tr><td>";
    echo '<a class="link1" href="view.php?profile_id=' . $row['profile_id'] . '">' . $row['first_name'] . '</a>';
    echo "</td><td>";
    echo $row['headline'];
    if (checkUserLogIn()) {
        echo "</td><td>";
        echo '<a class="link" href="edit.php?profile_id=' . $row['profile_id'] . '">Edit</a>';
        echo '<a class="link" href="delete.php?profile_id=' . $row['profile_id'] . '">Delete</a>';
    }
    echo "</td></tr>\n";
} //foreach
  }//empty data
echo '</table>';
if (checkUserLogIn()) {
    echo '<div class="message">';
    echo '<a class="btn" href="add.php">Add New Entry</a>';
    echo '<a class="btn" href="logout.php">Logout</a>';
    echo '</div>';
} else { 
        echo '<div class="message">';
            echo '<h4>if you dont log in or attempt to go to </h4>';
            echo '<ul>';
                echo '<li><a class="link" href="add.php">add.php</a></li>';
                echo '<li><a class="link" href="edit.php">edit.php</a></li>';
                echo '<li><a class="link" href="delete.php">delete.php</a></li>';
            echo '</ul>';
            echo '<h4>no game :-(</h4>';
        echo '</div>';
        }
      
?>
    </div>
</body>
</html>
