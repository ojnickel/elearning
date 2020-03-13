<?php
require_once 'pdo.php';

function ValidateAndModify($pdo, $sql, $data, $message)
{
    //prevent html injection
    $first_name = htmlentities($_POST['first_name']);
    $last_name = htmlentities($_POST['last_name']);
    $email = htmlentities($_POST['email']);
    $headline = htmlentities($_POST['headline']);
    $summary = htmlentities($_POST['summary']);
    if (
        !strlen($first_name) ||
        !strlen($last_name) ||
        !strlen($email) ||
        !strlen($headline) ||
        !strlen($summary)
    ) {
        $_SESSION['error'] = "All fields are required";
        header("Location: add.php");
        return;
    } elseif (!stristr($email, "@")) {
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: add.php");
        return;
    } else {
        //insert or update
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
        $_SESSION['success'] = $message;
        header("Location: index.php");
        return;
    }
}
function isPost()
{
    if (
        isset($_POST['first_name']) &&
        isset($_POST['last_name']) &&
        isset($_POST['email']) &&
        isset($_POST['headline']) &&
        isset($_POST['summary'])
    ) {
        return 1;
    } else {
        return 0;
    }
}
