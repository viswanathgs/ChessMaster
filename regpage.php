<?php 
  require_once("session_config.php");

  if (isset($_SESSION['username'])) {
    unset($_SESSION['username']);
  }
?>

<html>
<head>
    
<title>ChessMaster Club - Registration</title>
 
<link rel="stylesheet" type="text/css" href="css/common.css"/>

 <script type="text/javascript" src="jquery.js"></script>
 <script type="text/javascript">
 
 function init()
 {
 	$("#info").hide();
 	$("#error_info").hide();
	$("#globalvar").hide();
	$("#logindiv").children().hide();
	$("#logindiv").children().show('slow');
 }
 
function chk_callback(data)
{
 	$("#error_info").fadeOut("fast");
 	$("#error_info").fadeIn("fast");
	$("#error_info").html(data);
} 
 
function chk()
{
  $.post("usrname_duplicate_chk.php", { username : $("#username").val() },
	  function(data) 
	  { 
		  $("#info").fadeOut("fast");
		  $("#info").fadeIn("fast");
		  if(data==1) 
			  $("#info").html("Username already taken"); 
		  else if (data == 2)
			  $("#info").html("Username cannot be blank");
		  else {
			  $("#info").html("Username "+$("#username").val()+" is available");
			  $("#info").css("color","green");
		  }
    
  })  
}

function password_check() {
  $("#infopass").fadeOut("fast");
  $("#infopass").fadeIn("fast");
  
  if ($("#password").val() == "") {
    $("#infopass").html("Password cannot be blank");
    $("#infopass").css("color","red");
  }
  else if ($("#password").val() == $("#cpassword").val()) {
    $("#infopass").html("Passwords match");
    $("#infopass").css("color","green");
  }
  else {
    $("#infopass").html("Passwords do not match");
    $("#infopass").css("color","red");
  }
}

 function insert_into_db()
 {
  $.ajax({
   type: "POST",
   url: "userreg.php",
   async:false,
   data: "username=" + $("#username").val()+ "&password="+ $("#password").val() + "&cpassword="+ $("#cpassword").val() + "&aboutme="+ $("#aboutme").val() + "&country="+ $("#country").val(),
   success: function(data){
      chk_callback(data); 
    
    $("#globalvar").html(data);
    $("#globalvar").hide();
     
   }
 });
 if($("#globalvar").html()=="1")
  return true;
 else
  return false;
 }

function goToLogin() {
  $.ajax({
    type: "POST",
    url: "login.php",
    async:false,
    data: "username=" + $("#username").val(),
    success: function(data){
      window.location = "profile.php";
    }
  });
}

function register() {
  if (insert_into_db()) {
    goToLogin();
  }
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

<span id="globalvar"></span>

<form action="login.php" method="post" onsubmit="return insert_into_db();" >
<!--<table class="logintable">-->
<!--<tr><td>-->
<fieldset name="loginfield" id="loginfield" class="loginfield"><legend>Registration</legend>
<div id="error_info" class="info"> </div>
<label class="reg" for="username">
Username </label><input class="reg" type="text" name="username" id="username" onblur="chk()"/> <div id="info" class="infolocal"></div>
<!--</td></tr>-->
<!--<tr><td>-->
<br /><br />
<label class="reg" for="password">
Password</label> <input class="reg" type="password" name="password" id="password" /><!--</td></tr>-->
<!--<tr><td>-->
<br />
<label class="reg" for="cpassword">
Confirm Password</label> <input class="reg" type="password" name="cpassword" id="cpassword" onblur="password_check()"/> <div id="infopass" class="infolocal"></div>
<!--</td></tr>-->
<!--<tr><td>-->
<br /><br />
<label class="reg" for="country">
Country</label> <input class="reg" type="text" name="country" id="country" /><!--</td></tr>-->
<!--<tr><td>-->
<br /><br />
<label class="reg" for="aboutme">
About Me</label> <textarea class="reg" name="aboutme" id="aboutme" rows="5" cols="25"></textarea><br /><!--</td></tr>-->
<!--<tr><td>-->
<input type="hidden" value="1" name="regpage" id="regpage" />
<label class="reg" for="submit">&nbsp;</label>
<input class="reg" name="submit" id="submit" type="button" value="Register" onclick="register()"/><!--</td></tr>-->
</fieldset>
<!--</table>-->
 </form>

</div>
</div>
</div>

</body>
</html>
