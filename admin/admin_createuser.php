<?php
  require_once('phpscripts/config.php');
	ini_set('display_errors',1);
	error_reporting(E_ALL);
	  //confirm_logged_in();
	//require_once('phpscripts/connect.php');
	if(isset($_POST['submit'])){
	  $fname = trim($_POST['fname']);
	  $username = trim($_POST['username']);
	  $password = trim($_POST['password']);
    $email = trim($_POST['email']);
    $lvllist = trim($_POST['lvllist']);
    if(!empty($fname) && !empty($username) && !empty($password) && !empty($email) && !empty($lvllist)){
      $result = createUser($fname, $username, $password, $email, $lvllist);
      $successmessage = $result;
    }
    else{
      if(empty($fname) || empty($username) || empty($password) || empty($email)){
        $errormessage = "Please fill in required info.";
      }
      if(empty($lvllist)){
        $errormessage = "Please select a user level.";
      }
    }
	}
 ?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <title>Create User</title>
  </head>

  <body>
    <div class="createUser">
      <h2>Create User</h2>
      <?php if(!empty($errormessage)){echo "<p class='errorMsg'>" . $errormessage . "</p>";}?>
      <?php if(!empty($successmessage)){echo "<p class='successMsg'>" . $successmessage . "</p>";}?>
      <form action="admin_createuser.php" method="post" class="createForm">
        <label>First Name:</label>
        <input type="text" name="fname" value="">
        <label>Username:</label>
        <input type="text" name="username" value="">
        <label>Paassword:</label>
        <input type="text" name="password" value="">
        <label>Email:</label>
        <input type="text" name="email" value="">
        <label>User Level:</label>
        <select name="lvllist">
       <option value="">Select User Level</option>
       <option value="2">Web admin</option>
       <option value="1">Web Master</option>
     </select><br><br>

        <input type="submit" name="submit" Password="submit" value="CREATE">
        <a href="admin_index.php">BACK</a>

      </form>
    </div>
  </body>

  </html>
