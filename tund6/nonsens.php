<?php
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
require("../../../config.php");
  //kui kasutaja on vormis andmeid saatnud, siis salvestame andmebaasi
  $database = "if20_anna_laid_3";
  if(isset($_POST["submitnonsens"])){
	  if(!empty($_POST["nonsens"])){
		  //andmebaasi lisamine
		  //loome andmebaasi ühenduse
		  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
		  //valmistame ette SQL käsu
		  $stmt = $conn->prepare("INSERT INTO nonsens (nonsensidea) VALUES(?)");
		  echo $conn->error;
		  //s - string, i -integer, d-decimal
		  $stmt->bind_param("s", $_POST["nonsens"]);
		  $stmt->execute();
		  //käsk ja ühendus sulgeda
		  $stmt->close();
		  $conn->close();
	  }
  }
require("header.php");
?>

<img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse banner">
<h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?> programmeerib veebi</h1>
<p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
<p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>

<ul>
  <li><a href="home.php">Tagasi pealehele!</a></li>
  <li><a href="?logout=1">Logi välja</a>!</li>
</ul>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <label>Sisesta oma tänane mõtetu mõte!</label>
	  <input type="text" name="nonsens" placeholder="mõttekoht">
	  <input type="submit" value="Saada ära!" name="submitnonsens">
  </form>

</body>
</html>
