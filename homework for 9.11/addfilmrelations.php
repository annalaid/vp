<?php
require("session.php");
require("../../../config.php");
require("fnc_filmrelations.php");


  $genrenotice = "";
	$studionotice ="";
  $selectedfilm = "";
  $selectedgenre = "";
	$selectedstudio = "";
  $personinmovienotice = "";
  $quotenotice = "";

  $selectedperson = "";
  $selectedfilm = "";
  $selectedposition = "";
  $selectedstudio = "";
  $selectedgenre = "";
  $selectedquote = "";

	if(isset($_POST["filmstudiosubmit"])){
		if(!empty($_POST["filminput"])){
			$selectedfilm = intval($_POST["filminput"]);
		} else {
			$studionotice = " Vali film!";
		}
		if(!empty($_POST["filmstudioinput"])){
			$selectedstudio = intval($_POST["filmstudioinput"]);
		} else {
			$studionotice .= " Vali stuudio!";
		}
		if(!empty($selectedfilm) and !empty($selectedstudio)){
			$studionotice = storenewstudiorelation($selectedfilm, $selectedstudio);
		}
	}

  if(isset($_POST["filmgenresubmit"])){
	//$selectedfilm = $_POST["filminput"];
	if(!empty($_POST["filminput"])){
		$selectedfilm = intval($_POST["filminput"]);
	} else {
		$genrenotice = " Vali film!";
	}
	if(!empty($_POST["filmgenreinput"])){
		$selectedgenre = intval($_POST["filmgenreinput"]);
	} else {
		$genrenotice .= " Vali žanr!";
	}
	if(!empty($selectedfilm) and !empty($selectedgenre)){
		$genrenotice = storenewgenrerelation($selectedfilm, $selectedgenre);
	 }
  }

  if(isset($_POST["personinmoviesubmit"])){
		if(!empty($_POST["filminput"])){
			$selectedfilm = intval($_POST["filminput"]);
		} else {
			$personinmovienotice = " Vali film!";
		}
		if(!empty($_POST["personinmovieinput"])){
			$selectedpersoninmovie = intval($_POST["personinmovieinput"]);
		} else {
			$personinmovienotice .= " Vali isik!";
		}
    if(!empty($_POST["positioninmovie"])){
			$selectedpositioninmovie = intval($_POST["positioninmovie"]);
		} else {
			$personinmovienotice .= " Vali positsioon filmis!";
		}
		if(!empty($selectedfilm) and !empty($selectedpersoninmovie) and !empty($selectedpositioninmovie)){
			$personinmovienotice = storenewpersoninmovierelation($selectedfilm, $selectedpersoninmovie, $selectedpositioninmovie);
		}
	}

  if(isset($_POST["quotesubmit"])){
    if(!empty($_POST["personinmovieinput"])){
			$selectedpersoninmovie = intval($_POST["personinmovieinput"]);
		} else {
			$quotenotice .= " Vali isik!";
		}
		if(!empty($_POST["filminput"])){
			$selectedfilm = intval($_POST["filminput"]);
		} else {
			$quotenotice = " Vali film!";
		}
    if(!empty($_POST["quoteinmovie"])){
			$selectedquote = intval($_POST["quoteinmovie"]);
		} else {
			$quotenotice .= " Vali tsitaat!";
		}
		if(!empty($selectedpersoninmovie) and !empty($selectedfilm) and !empty($selectedquote)){
			$quotenotice = storenewquoterelation($selectedpersoninmovie, $selectedfilm, $selectedquote);
		}
	}


  $filmselecthtml = readmovietoselect($selectedfilm);
  $filmgenreselecthtml = readgenretoselect($selectedgenre);
  $filmstudioselecthtml = readstudiotoselect($selectedstudio);
  $personinmovieselecthtml = readpersontoselect($selectedperson);
  $filmquoteselecthtml = readquotetoselect($selectedquote);
  $positioninmovieselecthtml = readpositiontoselect($selectedposition);


  require("header.php");
?>

  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse bänner">
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>

  <ul>
    <li><a href="home.php">Avalehele</a></li>
	<li><a href="?logout=1">Logi välja</a>!</li>


  </ul>
  <h2>Määrame isiku seose filmiga</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <?php
    echo $filmselecthtml;
    echo $personinmovieselecthtml;
    echo $positioninmovieselecthtml;
	?>
    <input type="submit" name="personinmoviesubmit" value="Salvesta isiku seos filmiga"><span><?php echo $personinmovienotice; ?></span>
  </form>
  <hr>
    <h2>Lisame isiku öeldud tsitaadi</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
      <?php
      echo $personinmovieselecthtml;
      echo $filmselecthtml;
      echo $filmquoteselecthtml;
    ?>

      <input type="submit" name="quotesubmit" value="Salvesta tsitaat"><span><?php echo $quotenotice; ?></span>
    </form>
<hr>
	<h2>Määrame filmile stuudio</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <?php
	  echo $filmselecthtml;
	  echo $filmstudioselecthtml;
	?>
    <input type="submit" name="filmstudiosubmit" value="Salvesta seos stuudioga"><span><?php echo $studionotice; ?></span>
  </form>
<hr>
  <h2>Määrame filmile žanri</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <?php
		echo $filmselecthtml;
		echo $filmgenreselecthtml;
	?>

		<input type="submit" name="filmgenresubmit" value="Salvesta seos žanriga"><span><?php echo $genrenotice; ?></span>
  </form>


</body>
</html>
