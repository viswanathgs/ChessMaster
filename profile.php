<?php
  require_once("db_config.php");
  require_once("session_config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<script language="javascript" type="text/javascript">
function pairUp(username) {
	document.getElementById("status").innerHTML = "Waiting for players...";
	var xmlhttp;
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	}
	else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById("status").innerHTML = "Paired up with "+xmlhttp.responseText;
		}
	}

	xmlhttp.open("GET","pairup.php?u="+username,true);
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

<div name="status" id="status"></div>
</body>
</html>
