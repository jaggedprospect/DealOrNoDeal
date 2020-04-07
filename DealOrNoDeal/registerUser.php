<?php
if(isset($_POST["username"]) && isset($_POST["password"])){
  $file = fopen('users.txt', 'a');
  $username = $_POST["username"];
  $password = $_POST["password"];
  fputs($file,$username.",".$password."\r\n");
  fclose($file);
  $_SESSION["username"] = $username;
  header("location: login.php");
} else {
    header("location: index.html");
}
?>