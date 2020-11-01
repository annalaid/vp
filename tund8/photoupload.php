<?php
require("session.php");
require("../../../config.php");

$notice = "";
$filetype = "";
$error = "";
$filenameprefix = "vp_";
$filename = "";
$origphotodir = "../photoupload_orig/";
$normalphotodir = "../photoupload_normal/";
$maxphotowidth = 600;
$maxphotoheight = 400;



	if(isset($_POST["photosubmit"])){
    //var_dump($_POST);
    //var_dump($_FILES);
		//kas on üldse pilt?
		$check = getimagesize($_FILES["photoinput"]["tmp_name"]);
		if($check !== false){
			if($check["mime"] == "image/jpeg"){
				$filetype = "jpg";
			}
			if($check["mime"] == "image/png"){
				$filetype = "png";
			}
			if($check["mime"] == "image/gif"){
				$filetype = "gif";
			}
		}else {
			$error = "Valitud fail ei ole pilt!";
		}

		 //pildi suurus
		 if($_FILES["photoinput"]["size"] > 1048576){
			 $error .= "Fail ületab lubatud suuruse!";
		 }

		 //loon failinime
		 $timestamp = microtime(1) * 10000;
		 $filename = $filenameprefix .$timestamp ."." .$filetype;
		 //kas on juba olemas
		 if(file_exists($origphotodir .$filename)){
			 $error .= "Selline pildifail on juba olemas!";
		 }
		 if(empty($error)){
			 //teeme pildi väiksemaks
			 //teeme pildiobjekti - pikslikogumi
			 if($filetype == "jpg"){
				 $mytempimage = imagecreatefromjpeg($_FILES["photoinput"]["tmp_name"]);
			 }
			 if($filetype == "png"){
				 $mytempimage = imagecreatefrompng($_FILES["photoinput"]["tmp_name"]);
			 }
			 if($filetype == "gif"){
				 $mytempimage = imagecreatefromgif($_FILES["photoinput"]["tmp_name"]);
			 }

			 //uurime pildi originaalsuurust
			 $imagew = imagesx($mytempimage);
			 $imageh = imagesy($mytempimage);
			 //arvutame kas suuruse muutmisel lähtuda laiusest või kõrgusest
			 if($imagew / $maxphotowidth > $imageh / $maxphotoheight){
				 $imagesizeratio = $imagew / $maxphotowidth;
			 } else {
				 $imagesizeratio = $imageh / $maxphotoheight;
			 }
			 //arvutan uued mõõdud
			 $newphotow = round($imagew / $imagesizeratio);
			 $newphotoh = round($imageh / $imagesizeratio);
			 //loome uue tühja pildiobjekti kuhu pikslid ümber tõsta
			 $mynewimage = imagecreatetruecolor($newphotow, $newphotoh);
			 imagesavealpha($mynewimage, true);
			 //loome läbipaistva värvi
			 $transparentcolor = imagecolorallocatealpha($mynewimage, 0,0,0,127);
			 imagefill($mynewimage, 0, 0, $transparentcolor);
			 imagecopyresampled($mynewimage, $mytempimage, 0, 0, 0, 0, $newphotow, $newphotoh, $imagew, $imageh);
			 //salvestame pildifaili
			 if($filetype == "jpg"){
				 if(imagejpeg($mynewimage, $normalphotodir .$filename, 90)){
					 $notice = "Vähendatud pildi salvestamine õnnestus!";
				 } else {
				 	$notice = "Vähendatud pildi salvestamisel tekkis tõrge!";
				 }
			 }
			 if($filetype == "png"){
				 if(imagepng($mynewimage, $normalphotodir .$filename, 6)){
					 $notice = "Vähendatud pildi salvestamine õnnestus!";
				 } else {
				 	$notice = "Vähendatud pildi salvestamisel tekkis tõrge!";
				 }
			 }
			 if($filetype == "gif"){
				 if(imagegif($mynewimage, $normalphotodir .$filename)){
					 $notice = "Vähendatud pildi salvestamine õnnestus!";
				 } else {
				 	$notice = "Vähendatud pildi salvestamisel tekkis tõrge!";
				 }
			 }

			 //tühistan pildipbjectid
			 imagedestroy($mytempimage);
			 imagedestroy($mynewimage);

			 if(move_uploaded_file($_FILES["photoinput"]["tmp_name"], $origphotodir .$filename)){
				 $notice .= " Originaalfaili üleslaadimine õnnestus!";
			 } else {
			 	$notice .= " Originaalfaili üleslaadimisel tekkis tõrge!";
			 }
	}
}

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

    <h2>Foto üleslaadimine:</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
      <label for="photoinput">Vali pildifail!</label>
      <input id="photoinput" name="photoinput" type="file">
      <br>
      <label for="altinput">Sisesta alternatiivtekst!</label>
      <input id="altinput" name="altinput" type="text" placeholder="Pildi lühikirjeldus...">
      <br>
      <label>Määra privaatsus</label>
      <br>
      <input id="privinput1" name="privinput" type="radio" value="1">
      <label for="privinput1">Privaatne(Näed ainult sina)</label>
      <br>
      <input id="privinput2" name="privinput" type="radio" value="2">
      <label for="privinput2">Näevad sisseloginud kasutajad</label>
      <br>
      <input id="privinput3" name="privinput" type="radio" value="3">
      <label for="privinput3">Avalik(Näevad kõik)</label>
      <br>
      <input type="submit" name="photosubmit" value="Lae foto üles"><span><?php echo $notice; ?></span>
    </form>

</body>
</html>
