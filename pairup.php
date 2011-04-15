<?php 
require_once("db_config.php");
require_once("session_config.php");

if (!isset($_SESSION['username'])) exit;

$username=$_SESSION['username'];
$wait=intval($_GET["wait"]);

$response=NULL;
if ($wait == 0) {
  $sql='UPDATE Users SET status="waiting" WHERE username="'.$username.'"';
  mysql_query($sql) or die('Error: '.mysql_error());
  $sql='SELECT * FROM Users where username!="'.$username.'" and status="waiting"';
  $result=mysql_query($sql) or die('Error: '.mysql_error());

  if (mysql_num_rows($result) > 0) {
    $row=mysql_fetch_array($result);
    $opponent=$row['username'];
    
    $sql='DELETE FROM Games where player1="'.$username.'" or player1="'.$opponent.'" or player2="'.$username.'" or player2="'.$opponent.'"';
    mysql_query($sql) or die('Error: '.mysql_error());

    $sql='INSERT INTO Games(player1, player2, turn, board, changed, winner) values("'.$username.'", "'.$opponent.'", "'.$username.'", "'."10".'", 0, "")';
    mysql_query($sql) or die('Error: '.mysql_error());

    $sql='SELECT gameid FROM Games WHERE player1="'.$username.'" and player2="'.$opponent.'"';
    $result=mysql_query($sql) or die('Error: '.mysql_error());
    $row=mysql_fetch_array($result);
    $gameid=$row['gameid'];

    $sql='UPDATE Users SET gameid='.$gameid.' WHERE username="'.$username.'" or username="'.$opponent.'"';
    mysql_query($sql);
    $sql='UPDATE Users SET status="ingame" WHERE username="'.$username.'" or username="'.$opponent.'"';
    mysql_query($sql);

    $response=array("opponent"=>$opponent,"gameid"=>$gameid);
  }
  else {
    $response=array("opponent"=>"","gameid"=>-1);
  }
}
else {
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
      $response=array("opponent"=>$row['player1'],"gameid"=>$gameid);
    }
    else {
      $response=array("opponent"=>$row['player2'],"gameid"=>$gameid);
    }
  }
  else {
    $response=array("opponent"=>"","gameid"=>-1);
  }
}

$response_json=json_encode($response);
echo $response_json;
?>
