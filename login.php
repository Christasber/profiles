<?php
session_start();
require_once 'pdo.php';

if ( isset($_POST['cancel'] ) ) {

    header("Location: index.php");
    return;
}


$salt =  'XyZzy12*_';

if ( isset($_POST['email']) && isset($_POST['pass']) ) {
  unset($_SESSION["user"]);
  if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
      $_SESSION["error"]="User name and password are required";
      header("location: login.php");
      return;

    }
    elseif (str_contains($_POST['email'], '@')==false) {$_SESSION['error'] = "user must have an at-sign (@)";
    header("location: login.php");
     return;
} else {

    $check = hash('md5', $salt.$_POST["pass"]);
    $stmt = $pdo->prepare('SELECT user_id, name FROM users
        WHERE email = :em AND password = :pw');
    $stmt->execute(array( ':em' => $_POST['email'], ':pw' => $check));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ( $row !== false ) {
  $_SESSION['name'] = $row['name'];
  $_SESSION['user_id'] = $row['user_id'];{error_log("Login success ".$_POST['user']);


      header("Location: index.php");
      return; }
        } else {
          error_log("Login fail ".$_POST['user']." $check");
            $_SESSION["error"] = "Incorrect password";
            header("location: login.php");
            return;
        }
      }
}

?>
<!DOCTYPE html>
<html>
<head>

<title>Chris Tasber autos database</title>
</head>
<body>
<div class="container">
<h1>Please Log In</h1>
<?php

if ( isset($_SESSION['error']) ) {
  echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
  unset($_SESSION['error']);
}

?>

<script>
function doValidate() {
  console.log('Validating...');
  try {
  	pw = document.getElementById('id_1723').value;
em = document.getElementById('id_1724').value;
  	console.log("Validating pw="+pw); console.log("Validating em"=+em);
  	if (pw == null || pw == "" || em == null || em == "" ); {
             	alert("Both fields must be filled out");
             	return false;
         	}
         	return true;
     	} catch(e) {
         	return false;
     	}
     	return false;
 	}
</script>



<form method="POST">
<label for="label">user</label>
<input type="text" name="email" id="id_1724"><br/>
<label for="label">password</label>
<input type="password" name="pass" id="id_1723"><br/>
<input type="submit" onclick="return doValidate();" value="Log In">
<input type="submit" name="cancel" value="Cancel">
</form>


</div>
</body>
