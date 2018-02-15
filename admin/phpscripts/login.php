<?php

	function logIn($username, $password, $ip) {
		require_once('connect.php');
		if($_SESSION['counter'] < 3){
			$username = mysqli_real_escape_string($link, $username);
			$password = mysqli_real_escape_string($link, $password);
			$loginstring = "SELECT * FROM tbl_user WHERE user_name='{$username}' AND user_pass='{$password}'";
			$user_set = mysqli_query($link, $loginstring);
			//echo mysqli_num_rows($user_set);
			if(mysqli_num_rows($user_set)){
				$founduser = mysqli_fetch_array($user_set, MYSQLI_ASSOC);
				$id = $founduser['user_id'];
				$_SESSION['user_id'] = $id;
				$_SESSION['user_name']= $founduser['user_fname'];
				$currTime = date('Y-m-d H:i:s');
				if(mysqli_query($link, $loginstring)){
					$update = "UPDATE tbl_user SET user_ip='{$ip}', user_date='{$currTime}' WHERE user_id={$id}";
					$updatequery = mysqli_query($link, $update);
				}
				redirect_to("admin_index.php");
			}else{
				$_SESSION['counter']++;
				$message = "Your username or password is invalid.";
				return $message;
			}
			mysqli_close($link);
		}
		else{
			$message = "You tried too many times, please wait until your account becomes unblock.";
			return $message;
		}
	}
?>