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
if ( isset($_POST['who']) && isset($_POST['pass']))  {
    //prevent html injection
    $user  = htmlentities($_POST['who']);
    $pass = htmlentities ($_POST['pass']);
    if ( strlen($user) < 1 || strlen($pass) < 1 ) {
        $failure = "Email and password are required";
    //chech if "@" is set in who
    } elseif ( !stristr(  $user, "@" )){
        $failure = "Email must have an at-sign (@)";
    } else {
        $check = hash('md5', $salt.$pass);
        if ( $check == $stored_hash ) {
            error_log("Login success ".$_POST['who']);
            // Redirect the browser to autos.php
            header("Location: autos.php?name=".urlencode($_POST['who']));
            return;
        } else {
            error_log("Login fail ".$_POST['who']." $check");
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
                <label class="lbl" for="nam">E-Mail Adress</label>
                <input id="nam" type="text" name="who">
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
