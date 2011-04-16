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
	$("globalvar").hide();
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
		  else
			  $("#info").html("Username available");
  })  
}

function password_check() {
  $("#infopass").fadeOut("fast");
  $("#infopass").fadeIn("fast");
  
  if ($("#password").val() == $("#cpassword").val()) {
    $("#infopass").html("Passwords match");
  }
  else {
    $("#infopass").html("Passwords do not match");
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
 {
 	return true;
 }
 else
 return false;
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

<span id="globalvar"></span>
<form action="login.php" method="post" onsubmit="return insert_into_db();">
<table class="logintable">
<tr><td>
<label for="username"><p>
Username </p></label><input type="text" name="username" id="username" onblur="chk()"/> <div id="info" class="info"></div>
</td></tr>
<tr><td>
<label for="password"><p>
Password</p></label> <input type="password" name="password" id="password" /></td></tr>
<tr><td>
<label for="cpassword"><p>
Confirm Password</p></label> <input type="password" name="cpassword" id="cpassword" onblur="password_check()"/> <div id="infopass" class="info"></div>
</td></tr>
<tr><td>
<label for="aboutme"><p>
About Me</p></label> <textarea name="aboutme" id="aboutme"></textarea><br /></td></tr>
<tr><td>
<label for="country"><p>
Country</p></label> <input type="text" name="country" id="country" /></td></tr>
<tr><td>
<input type="submit" value="Create account"/></td></tr>

 <div id="error_info" class="info"> </div>
</table>
 </form>
</div>
</div>
</div>

</body>
</html>
