<?php 
require_once("db_config.php");
require_once("session_config.php");

$username=$_GET["u"];

$sql='UPDATE Users SET status="waiting" WHERE username="'.$username.'"';
mysql_query($sql) or die('Error: '.mysql_error());
$sql='SELECT * FROM Users where username!="'.$username.'" and status="waiting"';
$result=mysql_query($sql) or die('Error: '.mysql_error());

$response="";

if (mysql_num_rows($result) > 0) {
	$row=mysql_fetch_array($result);
	$opponent=$row['username'];
	
	$sql='DELETE FROM Games where player1="'.$username.'" or player1="'.$opponent.'" or player2="'.$username.'" or player2="'.$opponent.'"';
	mysql_query($sql) or die('Error: '.mysql_error());

	$sql='INSERT INTO Games(player1, player2, turn, value) values("'.$username.'", "'.$opponent.'", "'.$username.'", 10)';
	mysql_query($sql) or die('Error: '.mysql_error());

	$sql='SELECT gameid FROM Games WHERE player1="'.$username.'" and player2="'.$opponent.'"';
	$result=mysql_query($sql) or die('Error: '.mysql_error());
	$row=mysql_fetch_array($result);
	$gameid=$row['gameid'];

	$sql='UPDATE Users SET gameid='.$gameid.' WHERE username="'.$username.'" or username="'.$opponent.'"';
	mysql_query($sql);
	$sql='UPDATE Users SET status="ingame" WHERE username="'.$username.'" or username="'.$opponent.'"';
	mysql_query($sql);

	$response=$opponent;
}
else {
	while(1) {
		$sql='SELECT * FROM Users WHERE username="'.$username.'"';
		$result=mysql_query($sql) or die('Error: '.mysql_error());
		$row=mysql_fetch_array($result);
		$status=$row['status'];

		if ($status == "ingame") {
			$gameid=$row['gameid'];

			$sql='SELECT * FROM Games WHERE gameid='.$gameid;
			$result=mysql_query($sql) or die('Error: '.mysql_error());
			$row=mysql_fetch_array($result);

			if ($row['player1'] != $username) {
				$response=$row['player1'];
			}
			else {
				$response=$row['player2'];
			}
			break;
		}

		sleep(1);
	}
}

echo $response;

?>
