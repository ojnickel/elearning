<?php
session_start();

//is someone loggedd in?
require_once 'check.php';
checkUserDie();

//cancel
if (isset($_POST['cancel'])) {
    $_SESSION['error'] = "No record inserted";
    header("Location: index.php");
    return;
}
//db connection
require_once 'pdo.php';

//validation and modifying db
require_once 'valmod.php';
//check if profile_id and user_id are valid
$row = dataID($pdo, $_GET['profile_id'], $_SESSION['user_id']);

//check if  there is post to add
if (isPost()) {
    $sql =
        "UPDATE Profile SET first_name = :fn, last_name = :ln, email = :em, headline = :he, summary = :su WHERE profile_id = :id";
    $data = array(
        ':id' => $_REQUEST['profile_id'],
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':he' => $_POST['headline'],
        ':su' => $_POST['summary']
    );
    $message = "Entry updated";
    ValidateAndModify($pdo, $sql, $data, $message);
}
// Guardian: Make sure that profile_id is present
missing();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css" media="all">
    <title>Oswaldo Nickel's edit garage</title>
    <script>
        function doValidateForm() {
            console.log("Validating...");
            try {
                fn = document.getElementById("id_fn").value;
                ln = document.getElementById("id_ln").value;
                he = document.getElementById("id_he").value;
                su = document.getElementById("id_su").value;
                em = document.getElementById("id_em").value;
                console.log("Validating fn=" + fn + " ln=" + ln + " em=" + em + " he=" + he + " su=" + su
);
                if ((em == null || em == "") || (fn == null || fn == "") || (he == null || he == "") || (ln == null || ln == "") || (su == null || su == ""))
{
                    alert("All fields are required");
                    return false;
                }
                console.log("Validating em=" + em);
                if   (em.indexOf("@")<0){
                    alert("Email address must contain @");
                    return false;
                }
                return true;
            } catch (e) {
                return false;
            }
            return false;
        }
    </script>
</head>
<body>
    <div id="main">
        <h2>Edit Autos for </h2>
            <?php echo "<h4>" . htmlentities($_SESSION['name']) . "</h4>"; ?>
        <?php if (isset($_SESSION['error'])) {
            echo '<p class="error">' .
                htmlentities($_SESSION['error']) .
                "</p>\n";
            unset($_SESSION['error']);
        } ?>
            <form action="" method="post">
                <label class="lbl" for="">first_name</label>
                <input id="id_fn" type="text" name="first_name" value="<?= htmlentities(
                    $row['first_name']
                ) ?>">
                <label class="lbl" for="">last_name</label>
                <input id="id_ln" type="text" name="last_name" value="<?= htmlentities(
                    $row['last_name']
                ) ?>">
                <label class="lbl" for="">email</label>
                <input id="id_em" type="text" name="email" value="<?= htmlentities(
                    $row['email']
                ) ?>">
                <label class="lbl" for="">headline</label>
                <input id="id_he" type="text" name="headline" value="<?= htmlentities(
                    $row['headline']
                ) ?>">
                <label class="lbl" for="">Summary</label>
                <textarea id="id_su" name="summary" cols="30" rows="10" ><?= htmlentities(
                    $row['summary']
                ) ?></textarea>
                <div class="lbl">
                    <input class="btn" type="submit" onclick="return doValidateForm();" value="Save" name="add">
                    <input class="btn" type="submit" value="Cancel" name="cancel">
                </div>
            </form>
        </div>    
    
</body>
</html>
