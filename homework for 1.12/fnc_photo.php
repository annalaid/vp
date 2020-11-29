<?php
	$database = "if20_anna_laid_3";

	function storePhotoData($filename, $alttext, $privacy){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$conn->set_charset("utf8");
		$stmt = $conn->prepare("INSERT INTO vpphotos (userid, filename, alttext, privacy) VALUES (?, ?, ?, ?)");
		echo $conn->error;
		$stmt->bind_param("issi", $_SESSION["userid"], $filename, $alttext, $privacy);
		if($stmt->execute()){
			$notice = 1;
		} else {
			//echo $stmt->error;
			$notice = 0;
		}
		$stmt->close();
		$conn->close();
		return $notice;
	}

	function readPublicPhotosThumbsPage($privacy, $limit, $page = 1){
		$photohtml = null;
		$skip = ($page - 1) * $limit;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		//$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy >= ? AND deleted IS NULL ORDER BY vpphotos_id DESC LIMIT ?");
		//$stmt = $conn->prepare("SELECT vpphotos_id, filename, alttext FROM vpphotos WHERE privacy >= ? AND deleted IS NULL ORDER BY vpphotos_id DESC LIMIT ?,?");
		$stmt = $conn->prepare("SELECT vpphotos.vpphotos_id, vpusers.firstname, vpusers.lastname, vpphotos.filename, vpphotos.alttext, AVG(vpphotoratings.rating) as AvgValue FROM vpphotos JOIN vpusers ON vpphotos.userid = vpusers.vpusers_id LEFT JOIN vpphotoratings ON vpphotoratings.photoid = vpphotos.vpphotos_id WHERE vpphotos.privacy >= ? AND deleted IS NULL GROUP BY vpphotos.vpphotos_id DESC LIMIT ?, ?");
		echo $conn->error;
		$stmt->bind_param("iii", $privacy, $skip, $limit);
		$stmt->bind_result($idfromdb, $firstnamefromdb, $lastnamefromdb, $filenamefromdb, $alttextfromdb, $avgfromdb);
		$stmt->execute();
		$temphtml = null;
		while($stmt->fetch()){
			//<div class="thumbgallery">
			//<img src="failinimi.laiend" alt="alternatiivtekst" class="thumbs" data-fn="failinim.laiend" data-id="7">
			//<p>Eesnimi Perekonnanimi</p>
			//<p id="score7">Hinne: 2.8</p>
			//</div>
			$temphtml .= '<div class="thumbgallery">' ."\n";
			$temphtml .= '<img src="' .$GLOBALS["thumbphotodir"] .$filenamefromdb .'" alt="' .$alttextfromdb .'"  class="thumbs" data-fn="' .$filenamefromdb .'" data-id="' .$idfromdb .'">' ."\n";
			$temphtml .= "<p>" .$firstnamefromdb ." " .$lastnamefromdb ."<p> \n";
			$temphtml .= '<p id="score' .$idfromdb .'">';
			if($avgfromdb == 0){
				$temphtml .= "Pole hinnatud";
			} else {
				$temphtml .= "Hinne: " .round($avgfromdb, 2);
			}
			$temphtml .= "</p> \n";
			$temphtml .= "</div> \n";
		}
		if(!empty($temphtml)){
			$photohtml = '<div id="galleryarea" class="galleryarea">' ."\n" .$temphtml . "\n </div> \n";
		} else {
			$photohtml = "<p>Kahjuks galeriipilte ei leitud!</p> \n";
		}
		$stmt->close();
		$conn->close();
		return $photohtml;
	}


	function readPublicPhotosThumbs($privacy){
		$photosHTML = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy >= ? AND deleted IS NULL ORDER BY vpphotos_id DESC");
		echo $conn->error;
		$stmt->bind_param("i", $privacy);
		$stmt->bind_result( $filenamefromdb, $alttextfromdb);
		$stmt->execute();
		$tempHTML = null;
		while($stmt->fetch()){
			//<img src="xxx.yyy" alt="jutt">
			$tempHTML .= '<img src="' .$GLOBALS["thumbphotodir"] .$filenamefromdb .'" alt="' .$alttextfromdb .'">' ."\n";
		}
		if(!empty($tempHTML)){
			$photosHTML = "<div> \n" . $tempHTML ."\n </div> \n";
		} else {
			$photosHTML = "<p>Kahjuks galeriipilte ei leitud!</p> \n";
		}
		$stmt->close();
		$conn->close();
		return $photosHTML;
	}

	function countPublicPhotos($privacy){
		$photocount = 0;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT COUNT(vpphotos_id) FROM vpphotos WHERE privacy >= ? AND deleted IS NULL");
		echo $conn->error;
		$stmt->bind_param("i", $privacy);
		$stmt->bind_result($photocountfromdb);
		$stmt->execute();
		if($stmt->fetch()){
			$photocount = $photocountfromdb;
		}
		$stmt->close();
		$conn->close();
		return $photocount;
	}

	function readNewestPublicPhoto() {
		$photohtml = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE vpphotos_id = (SELECT MAX(vpphotos_id) FROM vpphotos WHERE privacy = 3 AND deleted IS NULL);");
		echo $conn->error;
		$stmt->bind_result($filenamefromdb, $alttextfromdb);
		if($stmt->execute()) {
			$temphtml = null;
			if ($stmt->fetch()) {
				$temphtml .= '<img src="' .$GLOBALS["normalphotodir"] .$filenamefromdb .'" alt="' .$alttextfromdb .'">' ."\n";
			}
			if(!empty($temphtml)) {
				$photohtml = "<div> \n" .$temphtml ."\n</div>\n";
			}
			else {
				$photohtml = "<p>Kahjuks galeriipilte ei leitud!</p>";
			}
		}
		else {
			$photohtml = "<p>Kahjuks tekkis tehniline tõrge</p>";
		}

		$stmt->close();
		$conn->close();
		return $photohtml;
	}
