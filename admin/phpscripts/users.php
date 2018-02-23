<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;  

require($_SERVER["DOCUMENT_ROOT"] . './jin_xin_3014_r1/vendor/autoload.php');
  function createUser($fname, $username, $password, $email, $lvllist){
    include('connect.php');
    $hashedPWD = password_hash($password, PASSWORD_BCRYPT);
    $userstring = "INSERT INTO tbl_user (user_fname, user_name, user_pass, user_email, user_date, user_ip, user_level) VALUES('{$fname}','{$username}','{$hashedPWD}','{$email}', NULL, 'no','{$lvllist}')";//order is important, it has to matchup with the database
    //echo $userstring;
    $userquery = mysqli_query($link, $userstring);
    if($userquery){
      $userMsg = "<p>Hello " . $fname . ", you become a new user now. Please check your account info below:" . "</p><br/><li>User Name: " . $username . "</li>" . "<li>Password: " . $password . "</li><br/><p>Plese click <a href='http://localhost/login'>HERE</a> to login.</p>"; 
      //send email
      $mailToUser = new PHPMailer(true);  
          try {
              $mailToUser->isSMTP();
              //$mailToUser->SMTPDebug = 2;      
              $mailToUser->SMTPSecure = 'ssl';// Enable verbose debug output
              $mailToUser->Host = 'smtp.163.com';
              $mailToUser->SMTPAuth = true;
              $mailToUser->Username = 'wesley618@163.com'; 
              $mailToUser->Password = '68760273a';
              $mailToUser->Port = 465;  					
              $mailToUser->setFrom('wesley618@163.com', 'Admin');
              $mailToUser->addAddress($email);
              $mailToUser->isHTML(true);    
              $mailToUser->Subject = 'New User';
              $mailToUser->addReplyTo('wesley618@163.com', 'Admin');
              $mailToUser->Body = "<h2>New User</h2>" . $userMsg;                  
              $mailToUser->AltBody = "<h2>New User</h2>" . $userMsg;
              $mailToUser->send();
              $mailSuccessMsgUser = "Email has been sent."; 
              $message = "You have added a new user.";
              return $message;
              }
            catch (Exception $e) {
              echo 'Message could not be sent.';
              echo 'Mailer Error: ' . $mailToUser->ErrorInfo;
              $mailSuccessMsgUser = 'Message could not be sent. ' . 'Mailer Error: ' . $mailToUser->ErrorInfo;
              return $mailSuccessMsgUser;
              }
      redirect_to('admin_createuser.php');
    }else {
      $message = "Your hiring practices habe failed you.";
      return $message;
    }
      mysqli_close($link);
  }

?>
