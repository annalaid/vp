<?php
require("session.php");
require("../../../config.php");
require("../../../config_photo.php");
require("fnc_photo.php");

$tolink = '<link rel="stylesheet" type="text/css" href="style/gallery.css">' ."\n";
$tolink .= '<link rel="stylesheet" type="text/css" href="style/modal.css">' ."\n";
$tolink .= '<script src="javascript/modal.js" defer></script>' ."\n";

$notice = "";
$error = null;
$photocount = countPublicPhotos(2);

$gallerylimit = 6;
$page = 1;

if(!isset($_GET["page"]) or $_GET["page"] < 1){
  $page = 1;
} else if(round($_GET["page"] - 1) * $gallerylimit >= $photocount){
  $page = floor($photocount / $gallerylimit);
} else {
  $page = $_GET["page"];
}


//loen sisse pildid mille privaatsus on 2 või 3
$publicphotothumbsHTML = readPublicPhotosThumbsPage(2, $gallerylimit, $page);



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

  <!--Modaalaken fotogalerii jaoks-->
  <div id="modalarea" class="modalarea">
	<!--sulgemisnupp-->
	<span id="modalclose" class="modalclose">&times;</span>
	<!--pildikoht-->
	<div class="modalhorizontal">
		<div class="modalvertical">
			<p id="modalcaption"></p>
			<img id="modalimg" src="../img/empty.png" alt="galeriipilt">

			<br>
			<div id="rating" class="modalRating">
				<label><input id="rate1" name="rating" type="radio" value="1">1</label>
				<label><input id="rate2" name="rating" type="radio" value="2">2</label>
				<label><input id="rate3" name="rating" type="radio" value="3">3</label>
				<label><input id="rate4" name="rating" type="radio" value="4">4</label>
				<label><input id="rate5" name="rating" type="radio" value="5">5</label>
				<button id="storeRating">Salvesta hinnang!</button>
				<br>
				<p id="avgRating"></p>
			</div>

		</div>
	</div>
  </div>

  <hr>
  <h2>Fotogalerii</h2>
  <p>
	<?php
		if($page > 1){
			echo '<span><a href="?page=' .($page - 1) .'">Eelmine leht</a></span> |' ."\n";
		} else {
			echo '<span>Eelmine leht</span> |' ."\n";
		}
		if($page * $gallerylimit < $photocount){
			echo '<span><a href="?page=' .($page + 1) .'">Järgmine leht</a></span>' ."\n";
		} else {
			echo '<span>Järgmine leht</span>' ."\n";
		}
	?>
  </p>
	<?php
		echo $publicphotothumbsHTML;
	?>



</body>
</html>
