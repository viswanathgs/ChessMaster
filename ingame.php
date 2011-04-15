<?php
  require_once("db_config.php");
  require_once("session_config.php");

  if (!isset($_SESSION['username'])) exit;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="js/ajax.js"></script>

<script language="javascript" type="text/javascript">
var username;
var gameid;

function performMove(button_clicked) {
  var gameobj = document.getElementById("gamevalue");
  gameobj.value = parseInt(gameobj.value) - parseInt(button_clicked);
  gameobj.innerHTML = gameobj.value;
 
  document.getElementById("button1").disabled = true;
  document.getElementById("button2").disabled = true;
 
  var xmlhttp = createXMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      var jsonText = xmlhttp.responseText;
      var jsonObject = eval('('+jsonText+')');

      if (jsonObject.status == 2) {
	setTimeout(playGame,1000);
      }
      else if (jsonObject.status == 4) {
	document.getElementById("gamevalue").value = jsonObject.value;
	document.getElementById("gamevalue").innerHTML = jsonObject.value;

	if (jsonObject.winner == username)
	  document.getElementById("result").innerHTML = "You won!";
	else
	  document.getElementById("result").innerHTML = "You lost!";
      }
    }
  }
  xmlhttp.open("GET","gameplay.php?&t="+Math.random()+"&g="+gameid+"&q=update&b="+button_clicked);
  xmlhttp.send();  
}

function playGame() {
  var xmlhttp = createXMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      var jsonText = xmlhttp.responseText;
      var jsonObject = eval('('+jsonText+')');
    
      if (jsonObject.status == 1) {
	document.getElementById("gamevalue").value = jsonObject.value;
	document.getElementById("gamevalue").innerHTML = jsonObject.value;
	setTimeout(playGame,1000);
      }
      else if (jsonObject.status == 2) {
	setTimeout(playGame,1000);
      }
      else if (jsonObject.status == 3) {
	var value = parseInt(document.getElementById("gamevalue").value);

	if (value > 0) document.getElementById("button1").disabled = false;
	else document.getElementById("button1").disabled = true;
	if (value > 1) document.getElementById("button2").disabled = false;
	else document.getElementById("button2").disabled = true;
      }
      else if (jsonObject.status == 4) {
	document.getElementById("gamevalue").value = jsonObject.value;
	document.getElementById("gamevalue").innerHTML = jsonObject.value;

	if (jsonObject.winner == username)
	  document.getElementById("result").innerHTML = "You won!";
	else
	  document.getElementById("result").innerHTML = "You lost!";
      }
    }
  }

  xmlhttp.open("GET","gameplay.php?&t="+Math.random()+"&g="+gameid+"&q=turn",true);
  xmlhttp.send();
}

function setupGame() {
  document.getElementById("gamevalue").innerHTML = 10;
  document.getElementById("gamevalue").value = 10;

  // Initially set the buttons disabled
  document.getElementById("button1").disabled = true;
  document.getElementById("button2").disabled = true;

  xmlhttp = createXMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
      var jsonText = xmlhttp.responseText;
      var jsonObject = eval('('+jsonText+')');
      
      username = jsonObject.username;
      gameid = parseInt(jsonObject.gameid);
     
      playGame();
    }
  }

  xmlhttp.open("GET","gameplay.php?&t="+Math.random()+"&q=get",true);
  xmlhttp.send(); 
}

</script>
</head>
<body onload="setupGame()">

<div name="gamevalue" id="gamevalue" value=-1></div> <br />
<div name="gamebutton1" id="gamebutton1">
<input type="button" name="button1" id="button1" value="-1" onclick="performMove(1)" />
</div>
<div name="gamebutton2" id="gamebutton2">
<input type="button" name="button2" id="button2" value="-2" onclick="performMove(2)" />
</div>
<div name="result" id="result"></div>

</body>
</html>