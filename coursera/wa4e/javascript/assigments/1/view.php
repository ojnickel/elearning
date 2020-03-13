<?php
session_start();


//db connection
require_once 'pdo.php';

//get a list of profiles
$data=getId($pdo, $_GET['profile_id']);
foreach ($data as  $row) {
    $row = htmlentities($row);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oswaldo Nickel's viewer</title>
    <link rel="stylesheet" href="css/style.css" media="all">
</head>
<body>
    <div id="main">
        <h2>Profile  information</h2>
        <p class="secret">I hope, you're not NSA</p>
        <ul>
        <li>
            <p class="lbl">First Name</p>
            <p class="message"><?= $data['first_name'] ?></p>
        </li>
        <li>
            <p class="lbl">Last Name</p>
            <p class="message"><?= $data['last_name'] ?></p>
        </li>
        <li>
            <p class="lbl">E-Mail</p>
            <p class="message"><?= $data['email'] ?></p>
        </li>
        <li>
            <p class="lbl">Headline</p>
            <p class="message"><?= $data['headline'] ?></p>
        </li>
        <li>
            <p class="lbl">Summary</p>
            <p class="message"><?= $data['summary'] ?></p>
        </li>
        </ul>
        <a class="link" href="index.php">Done</a>
    </div>
</body>
</html>
