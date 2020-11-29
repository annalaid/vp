<?php
	$database = "if20_anna_laid_3";

  function storeNewsData($filename, $newstitle, $news, $expire){
    $notice = null;
		$photoid = null;
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		if ($filename != null) {
			$stmt = $conn->prepare("SELECT vpnewsphotos_id FROM vpnewsphotos WHERE filename = ?");
			echo $conn->error;
			$stmt->bind_param("s", $filename);
			$stmt->bind_result($idfromdb);
			$stmt->execute();
			if($stmt->fetch()) {
				$photoid = $idfromdb;
			} else {
				$notice = 0;
			}
			$stmt->close();
		} else {
			$stmt = $conn->prepare("SELECT MAX(vpnewsphotos_id) FROM vpnewsphotos");
			echo $conn->error;
			$stmt->bind_result($photoid);
			$stmt->execute();
			$stmt->fetch();
			$stmt->close();

	    $stmt = $conn->prepare("INSERT INTO vpnews (userid, title, content, expire, vpnewsphoto_id) VALUES (?, ?, ?, ?, ?)");
			echo $conn->error;
	    $stmt->bind_param("isssi", $_SESSION["userid"], $newstitle, $news, $expire, $photoid);
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
	}
	function readNews($limit = 5){
		$photohtml = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("SELECT firstname, lastname, title, content, vpnewsphotos_id, alttext FROM vpnews JOIN vpusers ON vpnews.userid = vpusers.vpusers_id LEFT JOIN vpnewsphotos ON vpnews.photoid = vpnewsphotos.vpnewsphotos_id WHERE expire >= CURDATE() AND vpnews.deleted IS NULL ORDER BY vpnews_id DESC LIMIT ?");
		echo $conn->error;
		$stmt->bind_param("i", $limit);
		$stmt->bind_result($firstnamefromdb, $lastnamefromdb, $titlefromdb, $contentfromdb, $photoidfromdb, $alttextfromdb);
		if($stmt->execute()) {
			$temphtml = null;
			while ($stmt->fetch()){
				$temphtml .= "<h2>" .$titlefromdb ."</h2>\n";
				if ($photoidfromdb != null) {
					$temphtml .= '<img src="' ."shownewsphoto.php?photo=" .$photoidfromdb .'" alt="' .$alttextfromdb .'">' ."\n";
				}
				$temphtml .= "<p>" .htmlspecialchars_decode($contentfromdb) ."</p>\n";
				$temphtml .= "<p>Autor: " .$firstnamefromdb ." " .$lastnamefromdb ."</p>\n";
			}
			if(!empty($temphtml)) {
				$newshtml = "<div> \n" .$temphtml ."\n</div>\n";
			} else {
				$newshtml = "<p>Kahjuks uudiseid ei leitud!</p>";
			}
		} else {
			$newshtml = "<p>Kahjuks on tekkinud tehniline tõrge</p>";
		}
		$stmt->close();
		$conn->close();
		return $newshtml;
	}

	function storeNewsPhoto($filename, $alttext){
		$notice = null;
		$conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
		$stmt = $conn->prepare("INSERT INTO vpnewsphotos (userid, filename, alttext) VALUES (?, ?, ?)");
		echo $conn->error;
		$stmt->bind_param("iss", $_SESSION["userid"], $filename, $alttext);
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
