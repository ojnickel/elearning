<?php

$u = array();
$c = array();
$m = array();
function makeList () {
    $i =  0;
    $f = fopen("list.csv", "r") or exit(    "Unable to open file!");
    while ($val = fgetcsv($f)) {

        #echo $i++ . '. ' . var_dump($val) . '<br />';
        $val  = array_map('trim', $val);
        $val[2] = ($val[2] == 'Instructor') ? 1 : 0;
        $u[] = $val[0];
        if (isset($c)){
            if (! in_array($val[1], $c)){
                $c[] = $val[1];
            }
        } else {
            $c[] = $val[1];
        }
        #$val[1]++=
        echo '<tr><td>' . $val[0] . '</td><td>' . $val[1] . '</td><td>' . $val[2] . '</td></tr>';

        $courseKey = array_search ($val[1], $c);



        $m[] =  ++$i . "' , '" . ++$courseKey . "',  '" . $val[2] ;
    }

    fclose($f);
    var_dump($u);
    echo "<br/>";
    createIns ($u, "User", "name");
    echo "<br/>";
    var_dump($c);
    echo "<br/>";
    createIns ($c, "Course", "title");

    echo "<br/>";
    createIns ($m, "Member", "user_id,course_id, role");

    ins_db ($u,  "User", "name");
    ins_db ($c, "Course", "title");
    ins_db ($m, "Member", "user_id,course_id,role");
}
function insert ($table, $col, $values) {
    return  "INSERT INTO "  . $table . "(" . $col . ") VALUES ('" . $values . "');";
}

function createIns ($arr, $table, $colname){
    foreach ($arr as $val){
        $sql = insert ($table, $colname, $val);
        echo $sql . "<br/>" ;

    }
}

function ins_db ($what, $table, $colname) {
    $servername = "localhost";
    $username = "root";
    $password = "nhrptk";
    $dbname = 'roster';

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);

    }
    echo "<br/><h3>" . $table . "</h3><br/>";
    $i=0;
    foreach ($what as $val) {
        $sql = insert ($table, $colname, $val);
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully<br/>";
            $i++;

        } else {
            echo "Error: " . $sql . "<br>" . $conn->error . "<br/>";
        }
    }
    echo  $i . "rows affected<br/>";
    $conn->close();
}
if (isset($_POST['submit'])) {
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
    <h3>join
        <pre>
SELECT User.name, Course.title, Member.role
FROM User JOIN Member JOIN Course
ON User.id = Member.user_id AND Member.course_id = Course.id
ORDER BY Course.title, Member.role DESC, User.name
        </pre>
        <br>
    </h3>
    <table>
        <tr>
            <th>User</th>
            <th>Course</th>
            <th>Role</th>
        </tr>
        <?php makeList(); ?>
    </table>
    <form action="" method="post">
      <input type="submit" value="Submit">
    </form>
</body>
</html>
