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

	$myphoto = new Photoupload($_FILES["photoinput"], $filetype);

	$privacy = intval($_POST["privinput"]);
	$alttext = test_input($_POST["altinput"]);

	if(empty($myphoto->isPhotoFile($photoFileTypes))) {
		$error = "Valitud fail ei ole pilt!";
	}

	if(empty($inputerror) and !empty($myphoto->isAllowedFileSize($filesizelimit))) {
		$error = "Liiga suur fail!";
	}

	if(empty($error)) {
		$filename = $myphoto->createnewFileName($filenameprefix, $filenamesuffix);

		//teeme pildi väiksemaks
		$myphoto->resizePhoto($photomaxwidth, $photomaxheight, true);
		//lisame vesimärgi
		$myphoto->addWatermark($watermark);
		//salvestame vähendatud pildi
		$result = $myphoto->saveimage($photouploaddir_normal .$filename);
		if($result == 1){
			$notice .= "Vähendatud pildi salvestamine õnnestus!";
		} else {
			$error .= "Vähendatud pildi salvestamisel tekkis tõrge!";
		}
		//teeme pisipildi
		$myphoto->resizePhoto($thumbsize, $thumbsize);
		$result = $myphoto->saveimage($photouploaddir_thumb .$filename);
		if($result == 1){
			$notice .= " Pisipildi salvestamine õnnestus!";
		} else {
			$error .= " Pisipildi salvestamisel tekkis tõrge!";
		}

		if(empty($error)){
				$result = $myphoto->saveOriginalPhoto($origphotodir .$filename);
				if($result == 1){
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
