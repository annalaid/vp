<?php
  $database = "if20_anna_laid_3";

  function readpersons($sortby, $sortorder){
  	$notice = "<p>Kahjuks isikuid ei leitud!</p> \n";
  	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
    $conn->set_charset("utf8");
    $SQLsentence = "SELECT first_name, last_name, birth_date FROM person";
    if($sortby == 0 and $sortorder == 0){
      $stmt = $conn->prepare($SQLsentence);
    }
    if($sortby == 3){
      if($sortorder == 2){
        $stmt = $conn->prepare($SQLsentence ." ORDER BY birth_date DESC");
      } else {
        $stmt = $conn->prepare($SQLsentence ." ORDER BY birth_date");
      }
    }
    if($sortby == 2){
      if($sortorder == 2){
        $stmt = $conn->prepare($SQLsentence ." ORDER BY last_name DESC");
      } else {
        $stmt = $conn->prepare($SQLsentence ." ORDER BY last_name");
      }
    }
    if($sortby == 1){
      if($sortorder == 2){
        $stmt = $conn->prepare($SQLsentence ." ORDER BY first_name DESC");
      } else {
        $stmt = $conn->prepare($SQLsentence ." ORDER BY first_name");
      }
    }
    echo $conn->error;
  	$stmt->bind_result($firstnamefromdb, $lastnamefromdb, $birthdatefromdb);
  	$stmt->execute();
  	$lines = "";
  	while($stmt->fetch()){
      $lines .= "<tr> \n";
  		$lines .= "\t <td>" .$firstnamefromdb ."</td> \n";
  		$lines .= "<td>" .$lastnamefromdb ."</td>";
  		$lines .= "<td>" .$birthdatefromdb ."</td> \n";
      $lines .= "</tr> \n";
  	}
  	if(!empty($lines)){
      $notice = "<table> \n";
      $notice .= "<tr> \n";
      $notice .= '<th>Eesnimi &nbsp; <a href="?sortby=1&sortorder=1">&uarr;</a> &nbsp;<a href="?sortby=1&sortorder=2">&darr;</a> </th>' ."\n";
      $notice .= '<th>Perekonnanimi &nbsp;<a href="?sortby=2&sortorder=1">&uarr;</a> &nbsp;<a href="?sortby=2&sortorder=2">&darr;</a> </th>' ."\n";
      $notice .= '<th>Sünniaeg &nbsp; <a href="?sortby=3&sortorder=1">&uarr;</a>&nbsp; <a href="?sortby=3&sortorder=2">&darr;</a></th>' ."\n";
      $notice .= "</tr> \n";
  		$notice .= $lines;
      $notice .= "</table> \n";
  	}
  	$stmt->close();
  	$conn->close();
  	return $notice;
  }

  function readpersonsinfilm($sortby, $sortorder){
  	$notice = "<p>Kahjuks filme ja tegelasi ei leitud!</p> \n";
  	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
    $conn->set_charset("utf8");
    $SQLsentence = "SELECT first_name, last_name, role, title FROM person JOIN person_in_movie ON person.person_id = person_in_movie.person_id JOIN movie ON movie.movie_id = person_in_movie.movie_id";
    if($sortby == 0 and $sortorder == 0){
      $stmt = $conn->prepare($SQLsentence);
    }
    if($sortby == 4){
      if($sortorder == 2){
        $stmt = $conn->prepare($SQLsentence ." ORDER BY title DESC");
      } else {
        $stmt = $conn->prepare($SQLsentence ." ORDER BY title");
      }
    }
    if($sortby == 3){
      if($sortorder == 2){
        $stmt = $conn->prepare($SQLsentence ." ORDER BY role DESC");
      } else {
        $stmt = $conn->prepare($SQLsentence ." ORDER BY role");
      }
    }
    if($sortby == 2){
      if($sortorder == 2){
        $stmt = $conn->prepare($SQLsentence ." ORDER BY last_name DESC");
      } else {
        $stmt = $conn->prepare($SQLsentence ." ORDER BY last_name");
      }
    }
    if($sortby == 1){
      if($sortorder == 2){
        $stmt = $conn->prepare($SQLsentence ." ORDER BY first_name DESC");
      } else {
        $stmt = $conn->prepare($SQLsentence ." ORDER BY first_name");
      }
    }
    echo $conn->error;
  	$stmt->bind_result($firstnamefromdb, $lastnamefromdb, $rolefromdb, $titlefromdb);
  	$stmt->execute();
  	$lines = "";
  	while($stmt->fetch()){
      $lines .= "<tr> \n";
  		$lines .= "\t <td>" .$firstnamefromdb ." " .$lastnamefromdb ."</td> \n";
  		$lines .= "<td>" .$rolefromdb ."</td>";
  		$lines .= "<td>" .$titlefromdb ."</td> \n";
      $lines .= "</tr> \n";
  	}
  	if(!empty($lines)){
      $notice = "<table> \n";
      $notice .= "<tr> \n";
      $notice .= '<th><a href="?sortby=1&sortorder=1">&uarr;</a> &nbsp;<a href="?sortby=1&sortorder=2">&darr;</a> &nbsp; Isik &nbsp; <a href="?sortby=2&sortorder=1">&uarr;</a> &nbsp;<a href="?sortby=2&sortorder=2">&darr;</a> </th>' ."\n";
      $notice .= '<th>Roll &nbsp;<a href="?sortby=3&sortorder=1">&uarr;</a> &nbsp;<a href="?sortby=3&sortorder=2">&darr;</a> </th>' ."\n";
      $notice .= '<th>Film &nbsp; <a href="?sortby=4&sortorder=1">&uarr;</a>&nbsp; <a href="?sortby=4&sortorder=2">&darr;</a></th>' ."\n";
      $notice .= "</tr> \n";
  		$notice .= $lines;
      $notice .= "</table> \n";
  	}
  	$stmt->close();
  	$conn->close();
  	return $notice;
  }

  function readfilms($sortby, $sortorder){
  	$notice = "<p>Kahjuks filme ei leitud!</p> \n";
  	$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
    $conn->set_charset("utf8");
    $SQLsentence = "SELECT title, production_year, duration, description FROM movie";

    if($sortby == 0 and $sortorder == 0){
      $stmt = $conn->prepare($SQLsentence);
    }
    if($sortby == 3){
      if($sortorder == 2){
        $stmt = $conn->prepare($SQLsentence ." ORDER BY duration DESC");
      } else {
        $stmt = $conn->prepare($SQLsentence ." ORDER BY duration");
      }
    }
    if($sortby == 2){
      if($sortorder == 2){
        $stmt = $conn->prepare($SQLsentence ." ORDER BY production_year DESC");
      } else {
        $stmt = $conn->prepare($SQLsentence ." ORDER BY production_year");
      }
    }
    if($sortby == 1){
      if($sortorder == 2){
        $stmt = $conn->prepare($SQLsentence ." ORDER BY title DESC");
      } else {
        $stmt = $conn->prepare($SQLsentence ." ORDER BY title");
      }
    }
    echo $conn->error;
  	$stmt->bind_result($titlefromdb, $yearfromdb, $durationfromdb, $descriptionfromdb);
  	$stmt->execute();
  	$lines = "";
  	while($stmt->fetch()){
      $lines .= "<tr> \n";
  		$lines .= "\t <td>" .$titlefromdb ."</td> \n";
  		$lines .= "<td>" .$yearfromdb ."</td>";
  		$lines .= "<td>" .$durationfromdb ."</td> \n";
      if(!empty($descfromdb)) {
  			$lines .= "<td>" .$descfromdb ."</td> </tr> \n";
  		}
  		else {
        $lines .= "</tr> \n";
  	}
  }
  	if(!empty($lines)){
      $notice = "<table> \n";
      $notice .= "<tr> \n";
      $notice .= '<th>Pealkiri &nbsp; <a href="?filmsortby=1&filmsortorder=1">&uarr;</a> &nbsp;<a href="?filmsortby=1&filmsortorder=2">&darr;</a> </th>' ."\n";
      $notice .= '<th>Tootmisaasta &nbsp;<a href="?filmsortby=2&filmsortorder=1">&uarr;</a> &nbsp;<a href="?filmsortby=2&filmsortorder=2">&darr;</a> </th>' ."\n";
      $notice .= '<th>Kestus (min) &nbsp; <a href="?filmsortby=3&filmsortorder=1">&uarr;</a>&nbsp; <a href="?filmsortby=3&filmsortorder=2">&darr;</a></th>' ."\n";
      $notice .= '<th>Filmi kirjeldus</th>' ."\n";
      $notice .= "</tr> \n";
  		$notice .= $lines;
      $notice .= "</table> \n";
  	}
  	$stmt->close();
  	$conn->close();
  	return $notice;
  }

  function readquotes($sortby, $sortorder){
    $notice = "<p>Kahjuks tsitaate ei leitud!</p> \n";
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
    $conn->set_charset("utf8");
    $SQLsentence = "SELECT first_name, last_name, role, title, quote_text FROM quote JOIN person_in_movie ON quote.person_in_movie_id = person_in_movie.person_in_movie_id JOIN person ON person_in_movie.person_id = person.person_id JOIN movie ON person_in_movie.movie_id = movie.movie_id";
    if($sortby == 0 and $sortorder == 0){
      $stmt = $conn->prepare($SQLsentence);
    }
    if($sortby == 5){
      if($sortorder == 2){
        $stmt = $conn->prepare($SQLsentence ." ORDER BY quote_text DESC");
      } else {
        $stmt = $conn->prepare($SQLsentence ." ORDER BY quote_text");
      }
    }
    if($sortby == 4){
      if($sortorder == 2){
        $stmt = $conn->prepare($SQLsentence ." ORDER BY title DESC");
      } else {
        $stmt = $conn->prepare($SQLsentence ." ORDER BY title");
      }
    }
    if($sortby == 3){
      if($sortorder == 2){
        $stmt = $conn->prepare($SQLsentence ." ORDER BY role DESC");
      } else {
        $stmt = $conn->prepare($SQLsentence ." ORDER BY role");
      }
    }
    if($sortby == 2){
      if($sortorder == 2){
        $stmt = $conn->prepare($SQLsentence ." ORDER BY last_name DESC");
      } else {
        $stmt = $conn->prepare($SQLsentence ." ORDER BY last_name");
      }
    }
    if($sortby == 1){
      if($sortorder == 2){
        $stmt = $conn->prepare($SQLsentence ." ORDER BY first_name DESC");
      } else {
        $stmt = $conn->prepare($SQLsentence ." ORDER BY first_name");
      }
    }
    echo $conn->error;
    $stmt->bind_result($firstnamefromdb, $lastnamefromdb, $rolefromdb, $titlefromdb, $quotetextfromdb);
    $stmt->execute();
    $lines = "";
    while($stmt->fetch()){
      $lines .= "<tr> \n";
      $lines .= "\t <td>" .$firstnamefromdb ." " .$lastnamefromdb ."</td> \n";
      $lines .= "<td>" .$rolefromdb ."</td> \n";
      $lines .= "<td>" .$titlefromdb ."</td> \n";
      $lines .= "<td>" .$quotetextfromdb ."</td> \n";
      $lines .= "</tr> \n";
    }
    if(!empty($lines)){
      $notice = "<table> \n";
      $notice .= "<tr> \n";
      $notice .= '<th><a href="?sortby=3&sortorder=1">&uarr;</a> &nbsp;<a href="?sortby=3&sortorder=2">&darr;</a> &nbsp; Näitleja &nbsp; <a href="?sortby=4&sortorder=1">&uarr;</a> &nbsp;<a href="?sortby=4&sortorder=2">&darr;</a> </th>' ."\n";
      $notice .= '<th>Roll &nbsp;<a href="?sortby=1&sortorder=1">&uarr;</a> &nbsp;<a href="?sortby=1&sortorder=2">&darr;</a> </th>' ."\n";
      $notice .= '<th>Film &nbsp; <a href="?sortby=2&sortorder=1">&uarr;</a>&nbsp; <a href="?sortby=2&sortorder=2">&darr;</a></th>' ."\n";
      $notice .= '<th>Tsitaat &nbsp;<a href="?sortby=5&sortorder=1">&uarr;</a> &nbsp;<a href="?sortby=5&sortorder=2">&darr;</a> </th>' ."\n";
      $notice .= "</tr> \n";
      $notice .= $lines;
      $notice .= "</table> \n";
    }
    $stmt->close();
    $conn->close();
    return $notice;
  }

  function readgenres($sortby, $sortorder){
    $notice = "<p>Kahjuks žanreid ei leitud!</p> \n";
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
    $conn->set_charset("utf8");
    $SQLsentence = "SELECT title, genre_name FROM movie JOIN movie_genre ON movie_genre.movie_id = movie.movie_id JOIN genre ON movie_genre.genre_id = genre.genre_id";
    if($sortby == 0 and $sortorder == 0){
      $stmt = $conn->prepare($SQLsentence);
    }
    if($sortby == 2){
      if($sortorder == 2){
        $stmt = $conn->prepare($SQLsentence ." ORDER BY description DESC");
      } else {
        $stmt = $conn->prepare($SQLsentence ." ORDER BY description");
      }
    }
    if($sortby == 1){
      if($sortorder == 2){
        $stmt = $conn->prepare($SQLsentence ." ORDER BY title DESC");
      } else {
        $stmt = $conn->prepare($SQLsentence ." ORDER BY title");
      }
    }
    echo $conn->error;
    $stmt->bind_result($titlefromdb, $genrefromdb);
    $stmt->execute();
    $lines = "";
    while($stmt->fetch()){
      $lines .= "<tr> \n";
      $lines .= "\t <td>" .$titlefromdb ."</td> \n";
      $lines .= "<td>" .$genrefromdb ."</td> \n";
      $lines .= "</tr> \n";
    }
    if(!empty($lines)){
      $notice = "<table> \n";
      $notice .= "<tr> \n";
      $notice .= '<th>Film &nbsp;<a href="?sortby=1&sortorder=1">&uarr;</a> &nbsp;<a href="?sortby=1&sortorder=2">&darr;</a> </th>' ."\n";
      $notice .= '<th>Žanr &nbsp; <a href="?sortby=2&sortorder=1">&uarr;</a>&nbsp; <a href="?sortby=2&sortorder=2">&darr;</a></th>' ."\n";
      $notice .= "</tr> \n";
      $notice .= $lines;
      $notice .= "</table> \n";
    }
    $stmt->close();
    $conn->close();
    return $notice;
  }
  function readstudios($sortby, $sortorder) {
    $notice = "<p>Kahjuks stuudioid ei leitud!</p> \n";
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$SQLsentence = "SELECT title, company_name FROM movie JOIN movie_by_production_company ON movie_by_production_company.movie_movie_id = movie.movie_id JOIN production_company ON movie_by_production_company.production_company_id = production_company.production_company_id";
		if($sortby == 0 and $sortorder == 0) {
			$stmt = $conn->prepare($SQLsentence);
		}

		if($sortby == 2){
			if($sortorder == 2) {
				$stmt = $conn->prepare($SQLsentence ." ORDER BY company_name DESC");
			} else {
				$stmt = $conn->prepare($SQLsentence ." ORDER BY company_name");
			}
		}

		if($sortby == 1){
			if($sortorder == 2) {
				$stmt = $conn->prepare($SQLsentence ." ORDER BY title DESC");
			} else {
				$stmt = $conn->prepare($SQLsentence ." ORDER BY title");
			}
		}

		echo $conn->error;
		$stmt->bind_result($titlefromdb, $companyfromdb);
		$stmt->execute();
		$lines = null;
		while($stmt->fetch()) {
			$lines .= "<tr> \n";
			$lines .= "\t <td>" .$titlefromdb ."</td> \n";
			$lines .= "<td>" .$companyfromdb ."</td> \n";
			$lines .= "</tr> \n";
		}
		if(!empty($lines)) {
			$notice = "<table> \n";
			$notice .= "<tr> \n";
			$notice .= '<th>Filmi pealkiri &nbsp;<a href="?sortby=1&sortorder=1">&uarr;</a> &nbsp;<a href="?sortby=1&sortorder=2">&darr;</a>' ."\n";
			$notice .= '<th>Tootmisfirma nimi &nbsp;<a href="?sortby=2&sortorder=1">&uarr;</a> &nbsp;<a href="?sortby=2&sortorder=2">&darr;</a> </th>' ."\n";
			$notice .= "</tr> \n";
			$notice .= $lines;
			$notice .= "</table> \n";
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
  function readgenreinfo($sortby, $sortorder) {
    $notice = "<p>Kahjuks žanreid ei leitud!</p> \n";
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$SQLsentence = "SELECT genre_name, description FROM genre";
		if($sortby == 0 and $sortorder == 0) {
			$stmt = $conn->prepare($SQLsentence);
		}

		if($sortby == 2){
			if($sortorder == 2) {
				$stmt = $conn->prepare($SQLsentence ." ORDER BY description DESC");
			} else {
				$stmt = $conn->prepare($SQLsentence ." ORDER BY description");
			}
		}

		if($sortby == 1){
			if($sortorder == 2) {
				$stmt = $conn->prepare($SQLsentence ." ORDER BY genre_name DESC");
			} else {
				$stmt = $conn->prepare($SQLsentence ." ORDER BY genre_name");
			}
		}

		echo $conn->error;
		$stmt->bind_result($genrefromdb, $descriptionfromdb);
		$stmt->execute();
		$lines = null;
		while($stmt->fetch()) {
			$lines .= "<tr> \n";
			$lines .= "\t <td>" .$genrefromdb ."</td> \n";
			$lines .= "<td>" .$descriptionfromdb ."</td> \n";
			$lines .= "</tr> \n";
		}
		if(!empty($lines)) {
			$notice = "<table> \n";
			$notice .= "<tr> \n";
			$notice .= '<th>Žanr &nbsp;<a href="?sortby=1&sortorder=1">&uarr;</a> &nbsp;<a href="?sortby=1&sortorder=2">&darr;</a>' ."\n";
			$notice .= '<th>Kirjeldus &nbsp;<a href="?sortby=2&sortorder=1">&uarr;</a> &nbsp;<a href="?sortby=2&sortorder=2">&darr;</a> </th>' ."\n";
			$notice .= "</tr> \n";
			$notice .= $lines;
			$notice .= "</table> \n";
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}

  function readpositions($sortby, $sortorder) {
    $notice = "<p>Kahjuks postitsioone ei leitud!</p> \n";
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$SQLsentence = "SELECT position_name, description FROM position";
		if($sortby == 0 and $sortorder == 0) {
			$stmt = $conn->prepare($SQLsentence);
		}

		if($sortby == 2){
			if($sortorder == 2) {
				$stmt = $conn->prepare($SQLsentence ." ORDER BY description DESC");
			} else {
				$stmt = $conn->prepare($SQLsentence ." ORDER BY description");
			}
		}

		if($sortby == 1){
			if($sortorder == 2) {
				$stmt = $conn->prepare($SQLsentence ." ORDER BY position_name DESC");
			} else {
				$stmt = $conn->prepare($SQLsentence ." ORDER BY position_name");
			}
		}

		echo $conn->error;
		$stmt->bind_result($positionnamefromdb, $descriptionfromdb);
		$stmt->execute();
		$lines = null;
		while($stmt->fetch()) {
			$lines .= "<tr> \n";
			$lines .= "\t <td>" .$positionnamefromdb ."</td> \n";
			$lines .= "<td>" .$descriptionfromdb ."</td> \n";
			$lines .= "</tr> \n";
		}
		if(!empty($lines)) {
			$notice = "<table> \n";
			$notice .= "<tr> \n";
			$notice .= '<th>Positsioon &nbsp;<a href="?sortby=1&sortorder=1">&uarr;</a> &nbsp;<a href="?sortby=1&sortorder=2">&darr;</a>' ."\n";
			$notice .= '<th>Kirjeldus &nbsp;<a href="?sortby=2&sortorder=1">&uarr;</a> &nbsp;<a href="?sortby=2&sortorder=2">&darr;</a> </th>' ."\n";
			$notice .= "</tr> \n";
			$notice .= $lines;
			$notice .= "</table> \n";
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}
?>
