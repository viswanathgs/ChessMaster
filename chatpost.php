<?php
  require_once("db_config.php");
  require_once("session_config.php");

  if (!isset($_SESSION['username'])) exit;

  $username=$_SESSION['username'];
  $gameid=$_POST['g'];
  $message=$_POST['m'];

  $sql='INSERT INTO Chats(gameid,username,message) VALUES('.$gameid.',"'.$username.'","'.$message.'")';
  mysql_query($sql) or die('Error: '.mysql_error());

  echo "return";
?>