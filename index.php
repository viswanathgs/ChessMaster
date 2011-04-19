<?php 
  require_once("session_config.php");

  if (isset($_SESSION['username'])) {
    unset($_SESSION['username']);
  }

  if (isset($_COOKIE['username'])) {
    $_SESSION['username'] = $_COOKIE['username'];
    header("Location: profile.php");
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
<meta charset="utf-8" />
<title>ChessMaster Club - Login</title>

<link rel="stylesheet" type="text/css" href="css/common.css"/>

<script language="javascript" type="text/javascript" src="jquery.js"></script>
<script language="javascript" type="text/javascript" src="common.js"></script>

<script type="text/javascript">
var retval;
function init()
{
  $("#info").hide();
  $("#globalvar").hide();
}

function chk_callback(x)
{
  if(x=="false")
  {
    $("#info").html("Incorrect username and password. Register if you are a new user.");
    $("#info").fadeIn("slow");	
  }
}

function goToLogin() {
  var remember = "";
  if (document.getElementById("remember").checked) remember = "yes";
  else remember = "no";

  $.ajax({
    type: "POST",
    url: "login.php",
    async:false,
    data: "username=" + $("#username").val() +"&remember="+remember,
    success: function(data){
      window.location = "profile.php";
    }
  });
}

function chk()
{
  var retval;
  
  $.ajax({
    type: "POST",
    url: "check.php",
    async:false,
    data: "username=" + $("#username").val()+ "&password="+$("#password").val() ,
    success: function(data){
      chk_callback(data); 
      $("#globalvar").html(data);
    }
  });

  if($("#globalvar").html() == "true") {
    $("#logindiv").children().hide('slow');
    setTimeout(goToLogin,500);
  }
}

function goToRegpage() {
  window.location="regpage.php";
}
 
function register() {
  $("#logindiv").children().hide('slow');
  setTimeout(goToRegpage,500);
}
</script>

</head>

<body onload="init()">
<div id="outer">

<div id="header">
<a href="index.php"><img border="0" src="images/logo.png" /></a>
</div>

<div id="main">
<div class="logindiv" id="logindiv">
<div id="val"></div>
<span id="globalvar"></span>

<fieldset class="loginfield"><legend>Login</legend>
<form autocomplete="on" method="POST" action="login.php" onsubmit="return chk();" onkeydown="if (event.keyCode == 13) document.getElementById('loginbutton').click()">
<table class="logintable">
<tr><td>
<label for="username"><p>
Username or email</label></p> <input name="username" id="username" type="text" />
</td></tr>
<tr><td>
<label for="password"><p>
Password </label></p><input name="password" id="password" type="password" /> 
</td></tr>
<tr><td></td></tr>
<div id="info" class="info"></div>

<tr><td>
<input type="checkbox" value="yes" name="remember" id="remember" />Remember Me<br />
</td></tr>

<tr><td>
<input type="button" value="Login" onclick="chk()" id="loginbutton" />
<input type="button" onclick="register()" value="Register" />
</td>
</tr>
</table>
</form></fieldset>
</div>
</div>
</div>
</body>

</html>
