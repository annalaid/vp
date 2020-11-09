<?php
session_start();
//$username = "Anna-Stiina Laidna";
require("header.php");

require("../../../config.php");
require("fnc_common.php");
require("fnc_user.php");

$monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];

$firstname = "";
$lastname = "";
$gender = "";
$email = "";
$birthdate = "";
$birthday = "";
$birthmonth = "";
$birthyear = "";

$firstnameerror = "";
$lastnameerror = "";
$gendererror = "";
$birthdayerror = "";
$birthdateerror = "";
$birthmontherror = "";
$birthyearerror = "";
$emailerror = "";
$passworderror = "";
$passwordsecondaryerror = "";

$notice = "";


if(isset($_POST["usersubmit"])){

  if(empty($_POST["firstnameinput"])){
    $firstnameerror .= "Eesnimi sisestamata!";
  } else {
	  $firstname = test_input($_POST["firstnameinput"]);
  }

  if(empty($_POST["lastnameinput"])){
    $lastnameerror .= "Perekonnanimi sisestamata!";
  } else {
    $lastname = test_input ($_POST["lastnameinput"]);
  }

  if(empty($_POST["genderinput"])){
    $gendererror .= "Sugu sisestamata!";
  } else {
    $gender = test_input ($_POST["genderinput"]);
  }

  if(!empty($_POST["birthdayinput"])){
    $birthday = intval($_POST["birthdayinput"]);
  } else {
    $birthdayerror = "Sünnikuupäev sisestamata!";
  }
  if(!empty($_POST["birthmonthinput"])){
    $birthmonth = intval($_POST["birthmonthinput"]);
  } else {
    $birthmontherror = "Sünnikuu sisestamata!";
  }
  if(!empty($_POST["birthyearinput"])){
    $birthyear = intval($_POST["birthyearinput"]);
  } else {
    $birthyearerror = "Sünniaasta sisestamata!";
  }
  //kontrollime kas sisestati reaalne kuupäev
  if(!empty($birthday) and !empty($birthmonth) and !empty($birthyear)){
    if(checkdate($birthmonth, $birthday, $birthyear)){
      $tempdate = new DateTime($birthyear ."-" .$birthmonth ."-" .$birthday);
      $birthdate = $tempdate->format("Y-m-d");
      //echo $birthdate;
    } else {
      $birthdateerror = "Kuupäev on vigane!";
    }
  }

  if(empty($_POST["emailinput"])){
    $emailerror .= "E-mail sisestamata!";
  } else {
    $email = test_input ($_POST["emailinput"]);
    }
  }
  if(empty($_POST["passwordinput"])){
    $passworderror .= "Parool sisestamata!";
  } else {
    if(strlen($_POST["passwordinput"]) < 8){
      $passworderror .= " Parool liiga lühike!";
    }
  }
  if(empty($_POST["passwordsecondaryinput"])){
    $passwordsecondaryerror .= "Teine parool sisestamata!";
  } else {
    if($_POST["passwordsecondaryinput"] != $_POST["passwordinput"]){
      $passwordsecondaryerror .= "Sisestatud salasõnad ei klapi!";
    }

	if(empty($firstnameerror) and empty($lastnameerror) and empty($gendererror) and empty($birthyearerror) and empty($birthdateerror) and empty($emailerror) and empty($passworderror) and empty($confirmpassworderror)){
    $result = signup($firstname, $lastname, $email, $gender, $birthdate, $_POST["passwordinput"]);
			//$notice = "Kõik korras!";
		if($result == "ok"){
		  $firstname= "";
		  $lastname = "";
			$gender = "";
			$email = "";
		  $birthdate = "";
		  $birthday = "";
		  $birthmonth = "";
		  $birthyear = "";
		  $notice = "Kasutaja loomine õnnestus!";
		} else {
		  $notice = "Kahjuks tekkis tehniline viga:" .$result;
		}
	}

}


?>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse banner">
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <ul>
    <li><a href="home.php">Tagasi pealehele!</a></li>
  </ul>
  <hr>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="firstnameinput">Eesnimi: </label>
    <br>
    <input type="text" name="firstnameinput" id="firstnameinput" value="<?php echo $firstname; ?>"><span><?php echo $firstnameerror; ?></span>
    <br>
    <label for="lastnameinput">Perekonnanimi:  </label>
    <br>
    <input type="text" name="lastnameinput" id="lastnameinput" value="<?php echo $lastname; ?>"><span><?php echo $lastnameerror; ?></span>
    <br>
    <label for="gendermale">Mees: </label>
    <input type="radio" name="genderinput" id="gendermale" value="1" <?php if($gender == "1"){echo "checked";} ?>><span><?php echo $gendererror; ?></span>
    <label for="genderfemale">Naine: </label>
    <input type="radio" name="genderinput" id="genderfemale" value="2" <?php if($gender == "2"){echo "checked";} ?>><span><?php echo $gendererror; ?></span>
    <br>
    <br>
    <label for="birthdayinput">Sünnipäev: </label>
   		  <?php
   			echo '<select name="birthdayinput" id="birthdayinput">' ."\n";
   			echo '<option value="" selected disabled>päev</option>' ."\n";
   			for ($i = 1; $i < 32; $i ++){
   				echo '<option value="' .$i .'"';
   				if ($i == $birthday){
   					echo " selected ";
   				}
   				echo ">" .$i ."</option> \n";
   			}
   			echo "</select> \n";
   		  ?>
   	  <label for="birthmonthinput">Sünnikuu: </label>
   	  <?php
   	    echo '<select name="birthmonthinput" id="birthmonthinput">' ."\n";
   		echo '<option value="" selected disabled>kuu</option>' ."\n";
   		for ($i = 1; $i < 13; $i ++){
   			echo '<option value="' .$i .'"';
   			if ($i == $birthmonth){
   				echo " selected ";
   			}
   			echo ">" .$monthNamesET[$i - 1] ."</option> \n";
   		}
   		echo "</select> \n";
   	  ?>
   	  <label for="birthyearinput">Sünniaasta: </label>
   	  <?php
   	    echo '<select name="birthyearinput" id="birthyearinput">' ."\n";
   		echo '<option value="" selected disabled>aasta</option>' ."\n";
   		for ($i = date("Y") - 15; $i >= date("Y") - 110; $i --){
   			echo '<option value="' .$i .'"';
   			if ($i == $birthyear){
   				echo " selected ";
   			}
   			echo ">" .$i ."</option> \n";
   		}
   		echo "</select> \n";
   	  ?>
   	  <br>
   	  <span><?php echo $birthdateerror ." " .$birthdayerror ." " .$birthmontherror ." " .$birthyearerror; ?></span>
    <br>
    <label for="emailinput">E-mail: </label>
    <br>
    <input type="e-mail" name="emailinput" id="emailinput" value="<?php echo $email; ?>"><span><?php echo $emailerror; ?></span>
    <br>
    <label for="passwordinput">Parool (Vähemalt 8 tähemärki!): </label>
    <br>
    <input type="password" name="passwordinput" id="passwordinput"><span><?php echo $passworderror; ?></span>
    <br>
    <label for="passwordsecondaryinput">Sisesta parool uuesti: </label>
    <br>
    <input type="password" name="passwordsecondaryinput" id="passwordsecondaryinput"><span><?php echo $passwordsecondaryerror; ?></span>
    <br>
    <input type="submit" name="usersubmit" value="Loo kasutajakonto"><span><?php echo $notice; ?></span>
  </form>

</body>
</html>
