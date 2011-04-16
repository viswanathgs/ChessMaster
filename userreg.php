<?php
  require_once("db_config.php");

  $username=$_POST["username"];
  $password=$_POST["password"];
  $cpassword=$_POST["cpassword"];
  $aboutme=$_POST["aboutme"];
  $country=$_POST["country"];
  $var="";

  $sql='SELECT * FROM Users WHERE username="'.$username.'"';
  $result=mysql_query($sql) or die('Error: '.mysql_error());
  
  if ($username == "")
    echo "Username cannot be blank";
  else if (mysql_num_rows($result) > 0) 
    echo "Pick a different username";
  else if ($password == "") 
    echo "Password cannot be blank";
  else if ($password != $cpassword)
    echo "Passwords do not match";
  else {
    $sql='INSERT INTO Users(username,password,aboutme,country) VALUES("'.$username.'","'.$password.'","'.$aboutme.'","'.$country.'")';
    mysql_query($sql) or die('Error: '.mysql_error());
    echo "1";
  }
?>