<?php

// Demand a GET parameter
if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}

// If the user requested logout go back to index.php
if ( isset($_POST['logout']) ) {
    header('Location: index.php');
    return;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oswaldo Nickel's Garage</title>
    <link rel="stylesheet" href="css/style.css" media="all">
</head>
<body>
    <div id="main">
        <h2>Track Autos for </h2>
        <?php
            if ( isset($_REQUEST['name']) ) {
                echo "<h4>". htmlentities($_REQUEST['name']) . "</h4>";
}
?>
        <form action="" method="post">
            <div class="lbl">
                <input class="link" type="submit" value="Play">
                <input class="link" type="submit" value="Log Out" name="logout">
            </div>
        </form>
<pre>
<?php
if ( $human == -1 ) {
    print "Please select a strategy and press Play.\n";
} else if ( $human == 3 ) {
    for($c=0;$c<3;$c++) {
        for($h=0;$h<3;$h++) {
            $r = check($c, $h);
            print "Human=$names[$h] Computer=$names[$c] Result: <span>$r</span>\n";
        }
    }
} else {
    print "Your Play=$names[$human] Computer Play=$names[$computer] Result=<span>$result</span>\n";
}
?>
</pre>
    </div>
</body>
</html>
