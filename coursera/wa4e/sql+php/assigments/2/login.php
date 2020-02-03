<?php // Do not put any HTML above this line

if ( isset($_POST['cancel'] ) ) {
    // Redirect the browser to sttartpage
    header("Location: index.php");
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123

$failure = false;  // If we have no POST data

// Check to see if we have some POST data, if we do process it
if ( isset($_POST['email']) && isset($_POST['pass']) ) {
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $failure = "User name and password are required";
    } else {
        $check = hash('md5', $salt.$_POST['pass']);
        if ( $check == $stored_hash ) {
            // Redirect the browser to autos.php
            header("Location: autos.php?name=".urlencode($_POST['email']));
            return;
        } else {
            $failure = "Incorrect password";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oswaldo Nickel's Login Page</title>
    <link rel="stylesheet" href="css/style.css" media="all">
</head>
<body>
    <div id="main">
        <h2>Welcome</h2>
        <h4>Please log in:</h4>
        <?php
            //check if there's an error
            if ( $failure !== false ) {
              echo('<p class="error">'.htmlentities($failure)."</p>\n");
}
        ?>
        <div class="login">
            <form action="" method="post">
                <label class="lbl" for="nam">Username</label>
                <input id="nam" type="text" name="email">
                <label class="lbl" for="">Password</label>
                <input id="" type="password" name="pass">
                <div class="lbl">
                    <input class="link" type="submit" value="Log In">
                    <input class="link" type="submit" name="cancel" value="Cancel">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
