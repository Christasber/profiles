
<?php
session_start();
require_once "bootstrap.php";
require_once "Util.php";
require_once 'head.php';


validatePos()
;
if (isset($_POST['Back']))
{header('location: index.php');
return;}
if (! isset($_SESSION['user_id'])){
  die ("ACCESS DENIED");}
require_once "pdo.php";
if (isset ($_SESSION['user_id']) &&
isset ($_POST['first_name']) &&
isset ($_POST['last_name']) &&
isset ($_POST['email']) && isset ($_POST['headline']) &&
isset ($_POST['summary'])  ){
  if (strlen($_POST['first_name'] < 1) && strlen($_POST['last_name'] < 1) && strlen($_POST['email'] < 1) && strlen($_POST['headline'] < 1)){
    $_SESSION['error'] = "All fields are required"; header('location: add.php');
    return;
  }
  elseif (str_contains($_POST['email'], '@')==false) {$_SESSION['error'] = "user must have an at-sign (@)"; header('location: add.php');
    return;}

    // code...
  else {
    // code...

    $stmt = $pdo->prepare('INSERT INTO Profile
  (user_id, first_name, last_name, email, headline, summary)
  VALUES ( :uid, :fn, :ln, :em, :he, :su)');

$stmt->execute(array(
  ':uid' => $_SESSION['user_id'],
  ':fn' => $_POST['first_name'],
  ':ln' => $_POST['last_name'],
  ':em' => $_POST['email'],
  ':he' => $_POST['headline'],
  ':su' => $_POST['summary'])
    );

    $profile_id = $pdo->lastInsertId();


$stmt = $pdo->prepare('INSERT INTO Position (profile_id, rank, year, description) VALUES ( :pid, :rank, :year, :desc)');

$stmt->execute(array(
  ':pid' => $profile_id,
  ':rank' => $rank,
  ':year' => $year,
  ':desc' => $desc)
);

$rank++;
    $_SESSION['sucess'] = "added";
header("Location: index.php");
return;}}
if ( isset ($_SESSION['sucess'])) {
  echo ($_SESSION['sucess']);
  unset($_SESSION['sucess']);
}
if (isset ($_SESSION['error'])){
  echo ($_SESSION['error']);
  unset($_SESSION['error']);}

  ?>


  <!DOCTYPE html>
  <html>
  <head>
  <title>Chris Tasber's Profiles</title>

  </head>

<body>


  <form method="post">
  <p> first name:<input type='text' name="first_name"></p>
  <p> last name:<input type="text" name="last_name"></p>
  <p> email:<input type="text" name="email"></p>
  <p> headline:<input type="text" name="headline"></p>
  <p> summary:<input type="text" name="summary"></p>
  <input type="hidden" name="user_id" value="<?= $user_id ?>">
  <p>Education:<input type= "submit" id='add_education' value='+' ></p>
  <p><div id="education_fields">
  </div></p>
  <p>Position:<input type= "submit" id='add_position' value='+' ></p>
  <p><div id="position_fields">
  </div></p>
  <p><input type="submit" value="Add New"/>
  <input type="submit" value = "Back" name = 'Back'></p>
  </form>
</body>

<script>

countPos = 0;


$(document).ready(function() {
  window.console && console.log('Document ready called');

  $('#add_position').click(function(event) {
    event.preventDefault();
    if (countPos >= 9) {
      alert("Maximum of nine position entries exceeded");
      return;
    }
    countPos++;
    window.console && console.log("adding position" +countPos);
    $('#position_fields').append(
      '<div id="position' + countPos + '"> \
      <p> Year: <input type="text" name="year' + countPos + '" value=""/> \
      <input type="button" value="-" \
           onclick="$(\'#position' + countPos + '\').remove();return false;"></p> \
      <textarea name="desc' + countPos + '" rows="8" cols="80"></textarea>\
      </div>');
  });
});

countEdu = 0;
$('.school').autocomplete({ source: "school.php" });

$(document).ready(function() {
  window.console && console.log('Document ready called');

  $('#add_education').click(function(event) {
    event.preventDefault();
    if (countEdu >= 9) {
      alert("Maximum of nine education entries exceeded");
      return;
    }
    countEdu++;

    window.console && console.log("adding education" +countEdu);
    $('#education_fields').append(
      '<div id="education' + countEdu + '"> \
      <p> Year: <input type="text" name="year' + countPos + '" value=""/> \
      <input type="button" value="-" \
           onclick="$(\'#education' + countPos + '\').remove();return false;"></p> \
<p>School: <input type="text" size="80" name="edu_school1" class="school" value="" /></p>\
    </div>');
  });
});

</script>
