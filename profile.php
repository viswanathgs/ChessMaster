<?php
  require_once("db_config.php");
  require_once("session_config.php");

  if (!isset($_SESSION['username'])) exit;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="js/ajax.js"></script>

<script language="javascript" type="text/javascript">
var username;
var gameid;

function beginGame() {
  window.location = "ingame.php";
}

function pairUpCallback() {
  var xmlhttp = createXMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      var jsonText = xmlhttp.responseText;
      var jsonObject = eval('('+jsonText+')');
      var opponent = jsonObject.opponent;
      gameid = jsonObject.gameid;

      if (gameid == -1) {
	setTimeout(pairUpCallback,1000);
      }
      else {
	document.getElementById("status").innerHTML = "Paired up with "+opponent;
	beginGame();
      }
    }
  }

  xmlhttp.open("GET","pairup.php?&t="+Math.random()+"&wait=1",true);
  xmlhttp.send();
}

function pairUp(user) {
  username = user;
  document.getElementById("status").innerHTML = "Waiting for an opponent...";

  var xmlhttp = createXMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      var jsonText = xmlhttp.responseText;
      var jsonObject = eval('('+jsonText+')');
      var opponent = jsonObject.opponent;
      gameid = jsonObject.gameid;

      if (gameid == -1) {
	pairUpCallback();
      }
      else {
	document.getElementById("status").innerHTML = "Paired up with "+opponent;
	beginGame();
      }
    }
  }

  xmlhttp.open("GET","pairup.php?&t="+Math.random()+"&wait=0",true);
  xmlhttp.send();
}
</script>
</head>

<body>
<h2> <?php echo 'User '.$_SESSION['username'] ?> </h2>

<?php 
  $username=$_SESSION['username'];
  echo "<input type='button' name='pairup' id='pairup' value='Pair Up' onclick='pairUp(\"".$username."\")' /> <br/>";
?>

<div name="status" id="status"></div> <br />

</body>
</html>
