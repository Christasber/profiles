<?php
require_once "pdo.php";
session_start();
if (!isset ($_SESSION['user_id'])){die("Please Log In");}


if ( isset($_POST['first_name']) && isset($_POST['last_name'])
     && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary']) && isset($_POST['profile_id']) ) {

    // Data validation
    if ( strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['summary']) < 1 || strlen($_POST['headline']) < 1) {
        $_SESSION['error'] = 'Missing data';
        header("Location: edit.php?profile_id=".$_POST['profile_id']);
        return;
    }

    elseif (str_contains($_POST['email'], '@')==false){
      $_SESSION['error'] = 'email must include @' ;
      header("Location: edit.php?profile_id=".$_POST['profile_id']);
      return;
    }

    $sql = "UPDATE profile SET first_name = :fn,
            last_name = :ln, email = :em, headline = :hl, summary = :su
            WHERE profile_id = :profile_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':fn' => $_POST['first_name'],
        ':ln' => $_POST['last_name'],
        ':em' => $_POST['email'],
        ':hl' => $_POST['headline'],
        ':su' => $_POST['summary'],
        ':profile_id' => $_POST['profile_id']));
    $_SESSION['success'] = 'Record updated';
    header( 'Location: index.php' ) ;
    return;
}




$stmt = $pdo->prepare("SELECT * FROM profile where profile_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$fn = htmlentities($row['first_name']);
$ln = htmlentities($row['last_name']);
$em = htmlentities($row['email']);
$hl = htmlentities($row['headline']);
$su = htmlentities($row['summary']);
$profile_id = $row['profile_id'];
?>
<p>Edit User</p>
<form method="post">
<p>first name:
<input type="text" name="first_name" value="<?= $fn ?>"></p>
<p>last name:
<input type="text" name="last_name" value="<?= $ln ?>"></p>
<p>email:
<input type="text" name="email" value="<?= $em ?>"></p>
<p>headline:
<input type="text" name="headline" value="<?= $hl ?>"></p>
<p>summary:
<input type="text" name="summary" value="<?= $su ?>"></p>
<input type="hidden" name="profile_id" value="<?= $profile_id ?>">
<p><input type="submit" value="Save"/>
<a href="index.php">Cancel</a></p>
</form>
