<?php
require_once "pdo.php";

function dataId ($pdo, $table, $id_key) {//get data for id
    $stmt = $pdo->prepare("SELECT * FROM" . $table . "WHERE " . $id_key . " = :xyz");
    $stmt->execute(array(":xyz" => $_GET[$id_key]));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //it has to be something with this id
    if ( $row === false ) {
        $_SESSION['error'] = 'Bad value for autos_id';
        header( 'Location: index.php' ) ;
        return;
    } else {
        return $row;      
    }
        <?php
foreach ($data as $key => $value) {
    echo '<li>';
    echo '<p class="lbl">' . $key . '</p>';
   echo '<p class="message">' . $value . '</p>'; 
    echo '</li>';
}
?>
}
?>
