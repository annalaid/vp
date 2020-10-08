<?php
session_start();
//$username = "Anna-Stiina Laidna";
require("header.php");

//kui pole sisse sisseloginud
if(!isset($_SESSION["userid"])){
	//jõuga sisselogimise lehele
	header("Location: page.php");
}
//väljalogimine
if(isset($_GET["logout"])){
	session_destroy();
	header("Location: page.php");
	exit();
}

?>

<img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse banner">
<h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?> programmeerib veebi</h1>
<p>See veebileht on loodud õppetöö käigus ning ei sisalokiokida mingit tõsiseltvõetavat sisu!</p>
<p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>

<ul>
  <li><a href="home.php">Tagasi pealehele!</a></li>
  <li><a href="?logout=1">Logi välja!</a></li>
</ul>
  <form method="POST">
  <label>Sisesta oma tänane mõtetu mõte!</label>
  <input type="text" name="nonsens" placeholder="mõttekoht">
  <input type="submit" value="Saada ära!" name="submitnonsens">
	<hr>
  </form>
</body>
</html>
