<?php
//loeme andmebaasi login info muutujad
require("../../../config.php");
//kui kasutaja on vormis andmeid saatnud, siis salvestame andmebaasi
require("fnc_film.php");
//kui klikiti nuppu, siis kontrollime ja salvestame
$inputerror = "";
if(isset($_POST["filmsubmit"])){
  if(empty($_POST["titleinput"]) or empty($_POST["genreinput"]) or empty($_POST["studioinput"]) or empty($_POST["directorinput"])){
    $inputerror .= "Osa vajalikku infot on sisestamata!";

  }
  if($_POST["yearinput"] > date("Y") or $_POST["yearinput"] < 1895){
    $inputerror .= " Ebareaalne valmimisaasta!";
  }
  if(empty($inputerror)){
    writefilm($_POST["titleinput"], $_POST["yearinput"], $_POST["durationinput"], $_POST["genreinput"], $_POST["studioinput"], $_POST["directorinput"]);
  }
}

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
  <form method="POST">
    <label for="titleinput">Filmi Pealkiri: </label>
    <input type="text" name="titleinput" id="titleinput" placeholder="pealkiri">
    <br>
    <label for="yearinput">Filmi Valmimisaasta: </label>
    <input type="number" name="yearinput" id="yearinput" value="<?php echo date ("y"); ?>">
    <br>
    <label for="durationinput">Filmi Kestus: </label>
    <input type="number" name="durationinput" id="durationinput" value="80">
    <br>
    <label for="genreinput">Filmi Žanr: </label>
    <input type="text" name="genreinput" id="genreinput" placeholder="žanr">
    <br>
    <label for="studioinput">Filmi tootja/stuudio: </label>
    <input type="text" name="studioinput" id="studioinput" placeholder="stuudio">
    <br>
    <label for="directorinput">Filmi Lavastaja: </label>
    <input type="text" name="directorinput" id="directorinput" placeholder="lavastaja">
    <br>
    <input type="submit" name="filmsubmit" value="Salvesta filmiinfo">
  </form>
  <p><?php echo $inputerror; ?></p>

</body>
</html>
