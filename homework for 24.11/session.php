<?php
require("classes/Session.class.php");
  //sessioon, mis katkeb, kui brauser suletakse ja on kättesaadav ainult meie domeenis, meie lehele
  SessionManager::sessionStart("vp", 0, "/~anna/", "greeny.cs.tlu.ee");

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
