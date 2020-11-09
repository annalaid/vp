<?php
require("session.php");
require("../../../config.php");
require("../../../config_photo.php");
require("classes/Photoupload_class.php");
require("fnc_photo.php");
require("fnc_common.php");

$notice = "";
$error = null;

if(isset($_POST["photosubmit"])){
	//var_dump($_POST);
	//var_dump($_FILES);
	//kas on üldse pilt
	if(isset($_FILES["photoinput"]["tmp_name"])){

	$check = getimagesize($_FILES["photoinput"]["tmp_name"]);
	//var_dump($check);
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
	} else {
		$error = "Valitud fail ei ole pilt!";
	}

	//pildi suurus
	if($_FILES["photoinput"]["size"] > $picsizelimit){
		$error .= " Fail ületab lubatud suuruse!";
	}

	//loon failinime
	$timestamp = microtime(1) * 10000;
	$filename = $filenameprefix .$timestamp ."." .$filetype;

	//kas on juba olemas
	if(file_exists($origphotodir .$filename)){
		$error .= " Selle nimega pildifail on juba olemas!";
	}

	if(empty($error)){
		//võtan klassi kasutusele
		$myphoto = new Photoupload($_FILES["photoinput"], $filetype);

		//muudame pildi suurust
		//$mynewimage = resizePhoto($mytempimage, $maxphotowidth, $maxphotoheight, true);
		$myphoto->resizePhoto($maxphotowidth, $maxphotoheight, true);
		//lisan vesimärgi
		$myphoto->addWatermark($watermarkimage);
		//salvestan vähendatud foto
		//$result = savePhotoFile($mynewimage, $filetype, $normalphotodir .$filename);
		$result = $myphoto->savePhotoFile($normalphotodir .$filename);
		if($result == 1){
			$notice .= "Vähendatud pildi salvestamine õnnestus!";
		} else {
			$error .= "Vähendatud pildi salvestamisel tekkis tõrge!";
		}
		//imagedestroy($mynewimage);
		//teeme pisipildi
		//$mynewimage = resizePhoto($mytempimage, $thumbsize, $thumbsize);
		$myphoto->resizePhoto($thumbsize, $thumbsize);
		//$result = savePhotoFile($mynewimage, $filetype, $thumbphotodir .$filename);
		$result = $myphoto->savePhotoFile($thumbphotodir .$filename);
		if($result == 1){
			$notice .= " Pisipildi salvestamine õnnestus!";
		} else {
			$error .= " Pisipildi salvestamisel tekkis tõrge!";
		}

		if(empty($error)){
			if(move_uploaded_file($_FILES["photoinput"]["tmp_name"], $origphotodir .$filename)){
				$notice .= " Originaalfaili üleslaadimine õnnestus!";
			} else {
				$error .= " Originaalfaili üleslaadimisel tekkis tõrge!";
			}
		}

		if(empty($error)){
			$privacy = intval($_POST["privinput"]);
			$alttext = test_input($_POST["altinput"]);
			$result = storePhotoData($filename, $alttext, $privacy);
			if($result == 1){
				$notice .= " Pildi info lisati andmebaasi!";
			} else {
				$error .= "Pildi info andmebaasi salvestamisel tekkis tõrge!";
			}
		} else {
			$error .= " Tekkinud vigade tõttu pildi andmeid ei salvestatud!";
		}
		//imagedestroy($mytempimage);
		unset($myphoto);
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
      <input id="altinput" name="altinput" type="text" placeholder="Pildi lühikirjeldus..." value="<?php echo $alttext; ?>">
      <br>
      <label>Määra privaatsus</label>
      <br>
      <input id="privinput1" name="privinput" type="radio" value="1" <?php if($privacy == 1){echo " checked";} ?>>
      <label for="privinput1">Privaatne(Näed ainult sina)</label>
      <br>
      <input id="privinput2" name="privinput" type="radio" value="2" <?php if($privacy == 2){echo " checked";} ?>>
      <label for="privinput2">Näevad sisseloginud kasutajad</label>
      <br>
      <input id="privinput3" name="privinput" type="radio" value="3" <?php if($privacy == 3){echo " checked";} ?>>
      <label for="privinput3">Avalik(Näevad kõik)</label>
      <br>
      <input type="submit" name="photosubmit" value="Lae foto üles"><span><?php echo $notice; ?></span>
    </form>


</body>
</html>
