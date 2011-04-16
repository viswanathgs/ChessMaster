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
   
  if (mysql_num_rows($result) > 0) 
    $var = "Username exists. Please choose a different username. <br />";
  
  if ($password !=$cpassword)
    $var=$var."Passwords do not match <br />";

  if (strlen($var) == 0) {
    $sql='INSERT INTO Users(username,password,aboutme,country) VALUES("'.$username.'","'.$password.'","'.$aboutme.'","'.$country.'")';
    mysql_query($sql) or die('Error: '.mysql_error());
    echo "1";
  }
  else {
    echo $var;
  }
?>