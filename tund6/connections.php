<?php
	//$username = "Anna-Stiina Laidna";
	session_start();

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

require("header.php");

?>


  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse banner">
	<h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisada mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
	<li><a href="home.php">Tagasi pealehele!</a></li>
	<p><a href="?logout=1">Logi välja!</a></p>

	

</body>
</html>
