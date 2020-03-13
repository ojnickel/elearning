<?php
session_start();

//is someone loggedd in?
require_once 'check.php';
checkUserDie();

//cancel
if (isset($_POST['cancel'])) {
    $_SESSION['error'] = "No record inserted";
    header("Location: index.php");
    return;
}
//db connection
require_once 'pdo.php';

//validation and modifying db
require_once 'valmod.php';

//check if  there is post to add
if (isPost()) {
    $sql =
        "INSERT INTO Profile (user_id, first_name, last_name, email, headline, summary) VALUES ( :uid, :fn, :ln, :em, :he, :su )";
    $data = array(
        ':uid' => $_SESSION['user_id'],
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':he' => $_POST['headline'],
        ':su' => $_POST['summary']
    );
    $message = "Entry added";
    ValidateAndModify($pdo, $sql, $data, $message);
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
            <?php echo "<h4>" . htmlentities($_SESSION['name']) . "</h4>"; ?>
        <?php if (isset($_SESSION['error'])) {
            echo '<p class="error">' .
                htmlentities($_SESSION['error']) .
                "</p>\n";
            unset($_SESSION['error']);
        } ?>
            <form action="" method="post">
                <label class="lbl" for="">first_name</label>
                <input id="" type="text" name="first_name">
                <label class="lbl" for="">last_name</label>
                <input id="" type="text" name="last_name">
                <label class="lbl" for="">email</label>
                <input id="" type="text" name="email">
                <label class="lbl" for="">headline</label>
                <input id="" type="text" name="headline">
                <label class="lbl" for="">Summary</label>
                <textarea id="" name="summary" cols="30" rows="10"></textarea>
                <div class="lbl">
                    <input class="link" type="submit" value="Add" name="add">
                    <input class="link" type="submit" value="Cancel" name="cancel">
                </div>
            </form>
        </div>    
    </body>
</html>
