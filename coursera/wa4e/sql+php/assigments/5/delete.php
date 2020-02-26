<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['delete']) && isset($_POST['autos_id']) ) {
    $sql = "DELETE FROM  autos WHERE autos_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_REQUEST['autos_id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that autos_id is present
if ( ! isset($_GET['autos_id']) ) {
  $_SESSION['error'] = "Missing autos_id";
  header('Location: index.php');
  return;
}


//data of the current id
require_once("row.php");

$row = dataID($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css" media="all">
    <title>Remove Auto in Oswaldo Nickel's garage</title>
</head>
<body>
    <div class="main">
    <h4>Deleting for <?= $row['model'] ?></h4>
        <form action="" method="post">
            <input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>">
            <input class="link"  type="submit" value="Delete" name="delete">
        </form>
        <a class="link" href="index.php ">Cancel</a>
    </div>    
</body>
</html>
