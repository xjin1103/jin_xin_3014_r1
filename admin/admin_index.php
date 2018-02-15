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
		<div class="last-time-login">
			<?php if(!empty($lastLoginTime)) echo "<p>Last Time Successful Login: " . $lastLoginTime . "</p>"; ?>
		</div>
		<div class="greetings">
			<?php	if($currentTime > "00:00:00" && $currentTime < "12:00:00"){ echo "Good morning, " . $_SESSION['user_name'] . ". Welcome to administration panel."; }
					if($currentTime > "12:00:00" && $currentTime < "17:00:00"){ echo "Good afternoon, " . $_SESSION['user_name'] . ". Welcome to administration panel."; }
					if($currentTime > "17:00:00" && $currentTime < "20:00:00"){ echo "Good evening, " . $_SESSION['user_name'] . ". Welcome to administration panel."; }
					if($currentTime > "20:00:00" && $currentTime < "24:00:00"){ echo "Good night, " . $_SESSION['user_name'] . ". Welcome to administration panel."; }	
			?>
		</div>
	</body>
</html>