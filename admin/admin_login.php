<?php
	require_once('phpscripts/config.php');
	$ip = $_SERVER['REMOTE_ADDR'];
	//echo $ip;
	if(isset($_POST['submit'])){
		//echo "Works";
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		if($username !== "" && $password !== ""){
			$result = logIn($username, $password, $ip);
			$message = $result;
		}else{
			$message = "Please fill out the required fields.";
		}
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="UTF-8">
		<title>Welcome to your admin panel login</title>
		<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="../css/login.css">
	</head>
	<body>
		<div class="loginBox">
			<h2>USER LOGIN</h2>
			<?php if(!empty($message)){ echo "<p class='inputError'>" . $message . "</p>";} ?>
			<form action="admin_login.php" method="post">
				<label>Username:</label>
				<input type="text" name="username" value="">
				<br>
				<label>Password:</label>
				<input type="password" name="password" value="">
				<br><br>
				<input type="submit" name="submit" value="LOGIN">
			</form>
		</div>
	</body>
</html>