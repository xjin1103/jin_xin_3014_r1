<?php
	session_start();
	require_once('phpscripts/connect.php');
	date_default_timezone_set('America/Toronto');
	$currentTime = date('H:i:s');
	if(isset($_SESSION['user_id'])){
		$user_id = $_SESSION['user_id'];
		$loginTime = "SELECT user_date FROM tbl_user WHERE user_id = '{$user_id}'";
		$find_user_login_time = mysqli_query($link, $loginTime);
		$lastLoginTime = "";
		if(mysqli_num_rows($find_user_login_time)){
			$founduser = mysqli_fetch_array($find_user_login_time, MYSQLI_ASSOC);
			$lastLoginTime = $founduser['user_date'];
		}
	}
	else{
		header("Location: admin_login.php");
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
	<meta charset="UTF-8">
	<title>Welcome to your admin panel</title>
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="../css/admin.css">
	</head>
	<body>
		<div class="adminPanel">
			<h2>Administration Panel</h2>
			<div class="last-time-login">
				<?php if(!empty($lastLoginTime)) echo "<p>Last Time Successful Login: " . $lastLoginTime . "</p>"; ?>
			</div>
			<div class="greetings">
				<?php	if($currentTime > "00:00:00" && $currentTime < "12:00:00"){ echo "<h3>Good morning, " . $_SESSION['user_name'] . ". Welcome to administration panel.</h3>"; }
						if($currentTime > "12:00:00" && $currentTime < "17:00:00"){ echo "<h3>Good afternoon, " . $_SESSION['user_name'] . ". Welcome to administration panel.</h3>"; }
						if($currentTime > "17:00:00" && $currentTime < "20:00:00"){ echo "<h3>Good evening, " . $_SESSION['user_name'] . ". Welcome to administration panel.</h3>"; }
						if($currentTime > "20:00:00" && $currentTime < "24:00:00"){ echo "<h3>Good night, " . $_SESSION['user_name'] . ". Welcome to administration panel.</h3>"; }	
				?>
			</div>
			<div class="navigation">
				<a href="admin_createuser.php">Create User</a>
				<a href="phpscripts/caller.php?caller_id=logout">Sign Out</a>
			</div>
		</div>
	</body>
</html>