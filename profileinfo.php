<?php
  require_once("db_config.php");
  require_once("session_config.php");

  if (!isset($_SESSION['username'])) exit;

  $username=$_SESSION['username'];
  $query=$_GET['q'];

  $response="";
  if ($query=="user") {
    $sql='SELECT * FROM Users WHERE username="'.$username.'"';
    $result=mysql_query($sql) or die('Error: '.mysql_error());
    $response=mysql_fetch_array($result);
  }
  else if ($query=="history") {
    $sql='SELECT opponent, playedon, result FROM UsersHistory WHERE username="'.$username.'" ORDER BY playedon DESC';
    $result=mysql_query($sql) or die('Error: '.mysql_error());

    $response=array();
    while($row=mysql_fetch_array($result)) {
      $response[]=array("opponent"=>$row['opponent'], "result"=>$row['result'], "playedon"=>$row['playedon']);
    }
  }

  echo json_encode($response);
?>