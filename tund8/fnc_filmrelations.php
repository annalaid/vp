<?php
  $database = "if20_anna_laid_3";

  function readstudiotoselect($selectedstudio){
    $notice = "<p>Kahjuks stuudioid ei leitud!</p> \n";
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
  	$stmt = $conn->prepare("SELECT production_company_id, company_name FROM production_company");
    echo $conn->error;
    $stmt->bind_result($idfromdb, $companyfromdb);
    $stmt->execute();
    $studios = "";
    while($stmt->fetch()){
      $studios .='<option value="' .$idfromdb .'"';
      if($idfromdb == $selectedstudio){
        $studios .= " selected";
      }
      $studios .= ">" .$companyfromdb . "</option> \n";
    }
    if(!empty($studios)){
      $notice = '<select name="filmstudioinput" id="filmstudioinput">' ."\n";
      $notice .= '<option value="" selected disabled>Vali stuudio/tootja</option>' ."\n";
      $notice .= $studios;
      $notice .="</select> \n";
    }
    $stmt->close();
  	$conn->close();
  	return $notice;
  }

  function readmovietoselect($selectedmovie){
  	$notice = "<p>Kahjuks filme ei leitud!</p> \n";
  	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
  	$stmt = $conn->prepare("SELECT movie_id, title FROM movie");
  	echo $conn->error;
  	$stmt->bind_result($idfromdb, $titlefromdb);
  	$stmt->execute();
  	$films = "";
  	while($stmt->fetch()){
  		$films .= '<option value="' .$idfromdb .'"';
  		if(intval($idfromdb) == $selectedmovie){
  			$films .=" selected";
  		}
  		$films .= ">" .$titlefromdb ."</option> \n";
  	}
  	if(!empty($films)){
  		$notice = '<select name="filminput" id="filminput">' ."\n";
  		$notice .= '<option value="" selected disabled>Vali film</option>' ."\n";
  		$notice .= $films;
  		$notice .= "</select> \n";
  	}
  	$stmt->close();
  	$conn->close();
  	return $notice;
  }

  function readgenretoselect($selectedgenre){
  	$notice = "<p>Kahjuks žanre ei leitud!</p> \n";
  	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
    $conn->set_charset("utf8");
    $stmt = $conn->prepare("SELECT genre_id, genre_name FROM genre");
  	echo $conn->error;
  	$stmt->bind_result($idfromdb, $genrefromdb);
  	$stmt->execute();
  	$genres = "";
  	while($stmt->fetch()){
  		$genres .= '<option value="' .$idfromdb .'"';
  		if(intval($idfromdb) == $selectedgenre){
  			$genres .=" selected";
  		}
  		$genres .= ">" .$genrefromdb ."</option> \n";
  	}
  	if(!empty($genres)){
  		$notice = '<select name="filmgenreinput" id="filmgenreinput">' ."\n";
  		$notice .= '<option value="" selected disabled>Vali žanr</option>' ."\n";
  		$notice .= $genres;
  		$notice .= "</select> \n";
  	}
  	$stmt->close();
  	$conn->close();
  	return $notice;
  }

  function readpersontoselect($selectedperson){
  $notice = "<p>Kahjuks inimesi ei leitud!</p> \n";
	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
  $conn->set_charset("utf8");
  $stmt = $conn->prepare("SELECT person_id, first_name, last_name FROM person");
	echo $conn->error;
	$stmt->bind_result($idfromdb, $firstnamefromdb, $lastnamefromdb);
	$stmt->execute();
	$persons = "";
	  while($stmt->fetch()) {
		  $persons .= '<option value ="' .$idfromdb .'"';
		  if($idfromdb == $selectedperson) {
			  $persons .= " selected";
		  }
		  $persons .= ">" .$firstnamefromdb ." " .$lastnamefromdb ."</option> \n";
	  }
	  if(!empty($persons)) {
		  $notice = '<select name="personinput" id="personinput">' ."\n";
		  $notice .= '<option value="" selected disabled>Vali isik</option>' ."\n";
		  $notice .= $persons;
		  $notice .= "</select> \n";
	  }
	$stmt->close();
	$conn->close();
	return $notice;
  }

  function readquotetoselect($selectedquote){
    $notice = "<p>Kahjuks tsitaate ei leitud!</p> \n";
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
    $conn->set_charset("utf8");
    $stmt = $conn->prepare("SELECT quote_id, quote_text FROM quote");
    echo $conn->error;
  	$stmt->bind_result($idfromdb, $textfromdb);
    $stmt->execute();
    $quotes = "";
    while($stmt->fetch()){
      $quotes .= '<option value ="' .$idfromdb .'"';
  		if($idfromdb == $selectedquote) {
  		 $quotes .= " selected";
  	}
  		 $quotes .= ">" .$textfromdb ."</option> \n";
  	  }
    if(!empty($quotes)){
  		$notice = '<select name="quoteinput" id="quoteinput">' ."\n";
  		$notice .= '<option value="" selected disabled>Vali tsitaat</option>' ."\n";
  		$notice .= $quotes;
  		$notice .= "</select> \n";
  	}
    $stmt->close();
  	$conn->close();
  	return $notice;
  }

  function readpositiontoselect($selectedposition){
    $notice = "<p>Kahjuks rolle ei leitud!</p> \n";
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
    $conn->set_charset("utf8");
    $stmt = $conn->prepare("SELECT position_id, position_name FROM position");
    echo $conn->error;
  	$stmt->bind_result($idfromdb, $positionnamefromdb);
    $stmt->execute();
    $positions = "";
    while($stmt->fetch()){
      $positions .= '<option value="' .$idfromdb .'"';
      if(intval($idfromdb) == $selectedposition){
        $positions .=" selected";
      }
      $positions .= ">" .$positionnamefromdb ."</option> \n";
    }
    if(!empty($positions)){
  		$notice = '<select name="positioninput" id="positioninput">' ."\n";
  		$notice .= '<option value="" selected disabled>Vali roll</option>' ."\n";
  		$notice .= $positions;
  		$notice .= "</select> \n";
  	}
    $stmt->close();
  	$conn->close();
  	return $notice;
  }

  function storenewgenrerelation($selectedfilm, $selectedgenre){
  	$notice = "";
  	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
    $conn->set_charset("utf8");
    $stmt = $conn->prepare("SELECT movie_genre_id FROM movie_genre WHERE movie_id = ? AND genre_id = ?");
  	echo $conn->error;
  	$stmt->bind_param("ii", $selectedfilm, $selectedgenre);
  	$stmt->bind_result($idfromdb);
  	$stmt->execute();
  	if($stmt->fetch()){
  		$notice = "Selline seos on juba olemas!";
  	} else {
  		$stmt->close();
  		$stmt = $conn->prepare("INSERT INTO movie_genre (movie_id, genre_id) VALUES(?,?)");
  		echo $conn->error;
  		$stmt->bind_param("ii", $selectedfilm, $selectedgenre);
  		if($stmt->execute()){
  			$notice = "Uus seos edukalt salvestatud!";
  		} else {
  			$notice = "Seose salvestamisel tekkis tehniline tõrge: " .$stmt->error;
  		}
  	}

	$stmt->close();
	$conn->close();
	return $notice;
}

  function storenewstudiorelation($selectedfilm, $selectedstudio){
  	$notice = "";
  	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
    $conn->set_charset("utf8");
    $stmt = $conn->prepare("SELECT movie_by_production_comoany_id FROM movie_by_production_company WHERE movie_movie_id = ? AND production_company_id = ?");
  	echo $conn->error;
  	$stmt->bind_param("ii", $selectedfilm, $selectedstudio);
  	$stmt->bind_result($idfromdb);
  	$stmt->execute();
  	if($stmt->fetch()){
  		$notice = "Selline seos on juba olemas!";
  	} else {
  		$stmt->close();
  		$stmt = $conn->prepare("INSERT INTO movie_by_production_company (movie_movie_id, production_company_id) VALUES(?,?)");
  		echo $conn->error;
  		$stmt->bind_param("ii", $selectedfilm, $selectedstudio);
  		if($stmt->execute()){
  			$notice = "Uus seos edukalt salvestatud!";
  		} else {
  			$notice = "Seose salvestamisel tekkis tehniline tõrge: " .$stmt->error;
  		}
  	}

  	$stmt->close();
  	$conn->close();
  	return $notice;
  }

  function storenewpersoninmovierelation($selectedfilm, $selectedpersoninmovie, $selectedpositioninmovie){
    $notice = "";
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
    $conn->set_charset("utf8");
    $stmt = $conn->prepare("SELECT person_in_movie_id FROM peron_in_movie WHERE person_id = ? AND movie_id = ? AND position_id = ?");
    echo $conn->error;
    $stmt->bind_param("iii", $selectedfilm, $selectedpersoninmovie, $selectedpositioninmovie);
    $stmt->bind_result($idfromdb);
    $stmt->execute();
    if($stmt->fetch()){
      $notice = "Selline seos on juba olemas!";
    } else {
      $stmt->close();
      $stmt = $conn->prepare("INSERT INTO person_in_movie (person_id, movie_id, position_id) VALUES(?,?,?)");
      echo $conn->error;
      $stmt->bind_param("iii", $selectedfilm, $selectedpersoninmovie, $selectedpositioninmovie);
      if($stmt->execute()){
  			$notice = "Uus seos edukalt salvestatud!";
  		} else {
  			$notice = "Seose salvestamisel tekkis tehniline tõrge: " .$stmt->error;
  		}
    }

    $stmt->close();
  	$conn->close();
  	return $notice;
  }

  function storenewquoterelation($selectedpersoninmovie, $selectedfilm, $selectedquote){
    $notice = "";
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
    $conn->set_charset("utf8");
    $stmt = $conn->prepare("SELECT quote_id FROM quote WHERE persin_in_movie_id = ?");
    echo $conn->error;
    $stmt->bind_param("iii", $selectedpersoninmovie, $selectedfilm, $selectedquote);
    $stmt->bind_result($idfromdb);
    $stmt->execute();
    if($stmt->fetch()){
      $notice = "Selline seos on juba olemas!";
    } else {
      $stmt->close();
      $stmt = $conn->prepare("INSERT INTO quote (person_in_movie_id) VALUES (?)");
      echo $conn->error;
      $stmt->bind_param("iii", $selectedpersoninmovie, $selectedfilm, $selectedquote);
      if($stmt->execute()){
  			$notice = "Uus seos edukalt salvestatud!";
  		} else {
  			$notice = "Seose salvestamisel tekkis tehniline tõrge: " .$stmt->error;
  		}
    }

    $stmt->close();
  	$conn->close();
  	return $notice;
  }


?>
