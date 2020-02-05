<?php
// Demand a GET parameter
if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}

//db connection
require_once ('pdo.php');

//get a list of autos
function make_list($pdo){
    $stmt = $pdo->query("SELECT make, year, mileage FROM autos");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
$failure = false;  // If we have no POST data
//check  if  insert was successful --> first,  false
$success=0;;
//global
$make = 0;
$year = 0;
$mil= 0;

if ( isset($_POST['make']) && isset($_POST['year']) 
    && isset($_POST['mileage'])) {
    //prevent html injection
    $make=htmlentities($_POST['make']);
    $year=htmlentities($_POST['year']);
    $mil=htmlentities($_POST['mileage']);

    if (!is_numeric($year) || !is_numeric($mil)) {
        $failure= "Mileage and year must be numeric";
    }
    elseif ( strlen($make)<1 ) {
        $failure="Make is required";
    } else {
        $sql = "INSERT INTO autos (make, year, mileage) 
              VALUES (:mk, :yr, :ml)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
            ':mk' => $make,
            ':yr' => $year,
            ':ml' => $mil));
    $success=1;
    
    }
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
      <?php 
        //check if there's an error
        if ( $failure !== false ) {
            echo('<p class="error">'.htmlentities($failure)."</p>\n");
        }
        if ($success > 0) {
            echo '<h5 class="success">Record inserted</h5>';
} ?>
        <h2>Track Autos for </h2>
        <?php
            if ( isset($_REQUEST['name']) ) {
                echo "<h4>". htmlentities($_REQUEST['name']) . "</h4>";
}
?>
        <form action="" method="post">
            <label class="lbl" for="">Make</label>
            <input id="" type="text" name="make">
            <label class="lbl" for="">Year</label>
            <input id="" type="text" name="year">
            <label class="lbl" for="">Mileage</label>
            <input id="" type="text" name="mileage">
            <div class="lbl">
                <input class="link" type="submit" value="Add" name="add">
                <input class="link" type="submit" value="Log Out" name="logout">
            </div>
        </form>
        <?php
          $data=make_list($pdo);
if (!empty($data)){?>
<table>
    <tr>
        <th>Make</th>
        <th>Year</th>
        <th>Mileage</th>
    </tr>
<?php
    foreach ($data as $row) {
        echo "<tr><td>";
        echo($row['make']);
        echo("</td><td>");
        echo($row['year']);
        echo("</td><td>");
        echo($row['mileage']);
        echo("</td></tr>\n");
    }
}
?>
</table>

    </div>
</body>
</html>
