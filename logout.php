<?php 
  require_once("db_config.php");
  require_once("session_config.php");

  if (isset($_SESSION['username'])) {
    unset($_SESSION['username']);
  }

  session_unset();
  session_destroy();

  if (isset($_COOKIE['username'])) {
    unset($_COOKIE['username']);
  }
  setcookie("username", "", time() - 3600);  

  echo "";
?>