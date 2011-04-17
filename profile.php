<?php
  require_once("db_config.php");
  require_once("session_config.php");

  if (!isset($_SESSION['username'])) exit;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>

<title>ChessMaster Club - Profile</title>

<link rel="stylesheet" type="text/css" href="css/common.css"/>
<link rel="stylesheet" type="text/css" href="css/profile.css"/>

<script language="javascript" type="text/javascript" src="jquery.js"></script>
<script language="javascript" type="text/javascript" src="common.js"></script>

<script language="javascript" type="text/javascript">
var username;
var gameid;
var gamecount, wincount, losecount, drawcount, rank;
var aboutme, country;
var usershistory;

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
	beginGame();
      }
    }
  }

  xmlhttp.open("GET","pairup.php?&t="+Math.random()+"&wait=1",true);
  xmlhttp.send();
}

function pairUp() {
  document.getElementById("startbutton").value = "Waiting for an opponent...";
  document.getElementById("startbutton").disabled = true;

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
	beginGame();
      }
    }
  }

  xmlhttp.open("GET","pairup.php?&t="+Math.random()+"&wait=0",true);
  xmlhttp.send();
}

function setInfo() {
  $("#profilelegend").html(username);
  $("#profilegamecount").html(gamecount);
  $("#profilewincount").html(wincount);
  $("#profilelosecount").html(losecount);
  $("#profiledrawcount").html(drawcount);
  $("#profileshell").html("abc");
  $("#profileaboutme").html("<div class='profileshell'>["+username+"@chessmaster]$ </div>"+aboutme);

  $("#historylegend").html(username+"'s history");

  var historytable = "";
  var alt = 0;
  for (var key in usershistory) {
    if (usershistory.hasOwnProperty(key)) {
      historytable += "<tr class='row"+alt+"' ><td>"+usershistory[key].opponent+"</td><td>"+usershistory[key].result+"</td><td>"+usershistory[key].playedon+"</td></tr>";
      alt = 1-alt;
    }
  }
  $("#historytablebody").html(historytable);

  $("#profile").children().show('slow');
  $("#history").children().show('slow');
}

function initHistory() {
  $.ajax({
    type: "GET",
    async: false,
    url: "profileinfo.php",
    data: "q=history",
    success: function(data) {
      usershistory = eval('('+data+')');
      setInfo();
    }
  });
}

function initInfo() {
  $("#profile").children().hide();
  $("#history").children().hide();

  $.ajax({
    type: "GET",
    async: false,
    url: "profileinfo.php",
    data: "q=user",
    success: function(data) {
      var jsonObject = eval('('+data+')');
 
      username = jsonObject.username;
      country = jsonObject.country;
      aboutme = jsonObject.aboutme;
      gamecount = parseInt(jsonObject.gamecount);
      wincount = parseInt(jsonObject.wincount);
      losecount = parseInt(jsonObject.losecount);
      drawcount = parseInt(jsonObject.drawcount);
      rank = parseInt(jsonObject.rank);
      
      initHistory();
    }
  });
}

function mouseOverButton() {
  document.getElementById("startbutton").style.backgroundColor = "#666666";
  document.getElementById("startbutton").style.borderTopColor = "#666666";
  document.getElementById("startbutton").style.borderBottomColor = "#666666";
  document.getElementById("startbutton").style.borderLeftColor = "#777777";
  document.getElementById("startbutton").style.borderRightColor = "#888888";
}

function mouseOutButton() {
  document.getElementById("startbutton").style.backgroundColor = "#999999";
  document.getElementById("startbutton").style.borderTopColor = "#999999";
  document.getElementById("startbutton").style.borderBottomColor = "#999999";
  document.getElementById("startbutton").style.borderLeftColor = "#AAAAAA";
  document.getElementById("startbutton").style.borderRightColor = "#BBBBBB";
}

function logout() {
  $.ajax({
    type: "GET",
    async: false,
    url: "logout.php",
    success: function(data) {
      window.location = "index.php";
    }
  });
}

function dummyFunction() {
  return true;
}

function pageExit() {
  $("#profile").children().hide('slow');
  $("#history").children().hide('slow');
  setTimeout(dummyFunction, 500);
}

</script>
</head>

<body onload="initInfo()" onbeforeunload="pageExit()">

<div class="topright">
<a href="#" onclick="logout(); return false;">Logout</a>
</div>

<div id="outer">
<div id="header">
<a href="index.php"><img border="0" src="images/logo.png" /></a>
</div>

<div class="right" id="startgame">
<input type="button" onclick="pairUp()" value="Enter Arena" id="startbutton" onMouseOver="mouseOverButton()" onMouseOut="mouseOutButton()"/>
<div name="status" id="status"></div>
</div>

<div id="main">
<div id="profile" class="logindiv">
<fieldset class="loginfield"> <legend id="profilelegend"></legend>

<div id="profileaboutme" class="profileaboutme"></div>
<br />
<div class="profileleft">Matches Played</div><div class="profileright" id="profilegamecount"></div><br /><br />
<div class="profileleft">Wins</div><div class="profileright" id="profilewincount"></div><br /><br />
<div class="profileleft">Losses</div><div class="profileright" id="profilelosecount"></div><br /><br />
<div class="profileleft">Draws</div><div class="profileright" id="profiledrawcount"></div><br /><br />

</fieldset>
</div>
<div class="_blank">&nbsp;</div>
<div id="history" class="logindiv">
<fieldset class="loginfield"><legend id="historylegend"></legend>

<div class="scrollTableHeader">
<table cellspacing="2px">
<thead>
<tr>
<th>Opponent</th>
<th>Result</th>
<th>Timestamp</th>
</tr>
</thead>
</table>
</div>

<div class="scrollTableContainer">
<table id="historytable" class="historytable" cellspacing="2px">
<tbody id="historytablebody">

</tbody>
</table>
</div>
</fieldset>
</div>
</div>
</div>

</body>
</html>
