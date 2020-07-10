<?php
require_once "pdo.php";

function dataId ($pdo) {//get data for id
    $stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
    $stmt->execute(array(":xyz" => $_GET['autos_id']));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //it has to be something with this id
    if ( $row === false ) {
        $_SESSION['error'] = 'Bad value for autos_id';
        header( 'Location: index.php' ) ;
        return;
    } else {
        return $row;      
    }
}
?>
