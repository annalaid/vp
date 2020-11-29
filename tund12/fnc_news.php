<?php
	$database = "if20_anna_laid_3";

  function saveNewsData(){
    $notice = null;
    $conn = new mysqli($GLOBALS["serverhost"], $GLOBALS["serverusername"], $GLOBALS["serverpassword"], $GLOBALS["database"]);
    $conn->set_charset("utf8");
    $stmt = $conn->prepare("INSERT INTO vpnews (userid, title, content, expire, added, deleted) VALUES (?, ?, ?, ?, ?, ?)");
		echo $conn->error;
    $stmt->bind_param("issiii", $_SESSION["userid"], $newstitle, $news, $exipiredate);
    $stmt->close();
		$conn->close();
		return $notice;
  }
