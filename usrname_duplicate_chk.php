<?php
  require_once("db_config.php");

  $username=$_POST["username"];

  if ($username == "") {
    echo 2;
  }
  else {
    $sql='SELECT * from Users WHERE username="'.$username.'"';
    $result=mysql_query($sql) or die('Error: '.mysql_error());
    echo mysql_num_rows($result);
  }
?>