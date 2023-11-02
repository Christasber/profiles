<?php
require_once "pdo.php";
require_once "bootstrap.php";
session_start();
?>
<html>
<title>Chris Tasber profiles</title>
<head></head><body>
  <script>
  function validatePos() {
    for($i=1; $i<=9; $i++) {
      if ( ! isset($_POST['year'.$i]) ) continue;
      if ( ! isset($_POST['desc'.$i]) ) continue;

      $year = $_POST['year'.$i];
      $desc = $_POST['desc'.$i];

      if ( strlen($year) == 0 || strlen($desc) == 0 ) {
        return "All fields are required";
      }

      if ( ! is_numeric($year) ) {
        return "Position year must be numeric";
      }
    }
    return true;
  }
  </script>

<?php
if ( isset ($_SESSION['user_id']))
{echo(
"<a href='add.php'>Add New Entry</a>      <a href='logout.php'> logout</a>");
  }
else {echo('<p><a href=login.php>Please log in</a></p>');}

echo('<table border="1">'."\n");
echo ("<tr><th>Name</th><th>Headline</th><th>Action</th></tr>");
$stmt = $pdo->query("SELECT first_name, last_name, email, headline, profile_id, summary FROM profile");
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    echo "<tr><td>";
    echo(htmlentities($row['first_name']).' '. $row['last_name']);
echo("</td><td>");
echo(htmlentities($row['headline']));
echo("</td><td>");
echo('<a href=view.php?profile_id='.$row['profile_id'].'">View</a>');
if ( isset ($_SESSION['user_id']))
{
echo('/<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> /');
echo( '<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>  ');
echo("</td></tr>\n");





}}

if ( isset ($_SESSION['sucess'])) {
  echo ($_SESSION['sucess']);
  unset($_SESSION['sucess']);
}
if (isset ($_SESSION['error'])){
  echo ($_SESSION['error']);
  unset($_SESSION['error']);}

  // code...
