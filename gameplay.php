<?php 
require_once("db_config.php");
require_once("session_config.php");

if (!isset($_SESSION["username"])) exit;

$username=$_SESSION["username"];
$gameid=intval($_GET["g"]);
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
      
  if ($row['turn'] != $username) {
    if (intval($row['changed']) == 1) {
      if ($row['winner'] != "") {
	$response=array("status"=>4, "winner"=>$row['winner']);
      }
      else {
	$response=array("status"=>1, "value"=>$row['value']);
      }
 
      $sql='UPDATE Games SET turn="'.$username.'" WHERE gameid='.$gameid;
      mysql_query($sql) or die('Error: '.mysql_error());
      
      $sql="UPDATE Games SET changed=0 where gameid=$gameid";
      mysql_query($sql) or die('Error: '.mysql_error());
    }
    else {
      $response=array("status"=>2, "value"=>$row['value']);
    }
  }
  else {
    if (intval($row['changed']) == 0) {
      $response=array("status"=>3, "value"=>$row['value']);
    }
    else {
      $response=array("status"=>2, "value"=>$row['value']);
    }
  }
}

if ($query == "update") {
  $button_clicked=intval($_GET['b']);
  
  $sql="SELECT * FROM Games WHERE gameid=$gameid";
  $result=mysql_query($sql) or die('Error: '.mysql_error());
  $row=mysql_fetch_array($result);

  $value=$row['value'];
  $value=$value-$button_clicked;
  
  $sql="UPDATE Games SET value=$value WHERE gameid=$gameid";
  mysql_query($sql) or die('Error: '.mysql_error());

  $sql="UPDATE Games SET changed=1 WHERE gameid=$gameid";
  mysql_query($sql) or die('Error: '.mysql_error());

  if ($value == 0) {
    $sql='UPDATE Games SET winner="'.$username.'" WHERE gameid='.$gameid;
    mysql_query($sql) or die('Error: '.mysql_error());
    
    $response=array("status"=>4, "winner"=>$username);
  }
  else {
    $response=array("status"=>2, "value"=>$value);
  }
}

if ($response==NULL)
  $response=array("status"=>-1, "value"=>-1);
echo json_encode($response);
?>