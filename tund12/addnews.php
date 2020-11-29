<?php
  require("session.php");
  require("../../../config.php");
  //require("fnc_photo.php");
  require("fnc_common.php");
  require("fnc_news.php");

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
  $dateerror = null;
  $dayerror = null;
  $montherror = null;
  $yearerror = null;

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
    if(strlen($_POST["dateinput"]) == 0){

    }
    if(empty($inputerror)){

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
	<label for="newsinput">Kirjuta uudis</label>
	<textarea id="newsinput" name="newsinput"><?php echo $news; ?></textarea>
  <br>
  <label for="dateinput">Uudise aegumise kuupäev: </label>
      <?php
      echo '<select name="dateinput" id="dateinput">' ."\n";
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
    for ($i = date("Y") - 15; $i >= date("Y") - 110; $i --){
      echo '<option value="' .$i .'"';
      if ($i == $year){
        echo " selected ";
      }
      echo ">" .$i ."</option> \n";
    }
    echo "</select> \n";
    ?>
    <br>
    <span><?php echo $dateerror ." " .$dayerror ." " .$montherror ." " .$yearerror; ?></span>
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
