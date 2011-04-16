<?php 
  require_once("session_config.php");

  if (isset($_SESSION['username'])) {
    unset($_SESSION['username']);
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
<meta charset="utf-8" />
<title>ChessMaster Club - Login</title>

<link rel="stylesheet" type="text/css" href="css/common.css"/>

<script type="text/javascript" src="jquery.js"></script>
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
  if($("#globalvar").html() == "false")
    return false;
  else
    return true;
}
 
function register() {
 window.location="regpage.php";
}
</script>

</head>

<body onload="init()">
<div id="outer">

<div id="header">
<img src="images/logo.png" />
</div>

<div id="main">
<div class="logindiv">
<div id="val"></div>
<span id="globalvar"></span>
<form autocomplete="on" method="POST" action="login.php" onsubmit="return chk();">

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
<input type="submit" value="Login" />
<input type="button" onclick="register()" value="Register" />
</td>
</tr>
</table>
</form>
</div>
</div>
</div>
</body>

</html>
