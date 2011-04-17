<?php 
  require_once("db_config.php");
  require_once("session_config.php");

  if (!isset($_SESSION['username'])) {
    unset($_SESSION['username']);
  }

  echo "";
?>