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

	function readPublicPhotosThumbsPage($privacy, $limit, $page){
		$skip = ($page - 1) * $limit;
		$photosHTML = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy>=? AND deleted IS NULL ORDER BY vpphotos_id DESC LIMIT ?, ?");
		echo $conn->error;
		$stmt->bind_param("iii", $privacy, $skip, $limit);
		$stmt->bind_result($filenamefromdb, $alttextfromdb);
		$stmt->execute();
		$tempHTML = null;
		while($stmt->fetch()){
			//<img src="xxx.yyy" alt="jutt">
			$tempHTML .= '<div class="thumbgallery">' ."\n \t";
			$tempHTML .= '<img src="' .$GLOBALS["thumbphotodir"] .$filenamefromdb .'" alt="' .$alttextfromdb .'" class="thumbs">' ."\n";
			$tempHTML .= "</div> \n";
		}
		if(!empty($tempHTML)){
			$photosHTML =  '<div class="galleryarea">' ."\n" . $tempHTML ."\n </div> \n";
		} else {
			$photosHTML = "<p>Kahjuks galeriipilte ei leitud!</p> \n";
		}
		$stmt->close();
		$conn->close();
		return $photosHTML;
	}

	function readPrivatePhotosThumbsPage($privacy, $limit, $page){
		$skip = ($page - 1) * $limit;
		$photosHTML = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy>=? AND deleted IS NULL ORDER BY vpphotos_id DESC LIMIT ?, ?");
		echo $conn->error;
		$stmt->bind_param("iii", $privacy, $skip, $limit);
		$stmt->bind_result($filenamefromdb, $alttextfromdb);
		$stmt->execute();
		$tempHTML = null;
		while($stmt->fetch()){
			//<img src="xxx.yyy" alt="jutt">
			$tempHTML .= '<div class="thumbgallery">' ."\n \t";
			$tempHTML .= '<img src="' .$GLOBALS["thumbphotodir"] .$filenamefromdb .'" alt="' .$alttextfromdb .'" class="thumbs">' ."\n";
			$tempHTML .= "</div> \n";
		}
		if(!empty($tempHTML)){
			$photosHTML =  '<div class="galleryarea">' ."\n" . $tempHTML ."\n </div> \n";
		} else {
			$photosHTML = "<p>Kahjuks galeriipilte ei leitud!</p> \n";
		}
		$stmt->close();
		$conn->close();
		return $photosHTML;
	}

	function readPrivatePhotosThumbs($privacy){
		$photosHTML = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy>=? AND deleted IS NULL");
		echo $conn->error;
		$stmt->bind_param("i", $privacy);
		$stmt->bind_result($filenamefromdb, $alttextfromdb);
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

	function countPrivatePhotos($privacy){
		$photocount = 0;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT COUNT(vpphotos_id) FROM vpphotos WHERE privacy>=? AND deleted IS NULL");
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

	function readPublicPhotosThumbs($privacy){
		$photosHTML = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT filename, alttext FROM vpphotos WHERE privacy>=? AND deleted IS NULL");
		echo $conn->error;
		$stmt->bind_param("i", $privacy);
		$stmt->bind_result($filenamefromdb, $alttextfromdb);
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
		$stmt = $conn->prepare("SELECT COUNT(vpphotos_id) FROM vpphotos WHERE privacy>=? AND deleted IS NULL");
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
