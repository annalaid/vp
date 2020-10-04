<?php
	require("header.php");
  require("../../../config.php");
	$username = "Anna-Stiina Laidna";
?>


  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse banner">
	<h1><?php echo $username; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisada mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
    <ul>
     <li><a href = "nonsens.php">Siia saad sisestada oma mõtetu mõtte!</a></li>
     <li><a href="answers.php">Siit saad vaadata oma sisestatud mõtetuid mõtteid!</a></li>
     <li><a href="listfilms.php">Filmiinfo näitamine</a></li>
     <li><a href="addfilms.php">Filmiinfo lisamine</a></li>
    </ul>
	<br>
	<ul>
		<li><a href="users.php">Kasutajakonto loomine</a></li>
		<li><a href = "page.php">Tagasi pealehele!</a></li>
	</ul>

</body>
</html>
