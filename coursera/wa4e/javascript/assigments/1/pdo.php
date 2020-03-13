<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=crud', 'fred', 'zap');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//check if id is valid -> e.g. user_id -> for delete
function dataId($pdo, $pid, $uid)
{
    //get    data for id
    $stmt = $pdo->prepare(
        "SELECT * FROM Profile WHERE profile_id = :xyz AND user_id = :uid"
    );
    $stmt->execute(array(
        ":xyz" => $pid,
        ':uid' => $uid
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //it has to be something with this id
    if ($row === false) {
        $_SESSION['error'] =
            'Bad value for ' . $_GET['profile_id'] . ' and current user';
        header('Location: index.php');
        return;
    } else {
        return $row;
    }
}
//check and get list only fo id
function getId ($pdo, $id) {//get data for id
    $stmt = $pdo->prepare("SELECT * FROM Profile where profile_id = :xyz");
    $stmt->execute(array(":xyz" => $_GET['profile_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //it has to be something with this id
    if ( $row === false ) {
        $_SESSION['error'] = 'Bad value for profile_id';
        header( 'Location: index.php' ) ;
        return;
    } else {
        return $row;      
    }
}

