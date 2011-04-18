<?php
  require_once("db_config.php");
  require_once("session_config.php");

  if (!isset($_SESSION['username'])) exit;

  $username=$_SESSION['username'];

  $sql='UPDATE Users SET status="'."normal".'" WHERE username="'.$username.'"';
  mysql_query($sql) or die('Error: '.mysql_error());

  echo "1";
?>