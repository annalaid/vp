<?php
  $database = "if20_anna_laid_3";

  function readfilms() {
    //loeme andmebaasist
    //var_dump($GLOBALS);
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
    //valmistame ette SQL käsu
    $stmt = $conn->prepare("SELECT * FROM film");
    echo $conn->error;
    //seome tulemuse mingi muutujaga
    $stmt->bind_result($titlefromdb, $yearfromdb, $durationfromdb, $genrefromdb, $studiofromdb, $directorfromdb);
    $stmt->execute();
    $filmshtml = "\t <ol> \n";
    //võtan, kuni on
    while($stmt->fetch()) {
    	//<p>suvaline mõte </p>
    	$filmshtml .= "\t \t <li>" .$titlefromdb ."\n";
    	$filmshtml .= "\t \t \t <ul> \n";
    	$filmshtml .= "\t \t \t \t <li>Valmimisaasta: ".$yearfromdb ."</li> \n";
    	$filmshtml .= "\t \t \t \t <li>Kestus: ".$durationfromdb ." minutit</li> \n";
    	$filmshtml .= "\t \t \t \t <li>Žanr: ".$genrefromdb ."</li> \n";
    	$filmshtml .= "\t \t \t \t <li>Tootja/stuudio: ".$studiofromdb ."</li> \n";
    	$filmshtml .= "\t \t \t \t <li>Lavastaja: ".$directorfromdb ."</li> \n";
    	$filmshtml .= "\t \t \t </ul> \n";
    	$filmshtml .= "\t \t \t </li> \n";
    }
      $filmshtml .= "\t </ol> \n";

      $stmt->close();
      $conn->close();
      return $filmshtml;
    //ongi andmebaasist loetud
  } //readfilms lõppeb

function writefilm($title, $year, $duration, $genre, $studio, $director){
  $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
  $stmt = $conn->prepare("INSERT INTO film (pealkiri, aasta, kestus, zanr, tootja, lavastaja) VALUES(?,?,?,?,?,?)");
  echo $conn->error;
  $stmt->bind_param("siisss", $title, $year, $duration, $genre, $studio, $director);
  $stmt->execute();
  $stmt->close();
  $conn->close();
} //writefilm lõppeb

function readroletoselect($selectedrole) {
$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
$stmt = $conn->prepare("SELECT person_in_movie_id, first_name, last_name, title, role FROM person_in_movie JOIN person ON person_in_movie.person_id = person.person_id JOIN movie ON person_in_movie.movie_id = movie.movie_id ORDER BY title, role");
echo $conn->error; // <-- ainult õppimise jaoks!
$stmt->bind_result($idfromdb, $firstnamefromdb, $lastnamefromdb, $titlefromdb, $rolefromdb);
$stmt->execute();
$roles = "";
  while($stmt->fetch()) {
    if(!empty($rolefromdb)) {
    $roles .= '<option value ="' .$idfromdb .'"';
    if($idfromdb == $selectedrole) {
      $roles .= " selected";
    }
    $roles .= ">" .$titlefromdb ." - " .$rolefromdb ." (" .$firstnamefromdb ." " .$lastnamefromdb .")" ."</option> \n";
    }
  }
  if(!empty($roles)) {
    $notice = '<select name="roleinput">' ."\n";
    $notice .= '<option value="" selected disabled>Vali roll filmis</option>' ."\n";
    $notice .= $roles;
    $notice .= "</select> \n";
  }
$stmt->close();
$conn->close();
return $notice;
} // readroletoselect lõpeb

function storenewquote($selectedrole, $quote) {
$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
$stmt = $conn->prepare("SELECT quote_id FROM quote WHERE quote_text = ? AND person_in_movie_id = ?");
echo $conn->error; // <-- ainult õppimise jaoks!
$stmt->bind_param("si", $quote, $selectedrole);
$stmt->bind_result($idfromdb);
$stmt->execute();
if($stmt->fetch()) {
  $notice = "Selline tsitaat on juba olemas!";
}
else {
  $stmt->close();
  $stmt = $conn->prepare("INSERT INTO quote (quote_text, person_in_movie_id) VALUES(?, ?)");
  echo $conn->error; // <-- ainult õppimise jaoks!
  $stmt->bind_param("si", $quote, $selectedrole);
  if($stmt->execute()) {
    $notice = "Salvestatud!";
  }
  else {
    $notice = "Tsitaadi salvestamisel tekkis tehniline tõrge: " .$stmt->error;
  }
}
$stmt->close();
$conn->close();
return $notice;
}


?>
