<?php
  require_once("db_config.php");
  require_once("session_config.php");

  if (!isset($_SESSION['username'])) exit;
  
  $username=$_SESSION['username'];
  $gameid=$_GET['g'];
  $curtime=date("YmdHis",time());

  $sql=NULL;
  if (!isset($_SESSION['lastget'])) {
    $sql='SELECT username, message FROM Chats WHERE gameid='.$gameid.' and postedon < "'.$curtime.'" ORDER BY postedon';
  }
  else {
    $sql='SELECT username, message FROM Chats WHERE gameid='.$gameid.' and postedon >= "'.$_SESSION['lastget'].'" and postedon < "'.$curtime.'" ORDER BY postedon';
  }
  
  $result=mysql_query($sql) or die('Error: '.mysql_error());
  $_SESSION['lastget']=$curtime;

  $response=array();
  while ($row=mysql_fetch_array($result)) {
      $response[]=array("username"=>$row['username'], "message"=>$row['message']);
  }
  
  echo json_encode($response);
?>