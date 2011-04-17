<?php 
  require_once("db_config.php");
  require_once("session_config.php");

  $_SESSION['username']=$_POST['username'];

  if (isset($_POST['remember']) and $_POST['remember'] == "yes") {
    setcookie("username", $_SESSION['username'], time()+3600);
  }

  echo "";
?>
