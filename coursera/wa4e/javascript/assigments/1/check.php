<?php
//check if logged in or die
function checkUserDie()
{
    if (!isset($_SESSION['name']) && !isset($_SESSION['user_id'])) {
        die('Not logged in');
    }
}
//check if logged in
function checkUserLogIn()
{
    if (!isset($_SESSION['name']) && !isset($_SESSION['user_id'])) {
        return 0; //no one there :-)
    } else {
        return 1; //bravo!!
    }
}

function missing()
{
    if (!isset($_GET['profile_id'])) {
        $_SESSION['error'] = "Missing profile_id";
        header('Location: index.php');
        return;
    }
}
