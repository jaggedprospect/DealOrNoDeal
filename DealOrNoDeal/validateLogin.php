<?php
session_start();

if(isset($_POST["username"]) && isset($_POST["password"])){
  $file = fopen('users.txt','r');
  $username = $_POST["username"];
  $password = $_POST["password"];

  $exists = false;
  while (!feof($file)) {
    $line = fgets($file);
    $userinfo = explode(",",$line);

    if(trim($userinfo[0])==$username && trim($userinfo[1])==$password){
      $exists = true;
      break;
    }
  }
  fclose($file);

  if($exists){
    $_SESSION["username"] = $username;
    if($_SESSION["error"]) {
      unset($_SESSION["error"]);
    }
    //header("location: game.php");
    header("location: gameCaseSelect.php");
  }
  else{
    $_SESSION["error"] = "Error logging in. Check your credentials or register an account";
    header("location: login.php");
  }
}
else {
    header("location: index.html");
}
