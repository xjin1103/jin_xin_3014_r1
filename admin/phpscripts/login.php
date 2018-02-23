<?php

	function logIn($username, $password, $ip) {
		require_once('connect.php');
		date_default_timezone_set('America/Toronto');
		$checkAttempt = "SELECT * FROM tbl_attempt WHERE attempt_ip = '{$ip}'";
		$checkResult = mysqli_query($link, $checkAttempt);
		$counter = 0;
		if(mysqli_num_rows($checkResult)){
			$att = mysqli_fetch_array($checkResult, MYSQLI_ASSOC);
			if($att['attempt_count'] > 3){
				$message = "Your account has been blocked.";
				return $message;
			}
			else{
				$username = mysqli_real_escape_string($link, $username);
				$password = mysqli_real_escape_string($link, $password);
				$loginstring = "SELECT * FROM tbl_user WHERE user_name='{$username}'";
				$user_set = mysqli_query($link, $loginstring);
				if(mysqli_num_rows($user_set)){
					$founduser = mysqli_fetch_array($user_set, MYSQLI_ASSOC);
					//password verify
					if (password_verify($password, $founduser['user_pass'])) {
						$id = $founduser['user_id'];
						$_SESSION['user_id'] = $id;
						$_SESSION['user_name']= $founduser['user_fname'];
						$currTime = date('Y-m-d H:i:s');
						//update Login successful time
						$update = "UPDATE tbl_user SET user_ip='{$ip}', user_date='{$currTime}' WHERE user_id={$id}";
						$updatequery = mysqli_query($link, $update);
						//remove record from attempt history
						$delAttempt = "DELETE * FROM tbl_attempt WHERE attempt_ip = '{$ip}'";
						$delResult = mysqli_query($link, $delAttempt);
						redirect_to("admin_index.php");
					}
					else{
						$counter = $att['attempt_count'] + 1;
						$updateAttempt = "UPDATE tbl_attempt SET attempt_count = '{$counter}' WHERE attempt_ip = '{$ip}'";
						$updateResult = mysqli_query($link, $updateAttempt);
						$message = "Your password is invalid.";
						return $message;
					}
				}else{
					//make the current attempt times plus 1
					$counter = $att['attempt_count'] + 1;
					$updateAttempt = "UPDATE tbl_attempt SET attempt_count = '{$counter}' WHERE attempt_ip = '{$ip}'";
					$updateResult = mysqli_query($link, $updateAttempt);
					$message = "Your username is invalid.";
					return $message;
				}
				mysqli_close($link);				
			}
		}
		else{
			$username = mysqli_real_escape_string($link, $username);
			$password = mysqli_real_escape_string($link, $password);
			$loginstring = "SELECT * FROM tbl_user WHERE user_name='{$username}' AND user_pass='{$password}'";
			$user_set = mysqli_query($link, $loginstring);
			//echo mysqli_num_rows($user_set);
			if(mysqli_num_rows($user_set)){
				$founduser = mysqli_fetch_array($user_set, MYSQLI_ASSOC);
				if (password_verify($password, $founduser['user_pass'])) {
					$id = $founduser['user_id'];
					$_SESSION['user_id'] = $id;
					$_SESSION['user_name']= $founduser['user_fname'];
					$currTime = date('Y-m-d H:i:s');
					if(mysqli_query($link, $loginstring)){
						$update = "UPDATE tbl_user SET user_ip='{$ip}', user_date='{$currTime}' WHERE user_id='{$id}'";
						$updatequery = mysqli_query($link, $update);
					}
					redirect_to("admin_index.php");
				}else{
					$createAttempt = "INSERT INTO tbl_attempt (attempt_count, attempt_ip) VALUES ('1', '{$ip}')";
					$createResult = mysqli_query($link, $createAttempt);
					$message = "Your password is invalid.";
					return $message;
				}
			}else{
				$createAttempt = "INSERT INTO tbl_attempt (attempt_count, attempt_ip) VALUES ('1', '{$ip}')";
				$createResult = mysqli_query($link, $createAttempt);
				$message = "Your username is invalid.";
				return $message;
			}
			mysqli_close($link);
		}
	}
?>