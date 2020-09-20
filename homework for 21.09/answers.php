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

?>

<?php echo $nonsenshtml; ?>
<a href="home.php">Tagasi pealehele</a>
