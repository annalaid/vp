<?php
  require("../../../config.php");
  require("../../../config_photo.php");
  $database = "if20_anna_laid_3";

  $output = "../img/wrong.png";
  $type = "image/png";

  $conn = new mysqli($serverhost, $serverusername, $serverpassword, $database);
  $stmt = $conn->prepare("SELECT filename FROM vpnewsphotos WHERE vpnewsphotos_id = ? AND deleted IS NULL");
  $stmt->bind_param("i", $_REQUEST["photo"]);
  $stmt->bind_result($filenamefromdb);
  if($stmt->execute()) {
      if ($stmt->fetch()) {
          $output = $newsphotodir .$filenamefromdb;
          $check = getimagesize($output);
          if($check["mime"] == "image/jpeg" or $check["mime"] == "image/png" or $check["mime"] == "image/gif"){
              $type = $check["mime"];
          }
      }
  }
  $stmt->close();
  $conn->close();
  header("Content-type: " .$type);
  readfile($output);
