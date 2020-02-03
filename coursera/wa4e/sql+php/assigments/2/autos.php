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

// Set up the values for the game...
// 0 is Rock, 1 is Paper, and 2 is Scissors
$names = array('Rock', 'Paper', 'Scissors');
$human = isset($_POST["human"]) ? $_POST['human']+0 : -1;

# Computer plays too
$computer = rand(0,2);

// This function takes as its input the computer and human play
// and returns "Tie", "You Lose", "You Win" depending on play
// where "You" is the human being addressed by the computer
function check($computer, $human) {
    //with % one can calculate the     outcome
    //0 -> tie, 1 ->  human win,  2  -> computer   win
    $dif = ($human - $computer) + 3; //it cannot be negative
    #if ( $dif %  3 == 0 ) {
    #    return "Tie";
    #} else if ( ($dif % 3 ) == 1 ) {
    #    return "You Win";
    #} else if ( ($dif % 3) == 2 ) {
    #    return "You Lose";
    #}
    return  "h: " . $human." c: ". $computer." -> ". $dif. " %3: ".$dif%3;
}

// Check to see how the play happenned
$result = check($computer, $human);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oswaldo Nickel's RPS</title>
    <link rel="stylesheet" href="css/style.css" media="all">
</head>
<body>
    <div id="main">
        <h2>Welcome</h2>
        <?php
            if ( isset($_REQUEST['name']) ) {
                echo "<h4>". htmlentities($_REQUEST['name']) . "</h4>";
}
?>
        <form action="" method="post">
            <select id="" name="human">
                <option value="-1">Select</option>
                <option value="0">Rock</option>
                <option value="1">Paper</option>
                <option value="2">Scissors</option>
                <option value="3">Test</option>
            </select>
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
