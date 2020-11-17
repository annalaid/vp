<?php
  require("session.php");
  header("Content-type: image/jpeg");
  readfile("../photoupload_normal/" .$_REQUEST["photo"]);
