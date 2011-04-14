<?php
$db_host="localhost";
$db_name="chessmaster";
$username="testdb";
$password="testdb";

$db_con=mysql_connect($db_host,$username,$password);
$sql="CREATE DATABASE IF NOT EXISTS $db_name";
mysql_query($sql) or die('Error: '.mysql_error());
mysql_select_db($db_name);

$sql="DESC Users";
mysql_query($sql);
if (mysql_errno()==1146) {
	$sql="CREATE TABLE Users(username char(30), status char(10), gameid int, PRIMARY KEY(username), FOREIGN KEY(gameid) REFERENCES Games(gameid))";
	mysql_query($sql) or die('Error: '.mysql_error());
}

$sql="DESC Games";
mysql_query($sql);
if (mysql_errno()==1146) {
	$sql="CREATE TABLE Games(gameid int AUTO_INCREMENT, player1 char(30), player2 char(30), turn char(30), value int, primary key (gameid))";
	mysql_query($sql) or die('Error: '.mysql_error());
}

session_save_path("/tmp");
?>
