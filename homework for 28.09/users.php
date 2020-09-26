<?php
$username = "Anna-Stiina Laidna";
require("header.php");

$firstnameinput = "";
$lastnameinput = "";
$genderinput = "";
$emailinput = "";
$passwordinput = "";
$passwordsecondaryinput = "";

$firstname = "";
$lastname = "";
$gender = "";
$email = "";

$firstnameerror = "";
if(isset($_POST["usersubmit"])){
  if(empty($_POST["firstnameinput"])){
    $firstnameerror .= "Eesnimi sisestamata!";
      if(empty($_POST["firstnameinput"]));{
        $lastname = $_POST["lastnameinput"];
        $gender = $_POST["genderinput"];
        $email = $_POST["emailinput"];
      }
  }
}
$lastnameerror = "";
if(isset($_POST["usersubmit"])){
  if(empty($_POST["lastnameinput"])){
    $lastnameerror .= "Perekonnanimi sisestamata!";
      if(empty($_POST["lastnameinput"]));{
        $firstname = $_POST["firstnameinput"];
        $gender = $_POST["genderinput"];
        $email = $_POST["emailinput"];
      }
  }
}
$gendererror = "";
if(isset($_POST["usersubmit"])){
  if(empty($_POST["genderinput"])){
    $gendererror .= "Sugu sisestamata!";
      if(empty($_POST["genderinput"])){
        $firstname = $_POST["firstnameinput"];
        $email = $_POST["emailinput"];
        $lastname = $_POST["lastnameinput"];
      }
  }
}
$emailerror = "";
if(isset($_POST["usersubmit"])){
  if(empty($_POST["emailinput"])){
    $emailerror .= "E-mail sisestamata!";
      if(empty($_POST["emailinput"]));{
        $firstname = $_POST["firstnameinput"];
        $lastname = $_POST["lastnameinput"];
        $gender = $_POST["genderinput"];
      }
  }
}
$passworderror = "";
if(isset($_POST["usersubmit"])){
  if(empty($_POST["passwordinput"])){
    $passworderror .= "Parool sisestamata!";
    if(strlen($_POST["passwordinput"]) < 8);
      $passworderror .= " Parool liiga lühike!";
  }
}
$passwordsecondaryerror = "";
if(isset($_POST["usersubmit"])){
  if(empty($_POST["passwordsecondaryinput"])){
    $passwordsecondaryerror .= "Teine parool sisestamata!";
  }
}


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
  <label for="firstnameinput">Eesnimi: </label>
  <input type="text" name="firstnameinput" id="firstnameinput" value="<?php echo $firstname; ?>"><span><?php echo $firstnameerror; ?></span>
  <br>
  <label for="lastnameinput">Perekonnanimi:  </label>
  <input type="text" name="lastnameinput" id="lastnameinput" value="<?php echo $lastname; ?>"><span><?php echo $lastnameerror; ?></span>
  <br>
  <label for="gendermale">Mees: </label>
  <input type="radio" name="genderinput" id="gendermale" value="1" <?php if($gender == "1"){echo "checked";} ?>><span><?php echo $gendererror; ?></span>
  <label for="genderfemale">Naine: </label>
  <input type="radio" name="genderinput" id="genderfemale" value="2" <?php if($gender == "2"){echo "checked";} ?>><span><?php echo $gendererror; ?></span>
  <br>
  <label for="emailinput">E-mail: </label>
  <input type="e-mail" name="emailinput" id="emailinput" value="<?php echo $email; ?>"><span><?php echo $emailerror; ?></span>
  <br>
  <label for="passwordinput">Parool (Vähemalt 8 tähemärki!): </label>
  <input type="password" name="passwordinput" id="passwordinput"><span><?php echo $passworderror; ?></span>
  <br>
  <label for="passwordsecondaryinput">Sisesta parool uuesti: </label>
  <input type="password" name="passwordsecondaryinput" id="passwordsecondaryinput"><span><?php echo $passwordsecondaryerror; ?></span>
  <br>
  <input type="submit" name="usersubmit" value="Salvesta kasutajakonto">
</form>

</body>
</html>
