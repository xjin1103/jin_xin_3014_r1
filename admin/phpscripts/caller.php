<?php
  //this file is not called through config.phpinfo
  require_once("config.php");

  if(isset($_GET['caller_id'])){
    $dir = $_GET['caller_id'];
    if($dir == "logout"){
      logged_out();
    }else{
      echo "Caller id was passed incorrectly.";
    }
  }


 ?>
