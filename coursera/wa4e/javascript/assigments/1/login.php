<?php // Do not put any HTML above this line

session_start();
require_once 'pdo.php';

if (isset($_POST['cancel'])) {
    // Redirect the browser to sttartpage
    header("Location: index.php");
    return;
}
if (isset($_POST["email"]) && isset($_POST["pass"])) {
    unset($_SESSION["name"]); // Logout current user
    unset ($_SESSION['user_id']);
    //prevent html injection
    $user = htmlentities($_POST['email']);
    $pass = htmlentities($_POST['pass']);
    if (strlen($user) < 1 || strlen($pass) < 1) {
        $_SESSION['error'] = "Email and password are required";
        header("Location: login.php");
        return;
        //chech if "@" is set in email
    } elseif (!stristr($user, "@")) {
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: login.php");
        return;
    } else {
        //email correct
        $salt = 'XyZzy12*_';
        $check = hash('md5', $salt.$_POST['pass']);
        $stmt = $pdo->prepare('SELECT user_id, name FROM users
            WHERE email = :em AND password = :pw');
        $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check ));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ( $row !== false  ) {
            $_SESSION['name'] = $row['name'];
            $_SESSION['user_id'] = $row['user_id'];
            error_log("Login success " . $_POST['email']);
            // Redirect the browser to index.php
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
    <script>
        function doValidate() {
            console.log("Validating...");
            try {
                pw = document.getElementById("id_pw").value;
                console.log("Validating pw=" + pw);
                if (pw == null || pw == "") {
                    alert("Both fields must be filled out");
                    return false;
                }
                return true;
            } catch (e) {
                return false;
            }
            return false;
        }
    </script>
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
                <input id="id_em" type="text" name="email">
                <label class="lbl" for="">Password</label>
                <input id="id_pw" type="password" name="pass">
                <div class="lbl">
                    <input class="link" type="submit" onclick="return doValidate();" value="Log In">
                    <input class="link" type="submit" name="cancel" value="Cancel">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
