<?php
require_once "pdo.php";
require_once "bootstrap.php";
session_start();
?>
<html>
<title>Chris Tasber profiles</title>
<head></head><body>
<?php


echo('<table border="1">'."\n");
echo ("<tr><th>Name</th><th>email</th><th>Headline</th><th>summary</th><th>User</th></tr>");
$stmt = $pdo->query("SELECT first_name, last_name, email, headline, profile_id, user_id, summary FROM profile WHERE profile_id == $_POST[profile_id]");
while ( $row = $stmt->fetch(PDO::profile_id) ) {
    echo "<tr><td>";
    echo(htmlentities($row['first_name']).' '. $row['last_name']);
echo("</td><td>");
echo(htmlentities($row['email']));
echo("</td><td>");
echo(htmlentities($row['headline']));
echo("</td><td>");
echo(htmlentities($row['summary']));
echo("</td><td>");



echo "</tr></td>";
}

if (isset($_POST['Back']))
{header('location: index.php');
return;}
?>
<form method="post">
<input type="submit" value = "Back" name = 'Back'></p>
</form>
