<?php 
  require_once("db_config.php");
  require_once("session_config.php");

  $username=$_SESSION['username'];

  $sql='UPDATE Users SET status="'."normal".'" WHERE username="'.$username.'"';
  mysql_query($sql) or die('Error: '.mysql_error());

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