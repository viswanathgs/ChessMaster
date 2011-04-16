<?php
  require_once("db_config.php");
  $username=$_POST["username"];
  $password=$_POST["password"];

  $sql='SELECT password FROM Users WHERE username="'.$username.'"';
  $result=mysql_query($sql) or die('Error: '.mysql_error());
  $row=mysql_fetch_array($result);
      
  if ($row['password'] == $password)
    echo "true";
  else 
    echo "false";
?>