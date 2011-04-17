<?php 
  require_once("db_config.php");
  require_once("session_config.php");

  $_SESSION['username']=$_GET['username'];
  header("Location: profile.php");
?>
