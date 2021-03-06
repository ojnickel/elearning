<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oswaldo Nickel MD5 fun</title>
    <link rel="stylesheet" href="css/style.css" media="all">
</head>
<body>
    <div class="main">
      <h1>Crack it up!</h1>
      <p class="intro">This application takes an MD5 hash of a two-character lower case string and attempts to hash all two-character combinations to determine the original two characters.</p>
      <h4>And the winner is...</h4>
     <pre>
<?php
$goodtext = "Not found";
// If there is no parameter, this code is all skipped
if ( isset($_GET['md5']) ) {
    $time_pre = microtime(true);
    $md5 = $_GET['md5'];

    // This is our alphabet
    $txt = "abcdefghijklmnopqrstuvwxyz";
    $number = "0123456789";
    #$alpha = $txt.$number;
    #echo    $alpha;
    $show = 15;
    
    // Outer loop go go through the alphabet for the
    // first position in our "possible" pre-hash
    // text
    for($i=0; $i<strlen($number); $i++ ) {
        $ch1 = $number[$i];   // The first of two characters

        // Our inner loop Not the use of new variables
        // $j and $ch2 
        for($j=0; $j<strlen($number); $j++ ) {
            $ch2 = $number[$j];  // Our second character

            for ($k = 0; $k<strlen($number); $k++) {
                $ch3 = $number[$k];
                
                for ($l = 0; $l<strlen($number); $l++) {
                    $ch4 = $number[$l];
                    
                    // Concatenate the two characters together to 
                    // form the "possible" pre-hash text
                     $try = $ch1.$ch2.$ch3.$ch4;

          
                    // Run the hash and then check to see if we match
                    $check = hash('md5', $try);
                    if ( $check == $md5 ) {
                        $goodtext = $try;
                        break;   // Exit the inner loop
                    }
                    
                     // Debug output until $show hits 0
                    if ( $show > 0 ) {
                        print "$check $try\n";
                        $show = $show - 1;
                    } 
                }//4th loop
          }//3rd loop
        }//2nd loop
    }//1st loop
    // Compute elapsed time
    $time_post = microtime(true);
    print "Elapsed time: ";
    print $time_post-$time_pre;
    print "\n";
}
?>
</pre>
<!-- all htmlentities() -->
<p id="result">
<?php
if ( isset($_GET['md5']) ) {
    echo '<p id="result">PIN: <span>'. $goodtext. '</span></p>';
}
  
?>
</p>
<form action="">
    <input id="" type="text" name="md5" size=60>
    <input type="submit" value="Do it">
</form>
<ul id="nav">
    <li><a href="index.php">Try again</a></li>
    <li><a href="md5.php">md5 Encoder</a></li>
    <li><a href="makecode.php">MD5 Code Maker</a></li>
</ul>
    </div>
</body>
</html>

