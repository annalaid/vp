<?php
  require("session.php");
  require("../../../config.php");
  require("../../../config_photo.php");
  require("fnc_photo.php");
  require("fnc_common.php");
  require("fnc_news.php");
  require("classes/Photoupload_class.php");

  $tolink = "\t" .'<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>' ."\n";
  $tolink .= "\t" .'<script>tinymce.init({selector:"textarea#newsinput", plugins: "link", menubar: "edit",});</script>' ."\n";

  $monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni", "juuli", "august", "september", "oktoober", "november", "detsember"];

  $inputerror = "";
  $notice = null;
  $news = null;
  $newstitle = null;
  $year = null;
  $month = null;
  $day = null;

  //kui klikiti submit, siis ...
  if(isset($_POST["newssubmit"])){
    if(strlen($_POST["newstitleinput"]) == 0){
      $inputerror = "Uudise pealkiri puudub!";
    } else {
      $newstitle = test_input($_POST["newstitleinput"]);
    }
    if(strlen($_POST["newsinput"]) == 0){
      $inputerror .= "Uudise sisu puudub!";
    } else {
      $news = test_input($_POST["newsinput"]);
      //htmlspecialchars teisendab html nooluslud
      //tagasisaamiseks htmlchars_decode(uudis)
    }
    if(!empty($_POST["dayinput"])){
      $date = intval($_POST["dayinput"]);
    }

    if(!empty($_POST["monthinput"])) {
      $month = intval($_POST["monthinput"]);
    }
    if(!empty($_POST["yearinput"])) {
      $year = intval($_POST["yearinput"]);
    }
    if(!empty($day) and !empty($month) and !empty($year)){
      if(checkdate($day, $month, $year)) {
        $tempdate = new DateTime($year ."-" .$month ."-" .$day);
        $expire = $tempdate->format("Y-m-d");
      } else {
        $expire = null;
        $inputerror .= " Kuupäev ei ole reaalne!";
      }
    }

    if(!empty($_FILES["photoinput"]["name"])){
      $alttext = test_input($_POST["altinput"]);
      $myphoto = new Photoupload($_FILES["photoinput"]);

      if($myphoto->imageType($photoFileTypes) == 0){
        $inputerror = "Valitud fail ei ole pilt! ";
      }

      if(empty($inputerror) and $myphoto->getSize($picsizelimit) == 0){
        $inputerror = "Liiga suur fail!";
      }
      $filename = $myphoto->setFilename();

      //ega fail äkki olemas pole
      if($myphoto->file_exists($newsphotodir, $filename)){
        $inputerror = "Sellise nimega fail on juba olemas!";
      }
    }
  }
    if(empty($inputerror)){
      if(!empty($_FILES["photoinput"]["name"])){
        // teeme pildi väiksemaks
        $myphoto->resizePhoto($maxphotowidth, $maxphotoheight, true);
        // salvestame vähendatud pildi
        $result = $myphoto->savePhotoFile($newsphotodir .$filename);
        if($result == 1){
          $notice .= " Pildi salvestamine õnnestus! ";
        } else {
          $inputerror .= " Pildi salvestamisel tekkis tõrge! ";
        }
        unset($myphoto);
      }
      if(empty($inputerror) and !empty($_FILES["photoinput"]["name"])){
        $result = storeNewsPhoto($filename, $alttext);
        if($result == 1){
          $notice .= " Pildi info lisati andmebaasi!";
          $alttext = null;
        } else {
          $inputerror .= " Pildi info andmebaasi salvestamisel tekkis tõrge!";
          $filename = null;
        }
        if(empty($inputerror)){
          $result = storeNewsData($filename, $newstitle, $news, $expire);
          if($result == 1){
            $notice .= " Uudis salvestatud!";
            $news = null;
            $newstitle = null;
          } else {
            $inputerror .= " Uudise salvestamisel tekkis tõrge!";
          }
        } else {
          $inputerror .= " Tekkinud vigade tõttu uudist ei salvestatud!";
        }
    }

  }

  require("header.php");
?>
  <h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?></h1>
  <p>See veebileht on loodud õppetöö käigus ning ei sisalda mingit tõsiseltvõetavat sisu!</p>
  <p>See konkreetne leht on loodud veebiprogrammeerimise kursusel aasta 2020 sügissemestril <a href="https://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>

  <ul>
    <li><a href="?logout=1">Logi välja</a>!</li>
    <li><a href="home.php">Avaleht</a></li>
  </ul>

  <hr>

  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
    <label for="newstitleinput">Sisesta uudise pealkiri</label>
	<input id="newstitleinput" name="newstitleinput" type="text" value="<?php echo $newstitle; ?>" required>
	<br>
  <label for="photoinput">Vali pildifail!</label>
  <input id="photoinput" name="photoinput" type="file" required>
  <br>
  <label for="altinput">Lisa pildile lühikirjeldus</label>
  <input id="altinput" name="altinput" type="text" value="<?php echo $alttext; ?>">
  <br>
	<label for="newsinput">Kirjuta uudis</label>
	<textarea id="newsinput" name="newsinput"><?php echo $news; ?></textarea>
  <br>
  <label for="dayinput">Uudise aegumise kuupäev (soovitatavalt 30 päeva): </label>
  <br>
      <label for="dayinput">Päev: </label>
      <?php
      echo '<select name="dayinput" id="dayinput">' ."\n";
      echo '<option value="" selected disabled>päev</option>' ."\n";
      for ($i = 1; $i < 32; $i ++){
        echo '<option value="' .$i .'"';
        if ($i == $day){
          echo " selected ";
        }
        echo ">" .$i ."</option> \n";
      }
      echo "</select> \n";
      ?>
    <label for="monthinput">Kuu: </label>
    <?php
      echo '<select name="monthinput" id="monthinput">' ."\n";
    echo '<option value="" selected disabled>kuu</option>' ."\n";
    for ($i = 1; $i < 13; $i ++){
      echo '<option value="' .$i .'"';
      if ($i == $month){
        echo " selected ";
      }
      echo ">" .$monthNamesET[$i - 1] ."</option> \n";
    }
    echo "</select> \n";
    ?>
    <label for="yearinput">Aasta: </label>
    <?php
      echo '<select name="yearinput" id="yearinput">' ."\n";
    echo '<option value="" selected disabled>aasta</option>' ."\n";
    for ($i = date("Y"); $i <= date("Y") + 20; $i ++){
      echo '<option value="' .$i .'"';
      if ($i == $year){
        echo " selected ";
      }
      echo ">" .$i ."</option> \n";
    }
    echo "</select> \n";
    ?>
  <br>
	<input type="submit" id="newssubmit" name="newssubmit" value="Salvesta uudis">
  </form>
  <p id="notice">
  <?php
	echo $inputerror;
	echo $notice;
  ?>
  </p>

</body>
</html>
