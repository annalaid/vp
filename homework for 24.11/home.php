<?php
require("session.php");
//sessioon
//sessioon mis katkeb kui browser suletakse, kättesaadav ainult meie domeenis ja ainult meie lehel
//tegeleme küpsistega - cookies
//setcookie  see peab olema  enne <html> elemendi algust
//(küpsise nimi, väärtus, aegumine, path - kataloog, domeen, https, http-only)
$lastvisitor = null;
  //tegeleme küpsistega - cookies
  //setcookie   see peab olema enne <html> elemendi algust
  //(küpsise nimi, väärtus, aegumine, path (kataloog), domeen, https, http-only)
  setcookie("vpvisitorname", $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"], time() + (86400 * 8), "/~anna/", "greeny.cs.tlu.ee", isset($_SERVER["HTTPS"]), true);
  //vaatame, kas on olemas
  if(isset($_COOKIE["vpvisitorname"])){
	  $lastvisitor = "<p>Viimati külastas lehte: " .$_COOKIE["vpvisitorname"] ."</p>";
  } else {
	  $lastvisitor = "<p>Küpsiseid ei leitud, viimane külastaja pole teada.</p>";
  }

//testin klassi
//require("classes/Generic_class.php");
//loome uue instantsi
//$myfirstinstance = new Generic();
//echo "Salajane number on: " .$myfirstinstance->secretnumber;
//echo " Avalik number on: " .$myfirstinstance->availablenumber;

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
     <hr>
     <li><a href="addfilms.php">Filmiinfo lisamine</a></li>
		 <li><a href="listfilms.php">Filmiinfo näitamine</a></li>
     <hr>
     <li><a href="addquotes.php">Tsitaatide lisamine</a></li>
		 <li><a href="addfilmrelations.php">Filmide seoste loomine</a></li>
		 <li><a href="listfilmrelations.php">Filmide nimekiri</a></li>
     <hr>
		 <li><a href="userprofile.php">Kasutaja profiili haldamine</a></li>
     <li><a href="photoupload.php">Piltide üleslaadimine</a></li>
     <li><a href="photogallery_public.php">Pildid (avalikud ja sisseloginud kasutajatele)</a></li>
    </ul>
	<hr>
  <h3>
    <?php
    echo $lastvisitor
    ?>

</body>
</html>
