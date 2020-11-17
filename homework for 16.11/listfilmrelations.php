<?php
require("session.php");
require("header.php");
require("../../../config.php");
require("fnc_filmoutput.php");

$sortby = "";
$filmsortby = "";
$personsortby = "";
$quotesortby = "";
$genresortby = "";
$studiosortby = "";
$positionsortby = "";
$genreinfosortby = "";

$sortorder = "";
$filmsortorder = "";
$personsortorder = "";
$quotesortorder = "";
$genresortorder = "";
$studiosortorder = "";
$positionsortorder = "";
$genreinfosortorder = "";
 ?>

 <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
 <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?> programmeerib veebi</h1>
 <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
 <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
 <ul>
   <li><a href="home.php">Avalehele</a></li>
 <li><a href="?logout=1">Logi välja</a>!</li>
 <br>
</div>
<div id="persons">
  <h2>Isikud</h2>
  <?php
  if(isset($_GET["personsortby"]) and isset($_GET["personsortorder"])){
    if($_GET["personsortby"] >= 1 and $_GET["personsortorder"] <= 3){
      $personsortby = $_GET["personsortby"];
    }
    if($_get["personsortorder"] == 1 or $_GET["personsortorder"] == 2){
      $personsortorder = $_GET["personsortorder"];
    }
  }
  echo readpersons($personsortby, $personsortorder)
   ?>
 </div>
 <div id="movies">
   <h2>Filmid</h2>
   <?php
   if(isset($_GET["filmsortby"]) and isset($_GET["filmsortorder"])){
      if($_GET["filmsortby"] >= 1 and $_GET["filmsortby"] <= 3){
        $filmsortby = $_GET["filmsortby"];
      }
        if($_GET["filmsortorder"] == 1 or $_GET["filmsortorder"] == 2){
          $filmsortorder = $_GET["filmsortorder"];
    }
   }
    echo readfilms($filmsortby, $filmsortorder);
    ?>
</div>
<div id="personsinmovie">
  <h2>Isikud filmis</h2>
 <?php
if(isset($_GET["sortby"]) and isset($_GET["sortorder"])){
   if($_GET["sortby"] >= 1 and $_GET["sortby"] <= 4){
     $sortby = $_GET["sortby"];
   }
     if($_GET["sortorder"] == 1 or $_GET["sortorder"] == 2){
       $sortorder = $_GET["sortorder"];
 }
}
 echo readpersonsinfilm($sortby, $sortorder);
 ?>
</div>
<div id="quotes">
  <h2>Tsitaadid</h2>
 <?php
if(isset($_GET["quotesortby"]) and isset($_GET["quotesortorder"])){
   if($_GET["quotesortby"] >= 1 and $_GET["quotesortby"] <= 3){
     $quotesortby = $_GET["quotesortby"];
   }
     if($_GET["quotesortorder"] == 1 or $_GET["quotesortorder"] == 2){
       $quotesortorder = $_GET["quotesortorder"];
 }
}
 echo readquotes($quotesortby, $quotesortorder);
 ?>

 </div>
 <div id="genre">
   <h2>Žanrid</h2>
  <?php
 if(isset($_GET["genresortby"]) and isset($_GET["genresortorder"])){
    if($_GET["genresortby"] == 1){
      $genresortby = $_GET["genresortby"];
    }
      if($_GET["genresortorder"] == 1 or $_GET["genresortorder"] == 2){
        $genresortorder = $_GET["genresortorder"];
  }
 }
echo readgenres($genresortby, $genresortorder);
  ?>

</div>
<div id="genreinfo">
  <h2>Žanrite kirjeldus</h2>
 <?php
if(isset($_GET["genreinfosortby"]) and isset($_GET["genreinfosortorder"])){
   if($_GET["genreinfosortby"] == 1){
     $genresortby = $_GET["genreinfosortby"];
   }
     if($_GET["genreinfosortorder"] == 1 or $_GET["genreinfosortorder"] == 2){
       $genreinfosortorder = $_GET["genreinfosortorder"];
 }
}
echo readgenreinfo($genreinfosortby, $genreinfosortorder);
 ?>

</div>
<div id="studios">
  <h2>Filmistuudiod</h2>
 <?php
if(isset($_GET["studiosortby"]) and isset($_GET["studiosortorder"])){
   if($_GET["studiosortby"] == 1){
     $studiosortby = $_GET["studiosortby"];
   }
     if($_GET["studiosortorder"] >= 1 or $_GET["studiosortorder"] == 2){
       $studiosortorder = $_GET["studiosortorder"];
 }
}
 echo readstudios($studiosortby, $studiosortorder);
 ?>

</div>
<div id="positions">
  <h2>Positsioon</h2>
 <?php
if(isset($_GET["positionsortby"]) and isset($_GET["positionsortorder"])){
   if($_GET["positionsortby"] == 1){
     $positionsortby = $_GET["positionsortby"];
   }
     if($_GET["quotesortorder"] == 1 or $_GET["positionsortorder"] == 2){
       $positionsortorder = $_GET["positionsortorder"];
 }
}
 echo readpositions($positionsortby, $positionsortorder);
 ?>

</body>
</html>
