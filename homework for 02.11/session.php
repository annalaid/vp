<?php
session_start();

//kui pole sisseloginud
if(!isset($_SESSION["userid"])){
  //jõugu sisselogimise lehele
  header("Location: page.php");
}
//väljalogimine
if(isset($_GET["logout"])){
  session_destroy();
   header("Location: page.php");
   exit();
}
