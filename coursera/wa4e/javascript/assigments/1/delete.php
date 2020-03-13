<?php
require_once "pdo.php";
session_start();

//is someone loggedd in?
require_once 'check.php';
checkUserDie();

if ( isset($_POST['delete']) && isset($_POST['profile_id']) ) {
    $sql = "DELETE FROM  Profile WHERE profile_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_REQUEST['profile_id']));
    $_SESSION['success'] = 'Entry deleted';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that profile_id is present
if ( ! isset($_GET['profile_id']) ) {
  $_SESSION['error'] = "Missing profile_id";
  header('Location: index.php');
  return;
}


//cancel 
if ( isset($_POST['cancel'])) {
    $_SESSION['error'] = "No record deleted";
    header("Location: index.php");
    return;
}

//data of the current id
$row = dataID($pdo, $_GET['profile_id'], $_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css" media="all">
    <title>Delete confirmation in Oswaldo Nickel's Registry</title>
</head>
<body>
    <div id="main">
    <h2>Are you sure?</h2>
    <ul>
        <li>
            <p class="lbl">First name</p>
            <p class="message"><?= $row['first_name'] ?></p>
        </li>
        <li>
            <p class="lbl">Last name</p>
            <p class="message"><?= $row['last_name'] ?></p>
        </li>
    </ul>
        <form action="" method="post">
            <input type="hidden" name="profile_id" value="<?= $row['profile_id'] ?>">
            <input class="link"  type="submit" value="Delete" name="delete">
            <input class="link" type="submit" value="Cancel" name="cancel">
        </form>
    </div>    
</body>
</html>
