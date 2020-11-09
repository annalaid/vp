<?php
require("session.php");
require("header.php");
require("../../../config.php");
require("fnc/fnc_film.php");

$notice = "";
$selectedrole = "";
$quote = "";

if(isset($_POST["quotesubmit"])) {
  if(!empty($_POST["quoteinput"])){
  $quote = test_input($_POST["quoteinput"]);
} else {
  $notice .= " Sisesta tsitaat!";
}
if(!empty($_POST["roleinput"])){
  $selectedrole = intval($_POST["roleinput"]);
} else {
  $notice .= " Vali seos filmiga!";
}
if(!empty($quote) and !empty($selectedrole)){
  $notice = storenewquote($selectedrole, $quote);
}
}

$roleselect = readroletoselect($selectedrole);
?>

<img src="../img/vp_banner.png" alt="Veebiprogrammeerimise kursuse banner">
<h1><?php echo $_SESSION["userfirstname"] ." " .$_SESSION["userlastname"]; ?> programmeerib veebi</h1>
<p>See veebileht on loodud õppetöö käigus ning ei sisada mingit tõsiseltvõetavat sisu!</p>
<p>Leht on loodud veebiprogrammeerimise kursusel <a href="http://www.tlu.ee">Tallinna Ülikooli</a> Digitehnoloogiate instituudis.</p>
<ul>
<p><a href="?logout=1">Logi välja!</a></p>
<hr>
<li><a href="home.php">Avalehele</a></li>
</ul>

<h2>Tsitaadi lisamine</h2>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
<textarea rows="1" cols="39" name="quoteinput" id="quoteinput" placeholder="Tsitaat"><?php echo $quote; ?></textarea>
<br />
<?php echo $roleselect; ?>
<br />
<span><?php echo $notice; ?></span>
<br />
<input type="submit" name="quotesubmit" value="Salvesta tsitaat">
</form>

</body>
</html>
