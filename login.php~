<?php 
  require_once("db_config.php");
  require_once("session_config.php");

$username=$_POST["username"];
$sql='SELECT * FROM Users WHERE username="'.$username.'"';
echo $sql."<br />";
$result=mysql_query($sql,$db_con) or die('Error: '.mysql_error());

if (mysql_num_rows($result) == 0) {
	$sql='INSERT INTO Users(username, status) VALUES("'.$username.'","normal")';
	mysql_query($sql) or die('Error: '.mysql_error());
}
else {
	$sql='UPDATE Users SET status="normal" WHERE username="'.$username.'"';
	mysql_query($sql) or die('Error: '.mysql_error());
}

$_SESSION["username"]=$username;
header("Location: profile.php");

echo "reached";
?>
