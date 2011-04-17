<?php
  require_once("db_config.php");
  require_once("session_config.php");
  include("chess.php");

  if (!isset($_SESSION['username'])) exit;

  $username=$_SESSION['username'];
  $gameid=$_POST['g'];

  $sql='SELECT * FROM Games WHERE gameid='.$gameid;
  $result=mysql_query($sql) or die('Error: '.mysql_error());
  $row=mysql_fetch_array($result);
  $winner=$row['winner'];
  $opponent="";
  if ($row['player1'] == $username) $opponent=$row['player2'];
  else $opponent=$row['player1'];

  $sql='SELECT * FROM Users WHERE username="'.$username.'"';
  $result=mysql_query($sql) or die('Error: '.mysql_error());
  $row=mysql_fetch_array($result);
  $gamecount=intval($row['gamecount']);
  $wincount=intval($row['wincount']);
  $losecount=intval($row['losecount']);
  $drawcount=intval($row['drawcount']);

  $gamecount=$gamecount+1;
  $sql='UPDATE Users SET gamecount='.$gamecount.' WHERE username="'.$username.'"';
  mysql_query($sql) or die('Error: '.mysql_error());

  $result="";

  if ($winner == $username) {
    $result="Won";
    $wincount=$wincount+1;
    $sql='UPDATE Users SET wincount='.$wincount.' WHERE username="'.$username.'"';
    mysql_query($sql) or die('Error: '.mysql_error());
  }
  else if ($winner == "" || $winner == "Draw") {
    $result="Draw";
    $drawcount=$drawcount+1;
    $sql='UPDATE Users SET drawcount='.$drawcount.' WHERE username="'.$username.'"';
    mysql_query($sql) or die('Error: '.mysql_error());

    if ($winner != "Draw") {
      $sql='UPDATE Games SET winner="Draw" WHERE gameid='.$gameid;
      mysql_query($sql) or die('Error: '.mysql_error());
    }
  }
  else {
    $result="Lost";
    $losecount=$losecount+1;
    $sql='UPDATE Users SET losecount='.$losecount.' WHERE username="'.$username.'"';
    mysql_query($sql) or die('Error: '.mysql_error());
  }

  $sql='INSERT INTO UsersHistory(username,opponent,result) VALUES("'.$username.'","'.$opponent.'","'.$result.'")';
  mysql_query($sql) or die('Error: '.mysql_error());

  echo "1";
?>