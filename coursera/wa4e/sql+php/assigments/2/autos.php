<?php
// Demand a GET parameter
if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}

//db connection
require_once ('pdo.php');

//get a list of autos
function make_list(){
    $stmt = $pdo->query("SELECT make, year, mileage FROM misc");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
//check  if  insert was successful --> first,  false
$success=0;;

if ( isset($_POST['make']) && isset($_POST['year']) 
     && isset($_POST['mileage'])) {
    $sql = "INSERT INTO misc (make, year, mileage) 
              VALUES (:mk, :yr, :ml)";
    echo("<pre>\n".$sql."\n</pre>\n");
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':mk' => $_POST['make'],
        ':yr' => $_POST['year'],
        ':ml' => $_POST['mileage']));
    $success=1;
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
        if ($success > 0) {
            echo '<h5 class="success">Record inserted</h5>';
} ?>
        <h2>Track Autos for </h2>
        <?php
            if ( isset($_REQUEST['make']) ) {
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
          $data=make_list();
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
