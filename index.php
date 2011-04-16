<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
<head>
<meta charset="utf-8" />
<title>ChessMaster Club</title>

<style type="text/css">
h1{font-size:138.5%;}h2{font-size:123.1%;}h3{font-size:108%;}h1,h2,h3{margin:1em 0;}h1,h2,h3,h4,h5,h6,strong{font-weight:bold;}abbr,acronym{border-bottom:1px dotted #000;cursor:help;} em{font-style:italic;}blockquote,ul,ol,dl{margin:1em;}ol,ul,dl{margin-left:2em;}ol li{list-style:decimal outside;}ul li{list-style:disc outside;}dl dd{margin-left:1em;}th,td{border:1px solid #000;padding:.5em;}th{font-weight:bold;text-align:center;}caption{margin-bottom:.5em;text-align:center;}p,fieldset,table,pre{margin-bottom:1em;}input[type=text],input[type=password],textarea{width:12.25em;*width:11.9em;}
</style>

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
 window.location="regpage.html";
}
</script>

</head>

<body onload="init()">
<div id="val"></div>
<span id="globalvar"></span>
<form autocomplete="on" method="POST" action="login.php" onsubmit="return chk();">
Username <input name="username" id="username" type="text" /> <br />
Password <input name="password" id="password" type="password" /> <br />
<input type="submit" />
<input type="button" onclick="register()" value="Register" />
</form>
<div id="info"> </div>
</body>

</html>
