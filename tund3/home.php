<?php
//loeme andmebaasi login info muutujad
require("../../../config.php");
//kui kasutaja on vormis andmeid saatnud, siis salvestame andmebaasi
$database = "if20_anna_laid_3";
if(isset($_POST["submitnonsens"])) {
	if(!empty($_POST["nonsens"])){
		//andmebaasi lisamine
		//loome andmebaasi ühenduse
		$conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
		//valmistame ette SQL käsu
		$stmt = $conn->prepare("INSERT INTO nonsens (nonsensidea) VALUES(?)");
		echo $conn->error;
		//s - string, i - integer, d - decimal
		$stmt->bind_param("s", $_POST["nonsens"]);
		$stmt->execute();
		//käsk ja ühendus sulgeda
		$stmt->close();
		$conn->close();
	}
}

//loeme andmebaasis
$nonsenshtml = "";
$conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
//valmistame ette SQL käsu
$stmt = $conn->prepare("SELECT nonsensidea FROM nonsens");
echo $conn->error;
//seome tulemuse mingi muutujaga
$stmt->bind_result($nonsensfromdb);
$stmt->execute();
//võtan, kuni on
while($stmt->fetch()) {
	//<p>suvaline mõte </p>
	$nonsenshtml .= "<p>" .$nonsensfromdb ."</p>";
	
}
$stmt->close();
$conn->close();
//ongi andmebaasist loetud

$username = "Anna-Stiina Laidna";
$fulltimenow = date("d.m.Y H:i:s");
$hournow = date("H");
$partofday = "lihtsalt aeg";

//vaatame, mida vormist saadetakse
var_dump($_POST);

$weekdayNamesET = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
  $monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];

//küsime nädalapäeva
$weekdaynow = date("N");
//echo $weekdaynow


if($hournow < 6){
$partofday = "uneaeg";
}
if($hournow >= 6 and $hournow < 8){
	$partofday = "hommikuste protseduuride aeg";
	}
if($hournow >= 8 and $hournow < 18){
	$partofday = "õppimise aeg";
	}
	//jälgime semestri kulgu
	$semesterstart = new DateTime("2020-8-31");
	$semesterend = new DateTime("2020-12-13");
	$semesterduration = $semesterstart->diff($semesterend);
	$today = new DateTime("now");
	$fromsemesterstart = $semesterstart->diff($today);
	//saime aja erinevuse objektina, seda niisama näidata ei saa
	$fromsemesterstartdays = $fromsemesterstart->format("%r%a");
	
	//loenkataloogist piltide nimekirja
	//$allfiles = scandir("../vp_pics/");
	$allfiles = array_slice(scandir("../vp_pics/"), 2);
	//echo $allfiles; //masiivi nii näidata ei saa!!
	//var_dump($allfiles);
	//$allpicfiles = array_slice($allfiles, 2);
	//var_dump($allpicfiles);
	$allpicfiles = [];
	$picfiletypes = ["image/jpeg", "image/png"];
	//käin kogu massiivi läbi ja kontrollin iga üksikut elementi, kas on sobiv fail ehk pilti
	foreach ($allfiles as $file) {
		$fileinfo = getImagesize("../vp_pics/" .$file);
		if(in_array($fileinfo["mime"], $picfiletypes) == true) {
			array_push($allpicfiles, $file);
		}
	}
	
	//paneme kõik pildid järjest ekraanile
	//uurime, mitu pilti on ehk mitu faili on nimekirjas - massiivis
	$piccount = count($allpicfiles);
	//echo $piccount;
	//$i = $i + 1;
	//$i += 1;
	//$i ++;
	$imghtml = "";
	for($i = 0; $i < $piccount; $i ++) {
		//<img src="../img/vp_banner.png" alt="alt_tekst">
		$imghtml .= '<img src="../vp_pics/' .$allpicfiles[$i] .'" ';
		$imghtml .= 'alt="Tallinna Ülikool">';
	}
	
	require("header.php");
?>


  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse banner">
  <h1><?php echo $username; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <p>Lehe avamise aeg: <?php echo $weekdayNamesET[$weekdaynow - 1] .", " .$fulltimenow .", semestri algusest on möödunud " .$fromsemesterstartdays ." päeva"; ?>. 
  <?php echo "Parajasti on " .$partofday ."."; ?></p>
  <hr>
  <?php echo $imghtml; ?>
  <hr>
  <form method="POST">
	<label>Sisesta oma tänane mõtetu mõte!</label>
	<input type="text" name="nonsens" placeholder="mõttekoht">
	<input type="submit" value="Saada ära!" name="submitnonsens">
  </form>
  <hr>
  <?php echo $nonsenshtml; ?>
</body>
</html>