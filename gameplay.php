<?php 
require_once("db_config.php");
require_once("session_config.php");
include("chess.php");

if (!isset($_SESSION["username"])) exit;

$username=$_SESSION["username"];
if (isset($_GET["g"])) {
  $gameid=intval($_GET["g"]);
}
$query=$_GET["q"];

/*
Return values:
1. Perform update for user
2. Wait for opponent to play
3. User's turn to play
4. Game over
*/
$response = NULL;
if ($query == "turn") {
  $sql="SELECT * FROM Games WHERE gameid=$gameid";
  $result=mysql_query($sql) or die('Error: '.mysql_error());
  $row=mysql_fetch_array($result);

  if ($row['winner'] != "") {
      $response=array("status"=>4, "winner"=>$row['winner'], "board"=>explodeBoard($row['board']));
  }
  else if ($row['turn'] != $username) {
    if (intval($row['changed']) == 1) {
      $response=array("status"=>1, "board"=>explodeBoard($row['board']));
      
      $sql='UPDATE Games SET turn="'.$username.'" WHERE gameid='.$gameid;
      mysql_query($sql) or die('Error: '.mysql_error());
      
      $sql="UPDATE Games SET changed=0 where gameid=$gameid";
      mysql_query($sql) or die('Error: '.mysql_error());
    }
    else {
      $response=array("status"=>2, "board"=>explodeBoard($row['board']));
    }
  }
  else {
    if (intval($row['changed']) == 0) {
      $response=array("status"=>3, "board"=>explodeBoard($row['board']));
    }
    else {
      $response=array("status"=>2, "board"=>explodeBoard($row['board']));
    }
  }
}

if ($query == "update") {
  $colf=$_GET['colf'];
  $rowf=intval($_GET['rowf']);
  $colt=$_GET['colt'];
  $rowt=intval($_GET['rowt']);
  
  $sql="SELECT * FROM Games WHERE gameid=$gameid";
  $result=mysql_query($sql) or die('Error: '.mysql_error());
  $row=mysql_fetch_array($result);

  $board=explodeBoard($row['board']);

  $win=0;
  if ($board[$colt][$rowt] == "WK" or $board[$colt][$rowt] == "BK") {
    $win=1;
  }
  $board[$colt][$rowt]=$board[$colf][$rowf];
  $board[$colf][$rowf]="";
  $boardtext=implodeBoard($board);

  $sql='UPDATE Games SET board="'.$boardtext.'" WHERE gameid='.$gameid;
  mysql_query($sql) or die('Error: '.mysql_error());

  $sql="UPDATE Games SET changed=1 WHERE gameid=$gameid";
  mysql_query($sql) or die('Error: '.mysql_error());

  if ($win == 1) {
    $sql='UPDATE Games SET winner="'.$username.'" WHERE gameid='.$gameid;
    mysql_query($sql) or die('Error: '.mysql_error());
    
    $response=array("status"=>4, "winner"=>$username, "board"=>$board);
  }
  else {
    $response=array("status"=>2, "board"=>$board);
  }
}

if ($query == "get") {
  $sql='SELECT * FROM Users WHERE username="'.$username.'"';
  $result=mysql_query($sql) or die('Error: '.mysql_error());
  $row=mysql_fetch_array($result);
  $gameid=$row['gameid'];
  
  $sql='SELECT * FROM Games WHERE gameid='.$gameid;
  $result=mysql_query($sql) or die('Error: '.mysql_error());
  $row=mysql_fetch_array($result);
  $board=explodeBoard($row['board']);
  $white=$row['white'];
  $opponent="";
  if ($row['player1'] == $username) $opponent=$row['player2'];
  else $opponent=$row['player1'];

  $response=array("username"=>$username, "gameid"=>$gameid, "board"=>$board, "white"=>$white, "opponent"=>$opponent);
}

echo json_encode($response);
?>