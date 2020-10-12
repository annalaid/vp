<?php
	require("../../../config.php");

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
$database = "if20_anna_laid_3";

$notice = "";
$filmtitlelist = "";
$genrelist = "";

//filmi pealkirjade listi tegemine
$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
$stmt = $conn->prepare("SELECT movie_id, title FROM movie");
echo $conn->error;
$stmt->bind_result($movieidfromdb, $movietitlefromdb);
if($stmt->execute()) {
	while($stmt->fetch()) {
	$filmtitlelist .= "\n \t \t" .'<option value="' .$movieidfromdb .'">' .$movietitlefromdb .'</option>';
	}
} else {
	$notice = $stmt->error();
}
$stmt->close();

//zanrite listi tegemine
$stmt = $conn->prepare("SELECT genre_id, genre_name FROM genre");
echo $conn->error;
$stmt->bind_result($genreidfromdb, $genrefromdb);
if($stmt->execute()) {
	while($stmt->fetch()) {
	$genrelist .= "\n \t \t" .'<option value="' .$genreidfromdb .'">' .$genrefromdb .'</option>';
	}
} else {
	$notice = $stmt->error();
}
$stmt->close();

//andmete saatmine db-sse
if(isset($_POST["filmconnectionssubmit"])) {
	if(isset($_POST["filminput"]) and isset($_POST["genreinput"])) {
		$stmt = $conn->prepare("INSERT INTO movie_genre (movie_id, genre_id) VALUES (?, ?)");
		echo $conn->error;
		$stmt->bind_param("ii", $_POST["filminput"], $_POST["genreinput"]);
		if($stmt->execute()) {
			$notice = "Seos salvestatud!";
		} else {
			$notice = $stmt->error();
		}
		$stmt->close();
	} else {
		$notice = "Üks valikutest on tegemata!";
	}
}
$conn->close();

?>


  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse banner">
	<h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisada mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
	<li><a href="home.php">Tagasi pealehele!</a></li>
	<li><a href="?logout=1">Logi välja!</a></li>
	<hr>
	<p>Loo seoseid filmide ja žanrite vahel: </p>

	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="filminput">Film: </label>
	<select name="filminput" id="filminput">
		<option value="" selected disabled>Vali film</option>
		<?php echo $filmtitlelist; ?>
	</select>
	<br>
	<label for="genreinput">Žanr: </label>
	<select name="genreinput" id="genreinput">
		<option value="" selected disabled>Vali žanr</option>
		<?php echo $genrelist; ?>
	</select>
	<br>
	<input type="submit" name="filmconnectionssubmit" value="Kinnita seos">
	<?php echo $notice; ?>
  </form>


</body>
</html>
