<?php
$username = "Anna-Stiina Laidna";
$fulltimenow = date("d.m.Y H:i:s");
$hournow = date("H");
$partofday = "lihtsalt aeg";

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
?>

<!DOCTYPE html>
<html lang="et">
<head>
  <meta charset="utf-8">
  <title>Veebileht</title>

</head>
<body>
  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse banner">
  <h1><?php echo $username; ?> programmeerib veebi</h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <p>Lehe avamise aeg: <?php echo $weekdayNamesET[$weekdaynow - 1] .", " .$fulltimenow .", semestri algusest on möödunud " .$fromsemesterstartdays ." päeva"; ?>. 
  <?php echo "Parajasti on " .$partofday ."."; ?></p>
</body>
</html>