<?php
require("../../../config.php");
require("fnc/fnc_common.php");
require("fnc/fnc_user.php");

session_start();
//$username = "Anna-Stiina Laidna";
//$fulltimenow = date("d.m.Y H:i:s");
$timenow = date("H:i:s");
$daynow = date("d.");
$yearnow = date("Y");
$hournow = date("H");
$partofday = "lihtsalt aeg";

//vaatame, mida vormist saadetakse
//var_dump($_POST);

$weekdayNamesET = ["esmaspäev", "teisipäev", "kolmapäev", "neljapäev", "reede", "laupäev", "pühapäev"];
  $monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];

//küsime nädalapäeva
$weekdaynow = date("N");
//echo $weekdaynow
//küsime kuud
$monthnow = date("n");

if($hournow < 6){
$partofday = "uneaeg";
}
if($hournow >= 6 and $hournow < 8){
	$partofday = "hommikuste protseduuride aeg";
	}
if($hournow >= 8 and $hournow < 18){
	$partofday = "õppimise aeg";
	}
if($hournow >= 18 and $hournow < 22){
	$partofday = "õhtusöök ja teleka vaatamine";
}
if($hournow >= 22){
	$partofday = "päev on läbi, aeg magama minna!";
}

	//jälgime semestri kulgu
	$semesterstart = new DateTime("2020-8-31");
	$semesterend = new DateTime("2020-12-13");
	$semesterduration = $semesterstart->diff($semesterend);
	$semesterdurationdays = $semesterduration->format("%r%a");
	$today = new DateTime("now");
	$fromsemesterstart = $semesterstart->diff($today);
	//saime aja erinevuse objektina, seda niisama näidata ei saa
	$fromsemesterstartdays = $fromsemesterstart->format("%r%a");
	$semesterpercentage = 0;

	$semesterinfo = "Semester kulgeb vastavalt akadeemilisele kalendrile.";
	if($semesterstart > $today){
			$semesterinfo = "Semester pole veel peale hakanud!";
	}
	if($fromsemesterstartdays === 0){
			$semesterinfo = "Semester algab täna!";
	}
	if($fromsemesterstartdays > 0 and $fromsemesterstartdays < $semesterdurationdays){
			$semesterpercentage = ($fromsemesterstartdays / $semesterdurationdays) * 100;
			$semesterinfo = "Semester on täies hoos, kestab juba " .$fromsemesterstartdays ." päeva, läbitud on " .$semesterpercentage ."%.";
	}
	if($fromsemesterstartdays == $semesterdurationdays){
	  $semesterinfo = "Semester lõppeb täna!";
  }
  if($fromsemesterstartdays > $semesterdurationdays){
	  $semesterinfo = "Semester on läbi saanud!";
  }

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
	$picnum = mt_rand(0, ($piccount - 1));

	$imghtml = "";
	//for($i = 0; $i < $piccount; $i ++)
	//näitab algarvu, näitab piire, prindib maksimumi
		//<img src="../img/vp_banner.png" alt="alt_tekst">
		$imghtml .= '<img src="../vp_pics/' .$allpicfiles[$picnum] .'" ';
		$imghtml .= 'alt="Tallinna Ülikool">';

$email = "";
$password = "";

$emailerror = "";
$passworderror = "";
$notice = "";

if(isset($_POST["userdatasubmit"])){

  if(empty($_POST["emailinput"])){
    $emailerror .= "E-mail sisestamata!";
    } else {
      $email = test_input ($_POST["emailinput"]);
      }
  if(!empty($_POST['emailinput'])){
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE){
      echo("$email sobib!");
    } else {
      echo("$email ei ole sobiv meiliaadress!");
    }
  }

  if(empty($_POST["passwordinput"])){
    $passworderror .= "Parool sisestamata!";
  } else {
    if(strlen($_POST["passwordinput"]) < 8){
      $passworderror .= " Parool liiga lühike!";
    }
  }
  if (empty($emailerror) and empty($passworderror)){
    $result = signin($email, $_POST["passwordinput"]);
			//$notice = "Kõik korras!";
		if($result == "ok"){
			$email = "";
		  $notice = "Kasutaja loomine õnnestus!";
		} else {
		  $notice = "Kahjuks tekkis tehniline viga:" .$result;
		}
	}
}

require("header.php");



?>
  <img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse banner">
  <h1>Äge veebisüsteem</h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisada mingit tõsiseltvõetavat sisu!</p>
  <p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
  <p>Lehe avamise aeg: <?php echo $weekdayNamesET[$weekdaynow - 1] . " ". $daynow . " " .$monthNamesET[$monthnow - 1] . " " . $yearnow. ", kell on " .$timenow .", semestri algusest on möödunud " .$fromsemesterstartdays ." päeva"; ?>.
  <br>
  <?php echo "Parajasti on " .$partofday ."."; ?></p>
	<p><?php echo $semesterinfo; ?></p>
  <hr>
  <li><a href="users.php">Kasutaja saad luua siin!</a></li>
  <hr>
  <p>Sisselogimine:</p>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="emailinput">E-mail: </label>
    <br>
    <input type="e-mail" name="emailinput" id="emailinput" value="<?php echo $email; ?>"><span><?php echo $emailerror; ?></span>
    <br>
    <label for="passwordinput">Salasõna: </label>
    <br>
    <input type="password" name="passwordinput" id="passwordinput"><span><?php echo $passworderror; ?></span>
    <br>
    <input type="submit" name="userdatasubmit" value="Logi sisse!"><span><?php echo $notice; ?></span>
  </form>
	<hr>
  <?php echo $imghtml; ?>

</body>
</html>
