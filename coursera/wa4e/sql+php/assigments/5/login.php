<?php // Do not put any HTML above this line

session_start();

if (isset($_POST['cancel'])) {
    // Redirect the browser to sttartpage
    header("Location: index.php");
    return;
}
if (isset($_POST["email"]) && isset($_POST["pass"])) {
    unset($_SESSION["name"]); // Logout current user
    //prevent html injection
    $user = htmlentities($_POST['email']);
    $pass = htmlentities($_POST['pass']);
    if (strlen($user) < 1 || strlen($pass) < 1) {
        $_SESSION['error'] = "Email and password are required";
        header("Location: login.php");
        return;
        //chech if "@" is set in email
    } elseif (!stristr($user, "@")) {
        $failure = "Email must have an at-sign (@)";
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: login.php");
        return;
    } else {
        //email correct
        $salt = 'XyZzy12*_';
        $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1'; // Pw is php123
        $check = hash('md5', $salt . $pass);
        if ($check == $stored_hash) {
            error_log("Login success " . $_POST['email']);
            // Redirect the browser to index.php
            $_SESSION['name'] = $_POST['email'];
            $_SESSION["success"] = "Logged in.";
            header("Location: index.php");
            return;
        } else {
            error_log("Login fail " . $_POST['email'] . " $check");
            $_SESSION["error"] = "Incorrect password.";
            header('Location: login.php');
            return;
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
            if (isset($_SESSION['error'])) {
                echo '<p class="error">' . htmlentities($_SESSION['error']) . "</p>\n";
                unset($_SESSION['error']);
            } 
        ?>
        <div class="login">
            <form action="" method="post">
                <label class="lbl" for="nam">E-Mail Adress</label>
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
