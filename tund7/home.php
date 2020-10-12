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
	<p><a href="?logout=1">Logi välja!</a></p>
		<ul>
     <li><a href = "nonsens.php">Sisesta oma mõtetu mõte!</a></li>
     <li><a href="answers.php">Siit saad vaadata oma sisestatud mõtetuid mõtteid!</a></li>
		 <li><a href="addfilms.php">Filmiinfo lisamine</a></li>
		 <li><a href="listfilms.php">Filmiinfo näitamine</a></li>
		 <li><a href="addfilmrelations.php">Filmide seoste loomine</a></li>
		 <li><a href="listfilmrelations.php">Filmide nimekiri</a></li>
		 <li><a href="userprofile.php">Kasutaja profiili haldamine</a></li>
    </ul>
	<br>

</body>
</html>
