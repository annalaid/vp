<?php
//loeme andmebaasi login info muutujad
require("../../../config.php");
//kui kasutaja on vormis andmeid saatnud, siis salvestame andmebaasi
require("fnc_film.php");

$username = "Anna-Stiina Laidna";
require("header.php");

?>

<img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse banner">
<h1><?php echo $username; ?> programmeerib veebi</h1>
<p>See veebileht on loodud õppetöö käigus ning ei sisalokiokida mingit tõsiseltvõetavat sisu!</p>
<p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
<ul>
  <li><a href="home.php">Tagasi pealehele!</a></li>
</ul>
<hr>
<?php echo readfilms(); ?>
</body>
</html>
