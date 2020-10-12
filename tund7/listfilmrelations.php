<?php
require("session.php");
require("header.php");
require("../../../config.php");
require("fnc_filmoutput.php");
$sortby = 0;
$sortorder = 0;
 ?>

 <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
 <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?> programmeerib veebi</h1>
 <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
 <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
 <ul>
   <li><a href="home.php">Avalehele</a></li>
 <li><a href="?logout=1">Logi välja</a>!</li>
 <br>
 <?php
 if(isset($_GET["sortby"]) and isset($_GET["sortorder"])){
   if($_GET["sortby"] >= 1 and $_GET["sortby"] <= 4){
     $sortby = $_GET["sortby"];
   }
     if($_GET["sortorder"] >= 1 and $_GET["sortorder"] == 2){
       $sortorder = $_GET["sortorder"];
 }
}
 echo readpersonsinfilm($sortby, $sortorder); 
 ?>
</body>
</html>
