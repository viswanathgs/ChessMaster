<?php 
  require_once("db_config.php");
  require_once("session_config.php");


//   include("chess.php");
//   $board=getInitialBoard();
//   $board=explodeBoard(implodeBoard($board));
//   $boardindex=array("A","B","C","D","E","F","G","H");
//   for($i=1;$i<8;$i++) {
//     foreach($boardindex as $j) {
//       echo $i.":".$j.":".$board[$j][$i]." ";
//     }
//     echo "<br />";
//   }

  $username=$_POST["username"];
  $sql='SELECT * FROM Users WHERE username="'.$username.'"';
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
?>
